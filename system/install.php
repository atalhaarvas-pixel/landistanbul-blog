<?php
/**
 * Land Istanbul autoblog installer.
 *
 * Runs on the Hostinger server after every Git pull of this repository (Composer post-install hook)
 * and can also be run by cron:  php /home/<user>/domains/landistanbul.com/public_html/autoblog/system/install.php
 *
 * 1. Backs up the original site files once (to /_private/backups).
 * 2. Installs the system files from this repo (generator, mail handler, CSS, JS) when they changed.
 * 3. Copies post images to /blog-images/auto/.
 * 4. Flattens posts/*.json into /_private/blog-auto.json.
 * 5. Regenerates all blog pages, the blog indexes and the sitemap.
 * 6. Writes /_private/autoblog-status.json so the result can be checked remotely.
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

function li_copy_if_changed($from, $to) {
    if (!file_exists($from)) return false;
    if (file_exists($to) && md5_file($from) === md5_file($to)) return false;
    if (!is_dir(dirname($to))) mkdir(dirname($to), 0755, true);
    $tmp = $to . '.tmp-' . getmypid();
    if (!copy($from, $tmp)) throw new RuntimeException("copy failed: $from");
    if (!rename($tmp, $to)) throw new RuntimeException("rename failed: $to");
    return true;
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
    $files = array_merge(glob($repo . '/posts/*.json') ?: [], glob($repo . '/images/*') ?: [], glob($repo . '/system/*') ?: []);
    sort($files);
    $h = '';
    foreach ($files as $f) $h .= basename($f) . md5_file($f);
    $bd = $site . '/blog-data.json';
    $h .= file_exists($bd) ? md5_file($bd) : '';
    return md5($h);
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
    ];
    foreach ($backups as $src => $dst) {
        if (file_exists($src) && !file_exists($dst)) {
            copy($src, $dst);
            li_log('backup: ' . basename($dst));
        }
    }

    // Homepage: read the newest posts (admin + automatic) from /blog-feed.json, falling back to blog-data.json.
    $indexFile = $site . '/index.html';
    $origFetch = "fetch('/blog-data.json?v=' + Date.now())";
    $newFetch = "fetch('/blog-feed.json?v=' + Date.now()).then(function(r){ return r.ok ? r : fetch('/blog-data.json?v=' + Date.now()); })";
    if (file_exists($indexFile)) {
        $html = file_get_contents($indexFile);
        if (strpos($html, $newFetch) === false && strpos($html, $origFetch) !== false) {
            if (!file_exists($priv . '/backups/index.html.orig')) copy($indexFile, $priv . '/backups/index.html.orig');
            $patched = str_replace($origFetch, $newFetch, $html);
            $tmp = $indexFile . '.tmp-' . getmypid();
            file_put_contents($tmp, $patched);
            rename($tmp, $indexFile);
            li_log('homepage blog section now reads /blog-feed.json');
        }
    }

    $hash = li_inputs_hash($repo, $site);
    $prev = file_exists($priv . '/autoblog-status.json') ? json_decode(file_get_contents($priv . '/autoblog-status.json'), true) : null;
    if (!$force && $prev && ($prev['inputs_hash'] ?? '') === $hash && !empty($prev['ok'])) {
        li_log('nothing changed, skipping');
        $prev['checked_at'] = date('c');
        file_put_contents($priv . '/autoblog-status.json', json_encode($prev, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        exit(0);
    }

    // 2) System files.
    $systemFiles = [
        $repo . '/system/generator.php' => $site . '/admin/includes/generator.php',
        $repo . '/system/mail.php' => $site . '/mail.php',
        $repo . '/system/blog-extra.css' => $site . '/blog-extra.css',
        $repo . '/system/blog-lead.js' => $site . '/blog-lead.js',
    ];
    foreach ($systemFiles as $from => $to) {
        if (li_copy_if_changed($from, $to)) li_log('installed: ' . str_replace($site, '', $to));
    }

    // 3) Images.
    $imgDir = $site . '/blog-images/auto';
    if (!is_dir($imgDir)) mkdir($imgDir, 0755, true);
    $copied = 0;
    foreach (glob($repo . '/images/*.{jpg,jpeg,png,webp}', GLOB_BRACE) ?: [] as $img) {
        if (li_copy_if_changed($img, $imgDir . '/' . basename($img))) $copied++;
    }
    if ($copied) li_log("images copied: $copied");

    // 4) Posts.
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
                'image' => $cover ? '/blog-images/auto/' . basename($cover) : '/og-image.png',
                'og_image' => $og ? '/blog-images/auto/' . basename($og) : null,
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

    // 5) Regenerate everything with the installed generator.
    require_once $site . '/admin/includes/generator.php';
    regenerate_all($blogData);
    li_log('regenerated blog pages, indexes and sitemap');

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
