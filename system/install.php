<?php
/**
 * Land Istanbul autoblog installer.
 *
 * Runs on the Hostinger server after every Git pull of this repository (Composer post-install hook)
 * and can also be run by cron:  php /home/<user>/domains/landistanbul.com/public_html/autoblog/system/install.php
 *
 * 1. Backs up the original site files once (to /_private/backups).
 * 2. Rebuilds the tax calculator pages (EN/AR/RU, Turkish lira only).
 * 3. Patches the homepage (assets for the valuation promos, small HTML fixes, blog feed).
 * 4. Installs the system files from this repo (generator, valuation pages, mail handler, CSS, JS) when they changed.
 * 5. Copies post images to /blog-images/auto/, flattens posts/*.json into /_private/blog-auto.json.
 * 6. Regenerates all blog pages, indexes, valuation pages and the sitemap.
 * 7. Shrinks oversized blog images (originals kept in /_private/backups/blog-images/).
 * 8. Writes /_private/autoblog-status.json so the result can be checked remotely.
 */
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit;
}

$force = in_array('--force', $argv ?? [], true);
$repo = dirname(__DIR__);
$site = dirname($repo);
$priv = $site . '/_private';
$log = [];
$errors = [];

function li_log($msg) {
    global $log;
    $log[] = $msg;
    echo '[autoblog] ' . $msg . PHP_EOL;
}

function li_ensure_private($dir) {
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    $ht = $dir . '/.htaccess';
    if (!file_exists($ht)) {
        file_put_contents($ht, "<IfModule mod_authz_core.c>\n  Require all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\n  Order allow,deny\n  Deny from all\n</IfModule>\n");
    }
}

function li_write_atomic($to, $content) {
    if (!is_dir(dirname($to))) mkdir(dirname($to), 0755, true);
    $tmp = $to . '.tmp-' . getmypid();
    if (file_put_contents($tmp, $content) === false) throw new RuntimeException("write failed: $to");
    if (!rename($tmp, $to)) throw new RuntimeException("rename failed: $to");
}

function li_copy_if_changed($from, $to) {
    if (!file_exists($from)) return false;
    if (file_exists($to) && md5_file($from) === md5_file($to)) return false;
    li_write_atomic($to, file_get_contents($from));
    return true;
}

function li_backup_once($src, $dst) {
    if (file_exists($src) && !file_exists($dst)) {
        if (!is_dir(dirname($dst))) mkdir(dirname($dst), 0755, true);
        copy($src, $dst);
        li_log('backup: ' . basename($dst));
    }
}

function li_git_head($repo) {
    $head = @file_get_contents($repo . '/.git/HEAD');
    if (!$head) return '';
    $head = trim($head);
    if (strpos($head, 'ref: ') === 0) {
        $ref = substr($head, 5);
        $sha = @file_get_contents($repo . '/.git/' . $ref);
        if ($sha) return trim($sha);
        $packed = @file_get_contents($repo . '/.git/packed-refs');
        if ($packed && preg_match('/^([0-9a-f]{40}) ' . preg_quote($ref, '/') . '$/m', $packed, $m)) return $m[1];
        return '';
    }
    return $head;
}

function li_inputs_hash($repo, $site) {
    $files = array_merge(glob($repo . '/posts/*.json') ?: [], glob($repo . '/images/*') ?: [], glob($repo . '/system/*') ?: [],
        glob($repo . '/system/pages/*/*') ?: [], glob($repo . '/data/*') ?: []);
    sort($files);
    $h = '';
    foreach ($files as $f) if (is_file($f)) $h .= basename($f) . md5_file($f);
    $bd = $site . '/blog-data.json';
    $h .= file_exists($bd) ? md5_file($bd) : '';
    return md5($h);
}

/** Cache-busting suffix for an image, from its content. */
function li_img_v($file) {
    return is_file($file) ? '?v=' . substr(md5_file($file), 0, 8) : '';
}

/** Validate one translation entry; returns list of problems. */
function li_validate_variant(array $v, $lang, $file) {
    $p = [];
    foreach (['slug', 'title', 'description', 'excerpt', 'body_html'] as $k) {
        if (empty($v[$k]) || !is_string($v[$k])) $p[] = "$file [$lang]: missing $k";
    }
    if (!empty($v['slug']) && !preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $v['slug'])) $p[] = "$file [$lang]: bad slug";
    return $p;
}

/** Shrink oversized images in /blog-images (not the generated /auto ones). */
function li_optimize_images($site, $priv, $maxPerRun = 12) {
    if (!function_exists('imagecreatefromjpeg') || !function_exists('getimagesize')) return 0;
    $done = file_exists($priv . '/optimized-images.json') ? (json_decode(file_get_contents($priv . '/optimized-images.json'), true) ?: []) : [];
    $count = 0;
    foreach (glob($site . '/blog-images/*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE) ?: [] as $file) {
        if ($count >= $maxPerRun) break;
        $name = basename($file);
        $size = filesize($file);
        if ($size < 700 * 1024 || (isset($done[$name]) && $done[$name] === $size)) continue;
        $info = @getimagesize($file);
        if (!$info) continue;
        list($w, $h, $type) = $info;
        if ($w * $h > 40000000) continue; // too large for safe memory use
        $src = $type === IMAGETYPE_PNG ? @imagecreatefrompng($file) : ($type === IMAGETYPE_JPEG ? @imagecreatefromjpeg($file) : null);
        if (!$src) continue;
        $maxW = 1600;
        $nw = $w > $maxW ? $maxW : $w;
        $nh = (int)round($h * $nw / $w);
        $dst = imagecreatetruecolor($nw, $nh);
        if ($type === IMAGETYPE_PNG) { imagealphablending($dst, false); imagesavealpha($dst, true); }
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
        $tmp = $file . '.opt-' . getmypid();
        $ok = $type === IMAGETYPE_PNG ? imagepng($dst, $tmp, 9) : imagejpeg($dst, $tmp, 82);
        imagedestroy($src); imagedestroy($dst);
        if ($ok && filesize($tmp) < $size * 0.9) {
            li_backup_once($file, $priv . '/backups/blog-images/' . $name);
            rename($tmp, $file);
            $done[$name] = filesize($file);
            $count++;
            li_log('image optimized: ' . $name . ' ' . round($size / 1024) . 'KB → ' . round($done[$name] / 1024) . 'KB');
        } else {
            @unlink($tmp);
            $done[$name] = $size;
        }
    }
    file_put_contents($priv . '/optimized-images.json', json_encode($done, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    return $count;
}

$status = [
    'ran_at' => date('c'),
    'commit' => li_git_head($repo),
    'ok' => false,
];

try {
    li_ensure_private($priv);
    li_ensure_private($priv . '/backups');

    // 1) One-time backups of the original files.
    $backups = [
        $site . '/admin/includes/generator.php' => $priv . '/backups/generator.php.orig',
        $site . '/mail.php' => $priv . '/backups/mail.php.orig',
        $site . '/sitemap.xml' => $priv . '/backups/sitemap.xml.orig',
        $site . '/blog/index.html' => $priv . '/backups/blog-index.html.orig',
        $site . '/index.html' => $priv . '/backups/index.html.orig',
        $site . '/tax-calculator/index.html' => $priv . '/backups/tax-calculator.html.orig',
    ];
    foreach ($backups as $src => $dst) li_backup_once($src, $dst);

    // 2) Tax calculator pages, EN/AR/RU, all amounts in lira (cheap; runs on every install).
    $taxData = $repo . '/data/tax-data.json';
    if (file_exists($taxData) && file_exists($repo . '/system/taxcalc.php')) {
        $data = json_decode(file_get_contents($taxData), true);
        if (!$data || empty($data['yiufe']) || empty($data['brackets'])) throw new RuntimeException('data/tax-data.json is invalid');
        require_once $repo . '/system/taxcalc.php';
        $n = write_taxcalc_pages($site, $data);
        if ($n) li_log("tax calculator pages updated: $n");
    }
    if (file_exists($site . '/fx-rates.json')) @unlink($site . '/fx-rates.json');

    // 3) Homepage patches (idempotent).
    $indexFile = $site . '/index.html';
    if (file_exists($indexFile)) {
        $html = file_get_contents($indexFile);
        $orig = $html;
        $origFetch = "fetch('/blog-data.json?v=' + Date.now())";
        $newFetch = "fetch('/blog-feed.json?v=' + Date.now()).then(function(r){ return r.ok ? r : fetch('/blog-data.json?v=' + Date.now()); })";
        if (strpos($html, $newFetch) === false && strpos($html, $origFetch) !== false) $html = str_replace($origFetch, $newFetch, $html);
        if (strpos($html, '/site-boost.css') === false && stripos($html, '</head>') !== false) {
            $html = preg_replace('~</head>~i', "<link rel=\"stylesheet\" href=\"/site-boost.css?v=1\">\n</head>", $html, 1);
        }
        if (strpos($html, '/site-boost.js') === false && stripos($html, '</body>') !== false) {
            $html = preg_replace('~</body>~i', "<script src=\"/site-boost.js?v=1\" defer></script>\n</body>", $html, 1);
        }
        $html = str_replace('<button id="contact-submit" type="submit" id="contact-submit" type="submit" class="send-btn">', '<button id="contact-submit" type="submit" class="send-btn">', $html);
        $html = str_replace('© 2024 LAND ISTANBUL', '© 2026 LAND ISTANBUL', $html);
        $sortJs = "grid.insertBefore(frag, grid.firstChild);\n      /*LI-SORT*/ var all = Array.prototype.slice.call(grid.children); var dt = function(c){ var e = c.querySelector('.blog-date'); var d = e ? Date.parse(e.textContent) : NaN; return isNaN(d) ? 0 : d; }; all.sort(function(x, y){ return dt(y) - dt(x); }); all.forEach(function(c){ grid.appendChild(c); }); grid.style.scrollBehavior = 'auto'; grid.scrollLeft = 0; requestAnimationFrame(function(){ grid.scrollLeft = 0; grid.style.scrollBehavior = ''; });";
        if (strpos($html, '/*LI-SORT*/') === false) $html = str_replace('grid.insertBefore(frag, grid.firstChild);', $sortJs, $html);
        $html = str_replace('>Tüm Yazılar →</a>', '>All Articles →</a>', $html);
        foreach (['css', 'js'] as $ext) {
            $v = substr(md5_file($repo . '/system/site-boost.' . $ext), 0, 10);
            $html = preg_replace('~/site-boost\.' . $ext . '\?v=[A-Za-z0-9]+~', '/site-boost.' . $ext . '?v=' . $v, $html);
        }
        if ($html !== $orig) { li_write_atomic($indexFile, $html); li_log('homepage patched'); }
    }

    // Sitemap: drop "#section" URLs (fragments are not separate pages for search engines).
    $sitemapFile = $site . '/sitemap.xml';
    if (file_exists($sitemapFile)) {
        $sm = file_get_contents($sitemapFile);
        $clean = preg_replace('~\s*<url>\s*<loc>[^<]*#[^<]*</loc>.*?</url>~s', '', $sm);
        if ($clean !== null && $clean !== $sm) { li_write_atomic($sitemapFile, $clean); li_log('sitemap: removed #fragment URLs'); }
    }

    $hash = li_inputs_hash($repo, $site);
    $prev = file_exists($priv . '/autoblog-status.json') ? json_decode(file_get_contents($priv . '/autoblog-status.json'), true) : null;
    if (!$force && $prev && ($prev['inputs_hash'] ?? '') === $hash && !empty($prev['ok'])) {
        li_log('nothing changed, skipping');
        $prev['checked_at'] = date('c');
        $prev['last_log'] = $log;
        file_put_contents($priv . '/autoblog-status.json', json_encode($prev, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        exit(0);
    }

    // 4) System files.
    $systemFiles = [
        $repo . '/system/generator.php' => $site . '/admin/includes/generator.php',
        $repo . '/system/valuation.php' => $site . '/admin/includes/valuation.php',
        $repo . '/system/eligibility.php' => $site . '/admin/includes/eligibility.php',
        $repo . '/system/mail.php' => $site . '/mail.php',
        $repo . '/system/blog-extra.css' => $site . '/blog-extra.css',
        $repo . '/system/blog-lead.js' => $site . '/blog-lead.js',
        $repo . '/system/site-boost.css' => $site . '/site-boost.css',
        $repo . '/system/site-boost.js' => $site . '/site-boost.js',
    ];
    foreach ($systemFiles as $from => $to) {
        if (li_copy_if_changed($from, $to)) li_log('installed: ' . str_replace($site, '', $to));
    }

    // 5) Images.
    $imgDir = $site . '/blog-images/auto';
    if (!is_dir($imgDir)) mkdir($imgDir, 0755, true);
    $copied = 0;
    foreach (glob($repo . '/images/*.{jpg,jpeg,png,webp}', GLOB_BRACE) ?: [] as $img) {
        if (li_copy_if_changed($img, $imgDir . '/' . basename($img))) $copied++;
    }
    if ($copied) li_log("images copied: $copied");

    // Posts.
    $blogData = file_exists($site . '/blog-data.json') ? (json_decode(file_get_contents($site . '/blog-data.json'), true) ?: []) : [];
    $adminIds = array_column($blogData, 'id');
    $flat = [];
    $seen = [];
    $files = glob($repo . '/posts/*.json') ?: [];
    sort($files);
    foreach ($files as $file) {
        $name = basename($file);
        $g = json_decode(file_get_contents($file), true);
        if (!is_array($g) || empty($g['translations']) || empty($g['published'])) {
            $errors[] = "$name: invalid JSON or missing fields";
            continue;
        }
        if (!empty($g['draft'])) continue;
        if ($g['published'] > date('Y-m-d')) continue; // scheduled for later
        foreach (['en', 'ar', 'ru'] as $lang) {
            if (empty($g['translations'][$lang])) continue;
            $v = $g['translations'][$lang];
            $problems = li_validate_variant($v, $lang, $name);
            if ($problems) { $errors = array_merge($errors, $problems); continue; }
            $id = ($lang === 'en' ? '' : $lang . '/') . $v['slug'];
            if (isset($seen[$id]) || in_array($id, $adminIds, true)) {
                $errors[] = "$name [$lang]: duplicate id $id";
                continue;
            }
            $seen[$id] = true;
            $cover = $g['images'][$lang] ?? ($g['images']['en'] ?? null);
            $og = $g['og_images'][$lang] ?? null;
            $flat[] = [
                'id' => $id,
                'group' => $g['group'],
                'lang' => $lang,
                'segment' => $g['segment'] ?? 'general',
                'title' => $v['title'],
                'seo_title' => $v['seo_title'] ?? $v['title'],
                'description' => $v['description'],
                'excerpt' => $v['excerpt'],
                'image' => $cover ? '/blog-images/auto/' . basename($cover) . li_img_v($repo . '/' . $cover) : '/og-image.png',
                'og_image' => $og ? '/blog-images/auto/' . basename($og) . li_img_v($repo . '/' . $og) : null,
                'imageAlt' => $v['image_alt'] ?? $v['title'],
                'published' => $g['published'],
                'updated' => $g['updated'] ?? $g['published'],
                'date' => date('F j, Y', strtotime($g['published'])),
                'keywords' => $v['keywords'] ?? [],
                'body_html' => $v['body_html'],
                'faq' => $v['faq'] ?? [],
                'sources' => $g['sources'] ?? [],
            ];
        }
    }
    file_put_contents($priv . '/blog-auto.json', json_encode($flat, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    li_log('posts: ' . count($flat) . ' pages from ' . count($files) . ' files');

    // 6) Regenerate everything with the installed generator.
    require_once $site . '/admin/includes/generator.php';
    regenerate_all($blogData);
    li_log('regenerated blog pages, indexes, valuation pages and sitemap');

    // 7) Oversized images.
    try { li_optimize_images($site, $priv); } catch (Throwable $e) { li_log('image optimization skipped: ' . $e->getMessage()); }

    $status['ok'] = true;
    $status['inputs_hash'] = $hash;
    $status['pages'] = array_map(function ($p) { return $p['id']; }, $flat);
} catch (Throwable $e) {
    $errors[] = get_class($e) . ': ' . $e->getMessage();
    li_log('ERROR ' . $e->getMessage());
}

$status['errors'] = $errors;
$status['log'] = $log;
@file_put_contents($priv . '/autoblog-status.json', json_encode($status, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
exit($status['ok'] ? 0 : 1);
