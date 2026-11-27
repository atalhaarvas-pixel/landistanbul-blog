<?php
/**
 * Land Istanbul blog generator (v2).
 *
 * Builds real, crawlable static pages for every blog post:
 *  - posts created in the admin panel (blog-data.json), exactly as before;
 *  - multilingual posts published automatically from the landistanbul-blog repository
 *    (stored in /_private/blog-auto.json by /autoblog/system/install.php).
 *
 * The admin panel keeps calling regenerate_all() and delete_post_page() as before.
 * Original file is backed up in /_private/backups/generator.php.orig.
 * Compatible with PHP 7.4+.
 */

define('SITE_ROOT', dirname(__DIR__, 2)); // ...\/public_html
define('SITE_URL', 'https://landistanbul.com');
define('AUTO_DATA_FILE', SITE_ROOT . '/_private/blog-auto.json');
define('AUTO_PAGES_FILE', SITE_ROOT . '/_private/auto-pages.json');
define('WHATSAPP_NUMBER', '905468916349');
if (file_exists(__DIR__ . '/valuation.php')) require_once __DIR__ . '/valuation.php';
if (file_exists(__DIR__ . '/eligibility.php')) require_once __DIR__ . '/eligibility.php';
if (file_exists(__DIR__ . '/countries.php')) require_once __DIR__ . '/countries.php';

/**
 * The original blog posts that live inside index.html's own JS (not managed by this panel).
 */
function legacy_posts() {
    return [
        [
            'id' => 'things-to-do-in-istanbul',
            'title' => "Things to Do in Istanbul: A Local's Honest Guide",
            'excerpt' => 'Born and raised in Istanbul, I share the historic landmarks, restaurants, and neighborhoods I actually send my friends to — from Sultanahmet to the Bosphorus.',
            'image' => '/istanbul-aerial-view.png',
            'date' => 'May 5, 2026',
        ],
        [
            'id' => 'selling-property-turkey',
            'title' => 'Key Considerations Before Selling Your Property in Turkey',
            'excerpt' => 'The top 5 legal and financial factors every seller should know before starting a property transaction in Turkey.',
            'image' => '/tax_turkey.png',
            'date' => 'April 28, 2026',
        ],
        [
            'id' => 'dubai-vs-istanbul-roi',
            'title' => 'Dubai vs. Istanbul: Which City Offers the Best Real Estate ROI?',
            'excerpt' => 'A detailed comparison of market dynamics, capital appreciation, and lifestyle value for long-term property investors.',
            'image' => '/dubai-vs-istanbul-real-estate.png',
            'date' => 'April 20, 2026',
        ],
        [
            'id' => 'market-trends-2024',
            'title' => 'Istanbul Real Estate Trends 2024',
            'excerpt' => 'Discover the emerging neighborhoods and investment hotspots in Istanbul for the upcoming year.',
            'image' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?auto=format&fit=crop&q=80&w=800',
            'date' => 'May 15, 2024',
        ],
        [
            'id' => 'citizenship-guide',
            'title' => 'A Comprehensive Guide to Turkish Citizenship',
            'excerpt' => 'Everything you need to know about the investment requirements and application process.',
            'image' => '/istanbul-aerial-view.png',
            'date' => 'June 2, 2024',
        ],
        [
            'id' => 'land-development-tips',
            'title' => 'Maximizing ROI in Land Development',
            'excerpt' => 'Strategic advice for developers looking to enter the Istanbul market.',
            'image' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&q=80&w=800',
            'date' => 'July 10, 2024',
        ],
    ];
}

/* ───────────────────────── i18n ───────────────────────── */

function li_langs() {
    return ['en', 'ar', 'ru'];
}

function li_t($lang) {
    static $s = null;
    if ($s === null) {
        $s = [
            'en' => [
                'lang_name' => 'English', 'dir' => 'ltr', 'locale' => 'en_US',
                'all_articles' => '← All Articles', 'blog_title' => 'Market Blog', 'blog_tag' => 'Insights',
                'blog_desc' => 'Istanbul real estate insights, investment guides, and market analysis from Land Istanbul.',
                'read_more' => 'Read Article →', 'related' => 'Related Articles', 'faq' => 'Frequently Asked Questions',
                'updated' => 'Updated', 'sources' => 'Sources',
                'disclaimer' => 'This article is for general information only and is not legal, tax or financial advice. Rules and fees change; always confirm the details for your case with a qualified professional.',
                'f_name' => 'Full name', 'f_email' => 'Email', 'f_phone' => 'Phone / WhatsApp', 'f_message' => 'Your message (optional)',
                'f_budget' => 'Budget (USD)', 'f_interest' => 'I am interested in', 'f_submit' => 'Send Request', 'f_sending' => 'Sending…',
                'f_ok' => 'Thank you! Our team will contact you shortly.',
                'f_err' => 'Something went wrong. Please try again or message us on WhatsApp.',
                'f_need' => 'Please enter your name and an email address or phone number.',
                'f_privacy' => 'We use your details only to respond to your request.',
                'wa' => 'Chat on WhatsApp', 'wa_text' => 'Hello Land Istanbul, I read your article "%s" and would like more information.',
                'or' => 'or',
                'budgets' => ['Under $200,000', '$200,000 – $500,000', '$500,000 – $1,000,000', '$1,000,000 – $2,500,000', 'Above $2,500,000'],
                'interests' => [
                    'sell' => 'Selling my property in Turkey', 'citizenship' => 'Turkish citizenship by investment',
                    'apartment' => 'Buying an apartment', 'land' => 'Buying land', 'other' => 'Other',
                ],
                'cat' => [
                    'sell' => 'Selling Property', 'citizenship' => 'Citizenship', 'apartment' => 'Buying Property',
                    'land' => 'Land Investment', 'general' => 'Market Insights',
                ],
                'cta' => [
                    'sell' => ['Thinking of Selling Your Property in Turkey?', 'Get a free market valuation and a clear plan for a fast, tax-efficient sale.', 'Get a Free Valuation'],
                    'citizenship' => ['Plan Your Turkish Citizenship Application', 'Tell us your budget and timeline. We will shortlist eligible properties and guide you through every step.', 'Get a Free Consultation'],
                    'apartment' => ['Find the Right Apartment in Istanbul', 'Tell us what you are looking for and receive a curated shortlist within 24 hours.', 'Get My Shortlist'],
                    'land' => ['Looking for Land in Istanbul?', 'Receive zoning-checked land opportunities that match your budget and goals.', 'See Land Opportunities'],
                    'general' => ['Ready to Invest?', 'Contact our team of experts to discuss your investment goals.', 'Get in Touch'],
                ],
                'months' => null,
            ],
            'ar' => [
                'lang_name' => 'العربية', 'dir' => 'rtl', 'locale' => 'ar_AR',
                'all_articles' => '→ جميع المقالات', 'blog_title' => 'مدونة العقارات', 'blog_tag' => 'رؤى',
                'blog_desc' => 'مقالات وأدلة حول الاستثمار العقاري في إسطنبول والجنسية التركية من لاند إسطنبول.',
                'read_more' => 'اقرأ المقال ←', 'related' => 'مقالات ذات صلة', 'faq' => 'الأسئلة الشائعة',
                'updated' => 'آخر تحديث', 'sources' => 'المصادر',
                'disclaimer' => 'هذا المقال لأغراض المعلومات العامة فقط ولا يُعد استشارة قانونية أو ضريبية أو مالية. القواعد والرسوم قد تتغير، لذا تأكد دائماً من تفاصيل حالتك مع مختص مؤهل.',
                'f_name' => 'الاسم الكامل', 'f_email' => 'البريد الإلكتروني', 'f_phone' => 'الهاتف / واتساب', 'f_message' => 'رسالتك (اختياري)',
                'f_budget' => 'الميزانية (بالدولار الأمريكي)', 'f_interest' => 'أنا مهتم بـ', 'f_submit' => 'أرسل الطلب', 'f_sending' => 'جارٍ الإرسال…',
                'f_ok' => 'شكراً لك! سيتواصل معك فريقنا قريباً.',
                'f_err' => 'حدث خطأ. يرجى المحاولة مرة أخرى أو مراسلتنا عبر واتساب.',
                'f_need' => 'يرجى إدخال اسمك وبريدك الإلكتروني أو رقم هاتفك.',
                'f_privacy' => 'نستخدم بياناتك فقط للرد على طلبك.',
                'wa' => 'تواصل عبر واتساب', 'wa_text' => 'مرحباً لاند إسطنبول، قرأت مقالكم "%s" وأرغب في الحصول على مزيد من المعلومات.',
                'or' => 'أو',
                'budgets' => ['أقل من 200,000 دولار', '200,000 – 500,000 دولار', '500,000 – 1,000,000 دولار', '1,000,000 – 2,500,000 دولار', 'أكثر من 2,500,000 دولار'],
                'interests' => [
                    'sell' => 'بيع عقاري في تركيا', 'citizenship' => 'الجنسية التركية عبر الاستثمار',
                    'apartment' => 'شراء شقة', 'land' => 'شراء أرض', 'other' => 'أخرى',
                ],
                'cat' => [
                    'sell' => 'بيع العقارات', 'citizenship' => 'الجنسية التركية', 'apartment' => 'شراء العقارات',
                    'land' => 'الاستثمار في الأراضي', 'general' => 'رؤى السوق',
                ],
                'cta' => [
                    'sell' => ['هل تفكر في بيع عقارك في تركيا؟', 'احصل على تقييم مجاني لسعر السوق وخطة واضحة لبيع سريع وبأقل تكلفة ضريبية.', 'احصل على تقييم مجاني'],
                    'citizenship' => ['خطّط لطلب الجنسية التركية', 'أخبرنا بميزانيتك وجدولك الزمني، وسنرشّح لك العقارات المؤهلة ونرافقك في كل خطوة.', 'احصل على استشارة مجانية'],
                    'apartment' => ['اعثر على الشقة المناسبة في إسطنبول', 'أخبرنا بما تبحث عنه واحصل على قائمة مختارة خلال 24 ساعة.', 'أرسلوا لي الخيارات'],
                    'land' => ['تبحث عن أرض في إسطنبول؟', 'احصل على فرص أراضٍ تم التحقق من وضعها التنظيمي وتناسب ميزانيتك وأهدافك.', 'اعرض فرص الأراضي'],
                    'general' => ['هل أنت مستعد للاستثمار؟', 'تواصل مع فريق خبرائنا لمناقشة أهدافك الاستثمارية.', 'تواصل معنا'],
                ],
                'months' => ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
            ],
            'ru' => [
                'lang_name' => 'Русский', 'dir' => 'ltr', 'locale' => 'ru_RU',
                'all_articles' => '← Все статьи', 'blog_title' => 'Блог о недвижимости', 'blog_tag' => 'Аналитика',
                'blog_desc' => 'Статьи и руководства о недвижимости в Стамбуле, инвестициях и гражданстве Турции от Land Istanbul.',
                'read_more' => 'Читать статью →', 'related' => 'Похожие статьи', 'faq' => 'Часто задаваемые вопросы',
                'updated' => 'Обновлено', 'sources' => 'Источники',
                'disclaimer' => 'Статья носит общий информационный характер и не является юридической, налоговой или финансовой консультацией. Правила и сборы меняются, поэтому всегда уточняйте детали вашей ситуации у квалифицированного специалиста.',
                'f_name' => 'Имя и фамилия', 'f_email' => 'Эл. почта', 'f_phone' => 'Телефон / WhatsApp', 'f_message' => 'Сообщение (необязательно)',
                'f_budget' => 'Бюджет (USD)', 'f_interest' => 'Меня интересует', 'f_submit' => 'Отправить заявку', 'f_sending' => 'Отправка…',
                'f_ok' => 'Спасибо! Наш специалист скоро свяжется с вами.',
                'f_err' => 'Произошла ошибка. Попробуйте ещё раз или напишите нам в WhatsApp.',
                'f_need' => 'Укажите имя и email или номер телефона.',
                'f_privacy' => 'Ваши данные используются только для ответа на ваш запрос.',
                'wa' => 'Написать в WhatsApp', 'wa_text' => 'Здравствуйте, Land Istanbul! Я прочитал(а) вашу статью «%s» и хотел(а) бы узнать подробнее.',
                'or' => 'или',
                'budgets' => ['до $200 000', '$200 000 – $500 000', '$500 000 – $1 000 000', '$1 000 000 – $2 500 000', 'более $2 500 000'],
                'interests' => [
                    'sell' => 'Продажа недвижимости в Турции', 'citizenship' => 'Гражданство Турции за инвестиции',
                    'apartment' => 'Покупка квартиры', 'land' => 'Покупка земли', 'other' => 'Другое',
                ],
                'cat' => [
                    'sell' => 'Продажа недвижимости', 'citizenship' => 'Гражданство', 'apartment' => 'Покупка недвижимости',
                    'land' => 'Инвестиции в землю', 'general' => 'Обзор рынка',
                ],
                'cta' => [
                    'sell' => ['Планируете продать недвижимость в Турции?', 'Получите бесплатную оценку рыночной стоимости и понятный план быстрой продажи с оптимальными налогами.', 'Получить бесплатную оценку'],
                    'citizenship' => ['Спланируйте получение гражданства Турции', 'Расскажите о бюджете и сроках: мы подберём подходящие объекты и сопроводим вас на каждом этапе.', 'Получить консультацию'],
                    'apartment' => ['Подберём квартиру в Стамбуле', 'Опишите, что вы ищете, и получите подборку вариантов в течение 24 часов.', 'Получить подборку'],
                    'land' => ['Ищете землю в Стамбуле?', 'Получите варианты участков с проверенным зонированием под ваш бюджет и цели.', 'Смотреть участки'],
                    'general' => ['Готовы инвестировать?', 'Свяжитесь с нашими экспертами, чтобы обсудить ваши инвестиционные цели.', 'Связаться с нами'],
                ],
                'months' => ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'],
            ],
        ];
        // English interest values are what lands in the inbox, whatever the page language.
    }
    return isset($s[$lang]) ? $s[$lang] : $s['en'];
}

/** Budget option values sent by the forms (kept in English so the inbox stays readable). */
function li_budget_values() {
    return li_t('en')['budgets'];
}

function li_format_date($iso, $lang) {
    $ts = strtotime($iso);
    if (!$ts) return $iso;
    $t = li_t($lang);
    if (empty($t['months'])) return date('F j, Y', $ts);
    return (int)date('j', $ts) . ' ' . $t['months'][(int)date('n', $ts) - 1] . ' ' . date('Y', $ts);
}

function li_post_url($id) {
    return SITE_URL . '/blog/' . $id . '/';
}

function li_index_url($lang) {
    return SITE_URL . '/blog/' . ($lang === 'en' ? '' : $lang . '/');
}

function li_abs($path) {
    return (strpos($path, 'http') === 0) ? $path : SITE_URL . $path;
}

function li_post_ts(array $p) {
    if (!empty($p['published'])) return strtotime($p['published']) ?: 0;
    return strtotime($p['date'] ?? '') ?: 0;
}

/* ───────────────────────── data ───────────────────────── */

function load_auto_posts() {
    if (!file_exists(AUTO_DATA_FILE)) return [];
    $d = json_decode(file_get_contents(AUTO_DATA_FILE), true);
    return is_array($d) ? $d : [];
}

/** Context shared while regenerating (all posts, used for related links and language switches). */
function li_ctx($set = null) {
    static $ctx = ['dynamic' => [], 'auto' => []];
    if ($set !== null) $ctx = $set;
    return $ctx;
}

/* ───────────────────────── rendering helpers ───────────────────────── */

/** Turn a post's structured content blocks into HTML for the post body. */
function blocks_to_html(array $blocks) {
    $html = [];
    foreach ($blocks as $b) {
        $type = $b['type'] ?? '';
        if ($type === 'image' && !empty($b['src'])) {
            $cap = trim($b['caption'] ?? '');
            $html[] = '<figure><img src="' . htmlspecialchars($b['src']) . '" alt="' . htmlspecialchars($cap ?: '') . '" loading="lazy">' .
                      ($cap !== '' ? '<figcaption>' . htmlspecialchars($cap) . '</figcaption>' : '') .
                      '</figure>';
        } elseif ($type === 'text' && trim($b['content'] ?? '') !== '') {
            $html[] = '<p>' . nl2br(htmlspecialchars(trim($b['content']))) . '</p>';
        } elseif ($type === 'html' && trim($b['content'] ?? '') !== '') {
            // Only produced by the repository publisher, never by the admin form.
            $html[] = $b['content'];
        }
    }
    return implode("\n", $html);
}

/**
 * Common <head> + nav markup shared by generated pages.
 * $opts: lang, alternates [lang => url], type, published, modified, robots, extra_head
 */
const LI_ADDRESS = 'Kavaklı, Olimpiyat Cd. No:58, 34520 Beylikdüzü / İstanbul';
const LI_MAPS_URL = 'https://www.google.com/maps/place//data=!4m2!3m1!1s0x14caa181dce03687:0xc7290e74b462666c';

const LI_LICENCE_NO = '3408945';
const LI_TAX_ID = '0850564655';

/** Trust strings per language. */
function li_trust_t($lang) {
    $all = [
        'en' => ['Licensed real estate broker', 'Real estate trade licence (Taşınmaz Ticareti Yetki Belgesi) No. 3408945, Turkish Ministry of Trade', 'Registered company', 'Math Investment (Mat Yatırım) · Tax ID 0850564655', 'Office in Istanbul', 'Rated 5.0 on Google', '22 client reviews · read them on Google'],
        'ar' => ['وسيط عقاري مرخّص', 'رخصة تجارة العقارات (Taşınmaz Ticareti Yetki Belgesi) رقم 3408945، وزارة التجارة التركية', 'شركة مسجّلة', 'Math Investment (Mat Yatırım) · الرقم الضريبي 0850564655', 'مكتبنا في إسطنبول', 'تقييم 5.0 على Google', '22 تقييماً من العملاء على Google'],
        'ru' => ['Лицензированный агент по недвижимости', 'Лицензия на торговлю недвижимостью (Taşınmaz Ticareti Yetki Belgesi) № 3408945, Министерство торговли Турции', 'Зарегистрированная компания', 'Math Investment (Mat Yatırım) · налоговый номер 0850564655', 'Офис в Стамбуле', 'Оценка 5.0 в Google', '22 отзыва клиентов в Google'],
    ];
    return $all[$lang] ?? $all['en'];
}

/** Licence, tax ID and office strip, shown above the footer on every generated page. */
function li_trust_html($lang = 'en') {
    $t = li_trust_t($lang);
    $h = function ($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); };
    return '<section class="li-trust" aria-label="' . $h($t[0]) . '"><div class="li-trust-in">'
        . '<div class="li-trust-item"><i><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6z"/><path d="M9 12l2 2 4-4"/></svg></i><div><b>' . $h($t[0]) . '</b><span>' . $h($t[1]) . '</span></div></div>'
        . '<div class="li-trust-item"><i><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 3h7l5 5v13H7z"/><path d="M14 3v5h5"/><path d="M10 13h6M10 17h6"/></svg></i><div><b>' . $h($t[2]) . '</b><span>' . $h($t[3]) . '</span></div></div>'
        . '<div class="li-trust-item"><i><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-7-6.2-7-12a7 7 0 0 1 14 0c0 5.8-7 12-7 12z"/><circle cx="12" cy="9" r="2.5"/></svg></i><div><b>' . $h($t[4]) . '</b><span><a href="' . LI_MAPS_URL . '" target="_blank" rel="noopener">' . $h(LI_ADDRESS) . '</a></span></div></div>'
        . '<div class="li-trust-item"><i><svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.5l2.9 6 6.6.9-4.8 4.6 1.2 6.5L12 17.4l-5.9 3.1 1.2-6.5L2.5 9.4l6.6-.9z"/></svg></i><div><b>' . $h($t[5]) . ' <em class="li-stars">★★★★★</em></b><span><a href="' . LI_MAPS_URL . '" target="_blank" rel="noopener">' . $h($t[6]) . '</a></span></div></div>'
        . '</div></section>';
}

/** Logo lockup: Land Istanbul by Math Investment. */
function li_logo_html() {
    return '<span class="li-logo-main">LAND ISTANBUL</span><span class="li-logo-by">by Math Investment</span>';
}

/** Footer line with the company and office address. */
function li_footer_line() {
    return '<p class="li-foot-line">© 2026 Land Istanbul by Math Investment (Mat Yatırım) · Licence No. ' . LI_LICENCE_NO . ' · Tax ID ' . LI_TAX_ID . '<br><a href="' . LI_MAPS_URL . '" target="_blank" rel="noopener">' . htmlspecialchars(LI_ADDRESS) . '</a></p>';
}

/** Asset URL with a content hash, so browsers and caches fetch the new file after every change. */
function li_asset($path) {
    $f = SITE_ROOT . $path;
    return $path . (is_file($f) ? '?v=' . substr(md5_file($f), 0, 10) : '');
}

/** Navigation links in the page language. */
function li_nav($lang) {
    $sfx = $lang === 'en' ? '' : $lang . '/';
    $labels = [
        'en' => ['Home', 'Services', 'Free Valuation', 'Tax Calculator', 'Blogs', 'Contact Us'],
        'ar' => ['الرئيسية', 'الخدمات', 'تقييم مجاني', 'حاسبة الضريبة', 'المدونة', 'تواصل معنا'],
        'ru' => ['Главная', 'Услуги', 'Бесплатная оценка', 'Налоговый калькулятор', 'Блог', 'Связаться'],
    ];
    $l = $labels[$lang] ?? $labels['en'];
    return [['/#home', $l[0]], ['/#services', $l[1]], ['/free-property-valuation/' . $sfx, $l[2]], ['/tax-calculator/' . $sfx, $l[3]], ['/blog/' . $sfx, $l[4]], ['/#contact', $l[5]]];
}

function page_head($title, $description, $canonical, $ogImage, array $opts = []) {
    $lang = $opts['lang'] ?? 'en';
    $GLOBALS['LI_PAGE_LANG'] = $lang;
    $t = li_t($lang);
    $alternates = $opts['alternates'] ?? [];
    $type = $opts['type'] ?? 'article';
    ob_start();
?><!doctype html>
<html lang="<?= htmlspecialchars($lang) ?>" dir="<?= $t['dir'] ?>">
<head>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-168L11FS04"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-168L11FS04');
</script>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?= htmlspecialchars($title) ?></title>
<meta name="description" content="<?= htmlspecialchars($description) ?>" />
<?php if (!empty($opts['robots'])): ?><meta name="robots" content="<?= htmlspecialchars($opts['robots']) ?>" />
<?php else: ?><meta name="robots" content="index, follow, max-image-preview:large" />
<?php endif; ?>
<link rel="canonical" href="<?= htmlspecialchars($canonical) ?>" />
<?php if (count($alternates) > 1): foreach ($alternates as $alang => $aurl): ?>
<link rel="alternate" hreflang="<?= htmlspecialchars($alang) ?>" href="<?= htmlspecialchars($aurl) ?>" />
<?php endforeach; ?>
<link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($alternates['en'] ?? reset($alternates)) ?>" />
<?php endif; ?>
<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<meta property="og:type" content="<?= htmlspecialchars($type) ?>" />
<meta property="og:site_name" content="Land Istanbul" />
<meta property="og:locale" content="<?= $t['locale'] ?>" />
<meta property="og:title" content="<?= htmlspecialchars($title) ?>" />
<meta property="og:description" content="<?= htmlspecialchars($description) ?>" />
<meta property="og:url" content="<?= htmlspecialchars($canonical) ?>" />
<meta property="og:image" content="<?= htmlspecialchars($ogImage) ?>" />
<?php if (!empty($opts['published'])): ?><meta property="article:published_time" content="<?= htmlspecialchars($opts['published']) ?>" />
<?php endif; ?>
<?php if (!empty($opts['modified'])): ?><meta property="article:modified_time" content="<?= htmlspecialchars($opts['modified']) ?>" />
<?php endif; ?>
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?= htmlspecialchars($title) ?>" />
<meta name="twitter:description" content="<?= htmlspecialchars($description) ?>" />
<meta name="twitter:image" content="<?= htmlspecialchars($ogImage) ?>" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700;900&display=swap" rel="stylesheet">
<?php if ($lang === 'ar'): ?><link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
<?php endif; ?>
<link rel="stylesheet" href="/blog-style.css">
<link rel="stylesheet" href="<?= li_asset('/blog-extra.css') ?>">
<link rel="stylesheet" href="<?= li_asset('/site-boost.css') ?>">
<?= $opts['extra_head'] ?? '' ?>
</head>
<body class="lang-<?= htmlspecialchars($lang) ?>">
<?php $nv = li_nav($lang); ?>
<nav>
  <a class="logo" href="/" aria-label="Land Istanbul by Math Investment"><?= li_logo_html() ?></a>
  <div class="nav-links">
<?php foreach ($nv as $i => $n): ?>    <a href="<?= htmlspecialchars($n[0]) ?>"<?= $i === 2 ? ' class="nav-val"' : ($i === 5 ? ' class="nav-btn"' : '') ?>><?= htmlspecialchars($n[1]) ?></a>
<?php endforeach; ?>
  </div>
  <button class="menu-toggle" onclick="document.getElementById('mobile-menu').classList.toggle('open')" aria-label="Menu">
    <span></span><span></span><span></span>
  </button>
</nav>
<div id="mobile-menu">
<?php foreach ($nv as $n): ?>  <a href="<?= htmlspecialchars($n[0]) ?>"><?= htmlspecialchars($n[1]) ?></a>
<?php endforeach; ?>
</div>
<?php
    return ob_get_clean();
}

function page_footer() {
    return li_trust_html($GLOBALS['LI_PAGE_LANG'] ?? 'en') . '<footer><a class="logo" href="/" aria-label="Land Istanbul by Math Investment">' . li_logo_html() . '</a>' . li_footer_line() . '</footer><script src="' . li_asset('/blog-lead.js') . '" defer></script><script src="' . li_asset('/site-boost.js') . '" defer></script></body></html>';
}

/** Lead capture box: segment-specific copy, short form posting to /mail.php, WhatsApp shortcut. */
function lead_box_html($lang, $segment, $postTitle, $postUrl) {
    $t = li_t($lang);
    $en = li_t('en');
    $segment = isset($t['cta'][$segment]) ? $segment : 'general';
    $cta = $t['cta'][$segment];
    $preselect = $segment === 'general' ? '' : $segment;
    $wa = 'https://wa.me/' . WHATSAPP_NUMBER . '?text=' . rawurlencode(sprintf($t['wa_text'], $postTitle));

    $h = '<section class="li-lead" id="get-offer" data-segment="' . htmlspecialchars($segment) . '">';
    $h .= '<h3>' . htmlspecialchars($cta[0]) . '</h3><p class="li-lead-sub">' . htmlspecialchars($cta[1]) . '</p>';
    if ($segment === 'sell' && function_exists('lv_url')) {
        $h .= '<a class="li-val-link" href="' . htmlspecialchars(str_replace(SITE_URL, '', lv_url($lang))) . '">' . htmlspecialchars(lv_t($lang)['cta_btn']) . ' →</a>';
    }
    if (in_array($segment, ['citizenship', 'apartment'], true) && function_exists('le_url')) {
        $lbl = ['en' => 'Check your eligibility in 60 seconds', 'ar' => 'اختبر أهليتك خلال 60 ثانية', 'ru' => 'Проверьте право за 60 секунд'];
        $h .= '<a class="li-elig-link" href="' . htmlspecialchars(str_replace(SITE_URL, '', le_url($lang))) . '">' . htmlspecialchars($lbl[$lang] ?? $lbl['en']) . ' →</a>';
    }
    $h .= '<form class="li-lead-form" method="post" action="/mail.php" novalidate'
        . ' data-ok="' . htmlspecialchars($t['f_ok']) . '" data-err="' . htmlspecialchars($t['f_err']) . '"'
        . ' data-need="' . htmlspecialchars($t['f_need']) . '" data-sending="' . htmlspecialchars($t['f_sending']) . '">';
    $h .= '<input type="hidden" name="source" value="' . htmlspecialchars($postUrl) . '">';
    $h .= '<input type="hidden" name="lang" value="' . htmlspecialchars($lang) . '">';
    $h .= '<div class="li-hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>';
    $h .= '<div class="li-row"><input type="text" name="name" required autocomplete="name" placeholder="' . htmlspecialchars($t['f_name']) . '" aria-label="' . htmlspecialchars($t['f_name']) . '"></div>';
    $h .= '<div class="li-row li-two">'
        . '<input type="email" name="email" autocomplete="email" placeholder="' . htmlspecialchars($t['f_email']) . '" aria-label="' . htmlspecialchars($t['f_email']) . '">'
        . '<input type="tel" name="phone" autocomplete="tel" dir="ltr" placeholder="' . htmlspecialchars($t['f_phone']) . '" aria-label="' . htmlspecialchars($t['f_phone']) . '">'
        . '</div>';
    $h .= '<div class="li-row li-two">';
    $h .= '<select name="interest" aria-label="' . htmlspecialchars($t['f_interest']) . '"><option value="">' . htmlspecialchars($t['f_interest']) . '</option>';
    foreach ($t['interests'] as $key => $label) {
        $h .= '<option value="' . htmlspecialchars($en['interests'][$key]) . '"' . ($key === $preselect ? ' selected' : '') . '>' . htmlspecialchars($label) . '</option>';
    }
    $h .= '</select>';
    $h .= '<select name="budget" aria-label="' . htmlspecialchars($t['f_budget']) . '"><option value="">' . htmlspecialchars($t['f_budget']) . '</option>';
    foreach ($t['budgets'] as $i => $label) {
        $h .= '<option value="' . htmlspecialchars($en['budgets'][$i]) . '">' . htmlspecialchars($label) . '</option>';
    }
    $h .= '</select></div>';
    $h .= '<div class="li-row"><textarea name="message" rows="3" placeholder="' . htmlspecialchars($t['f_message']) . '" aria-label="' . htmlspecialchars($t['f_message']) . '"></textarea></div>';
    $h .= '<div class="li-actions"><button type="submit" class="li-submit">' . htmlspecialchars($cta[2]) . '</button>'
        . '<span class="li-or">' . htmlspecialchars($t['or']) . '</span>'
        . '<a class="li-wa" href="' . htmlspecialchars($wa) . '" target="_blank" rel="noopener" data-track="whatsapp">' . htmlspecialchars($t['wa']) . '</a></div>';
    $h .= '<p class="li-status" role="status" aria-live="polite"></p>';
    $h .= '<p class="li-privacy">' . htmlspecialchars($t['f_privacy']) . '</p>';
    $h .= '</form></section>';
    // Mobile-only sticky bar: WhatsApp + jump to the form.
    $h .= '<div class="li-sticky" aria-hidden="false">'
        . '<a class="li-sticky-wa" href="' . htmlspecialchars($wa) . '" target="_blank" rel="noopener" data-track="whatsapp">' . htmlspecialchars($t['wa']) . '</a>'
        . '<a class="li-sticky-form" href="#get-offer">' . htmlspecialchars($cta[2]) . '</a>'
        . '</div>';
    return $h;
}

/** Small inline call-to-action used inside article bodies (<!--CTA--> marker). */
function inline_cta_html($lang, $segment) {
    $t = li_t($lang);
    $segment = isset($t['cta'][$segment]) ? $segment : 'general';
    $cta = $t['cta'][$segment];
    return '<aside class="li-inline-cta"><strong>' . htmlspecialchars($cta[0]) . '</strong> <a href="#get-offer">' . htmlspecialchars($cta[2]) . '</a></aside>';
}

function related_posts_html(array $post, $lang) {
    $ctx = li_ctx();
    $pool = [];
    foreach ($ctx['auto'] as $p) {
        if (($p['lang'] ?? 'en') === $lang && $p['id'] !== $post['id']) $pool[] = $p;
    }
    if ($lang === 'en') {
        foreach ($ctx['dynamic'] as $p) {
            if ($p['id'] !== $post['id']) $pool[] = $p + ['segment' => 'general'];
        }
    }
    if (!$pool) return '';
    $segment = $post['segment'] ?? 'general';
    usort($pool, function ($a, $b) use ($segment) {
        $sa = (($a['segment'] ?? '') === $segment) ? 1 : 0;
        $sb = (($b['segment'] ?? '') === $segment) ? 1 : 0;
        if ($sa !== $sb) return $sb <=> $sa;
        return li_post_ts($b) <=> li_post_ts($a);
    });
    $pool = array_slice($pool, 0, 3);
    $t = li_t($lang);
    $h = '<section class="li-related"><h2>' . htmlspecialchars($t['related']) . '</h2><div class="li-related-grid">';
    foreach ($pool as $p) {
        $h .= '<a class="blog-card" href="/blog/' . htmlspecialchars($p['id']) . '/">'
            . '<div class="blog-card-img"><img src="' . htmlspecialchars($p['image']) . '" alt="' . htmlspecialchars($p['imageAlt'] ?? $p['title']) . '" loading="lazy"></div>'
            . '<h3>' . htmlspecialchars($p['title']) . '</h3>'
            . '<div class="read-more">' . htmlspecialchars($t['read_more']) . '</div></a>';
    }
    return $h . '</div></section>';
}

/** Alternate-language URLs for an automatic post (same translation group). */
function li_alternates(array $post) {
    $alts = [];
    if (empty($post['group'])) return $alts;
    foreach (li_ctx()['auto'] as $p) {
        if (($p['group'] ?? '') === $post['group']) $alts[$p['lang']] = li_post_url($p['id']);
    }
    $ordered = [];
    foreach (li_langs() as $l) if (isset($alts[$l])) $ordered[$l] = $alts[$l];
    return $ordered;
}

function lang_switch_html(array $alternates, $current) {
    if (count($alternates) < 2) return '';
    $h = '<div class="li-lang-switch">';
    foreach ($alternates as $l => $url) {
        $name = li_t($l)['lang_name'];
        $h .= ($l === $current)
            ? '<span class="is-current" lang="' . $l . '">' . htmlspecialchars($name) . '</span>'
            : '<a href="' . htmlspecialchars(str_replace(SITE_URL, '', $url)) . '" hreflang="' . $l . '" lang="' . $l . '">' . htmlspecialchars($name) . '</a>';
    }
    return $h . '</div>';
}

/* ───────────────────────── post pages ───────────────────────── */

/** Build the full standalone HTML page for a single post. */
function build_post_page_html(array $post) {
    if (!empty($post['lang'])) {
        return build_auto_post_page_html($post);
    }
    $url = SITE_URL . '/blog/' . $post['id'] . '/';
    $desc = $post['excerpt'];
    $img = li_abs($post['image']);

    $schema = json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $post['title'],
        'description' => $desc,
        'image' => $img,
        'datePublished' => date('c', strtotime($post['date'])),
        'author' => ['@type' => 'Organization', 'name' => 'Land Istanbul'],
        'publisher' => ['@type' => 'Organization', 'name' => 'Land Istanbul', 'logo' => ['@type' => 'ImageObject', 'url' => SITE_URL . '/logo.png']],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    $bodyHtml = blocks_to_html($post['blocks'] ?? []);

    $html = page_head($post['title'] . ' — Land Istanbul', $desc, $url, $img);
    $html .= '<script type="application/ld+json">' . $schema . '</script>';
    $html .= '<div class="crumb-bar"><a href="/blog/">← All Articles</a></div>';
    $html .= '<div class="blog-hero">';
    $html .= '<img src="' . htmlspecialchars($post['image']) . '" alt="' . htmlspecialchars($post['imageAlt'] ?? $post['title']) . '">';
    $html .= '<div class="blog-hero-overlay"></div>';
    $html .= '<div class="blog-hero-text"><div class="blog-meta"><span class="blog-date-lg">' . htmlspecialchars($post['date']) . '</span><span class="blog-cat">Market Insights</span></div><h1>' . htmlspecialchars($post['title']) . '</h1></div>';
    $html .= '</div>';
    $html .= '<div class="blog-content-wrap">';
    $html .= '<p class="blog-excerpt">' . htmlspecialchars($post['excerpt']) . '</p>';
    $html .= '<div class="blog-body">' . $bodyHtml . '</div>';
    $html .= lead_box_html('en', 'general', $post['title'], $url);
    $html .= related_posts_html($post + ['segment' => 'general'], 'en');
    $html .= '</div>';
    $html .= page_footer();
    return $html;
}

/** Page for a post published from the repository (multilingual, FAQ, sources, lead box). */
function build_auto_post_page_html(array $post) {
    $lang = $post['lang'];
    $t = li_t($lang);
    $segment = $post['segment'] ?? 'general';
    $url = li_post_url($post['id']);
    $img = li_abs($post['image']);
    $ogImg = li_abs(!empty($post['og_image']) ? $post['og_image'] : $post['image']);
    $published = $post['published'];
    $updated = !empty($post['updated']) ? $post['updated'] : $published;
    $alternates = li_alternates($post);
    $seoTitle = !empty($post['seo_title']) ? $post['seo_title'] : $post['title'];
    $desc = !empty($post['description']) ? $post['description'] : $post['excerpt'];

    $graph = [];
    $graph[] = [
        '@type' => 'BlogPosting',
        '@id' => $url . '#article',
        'headline' => $post['title'],
        'description' => $desc,
        'image' => [$ogImg, $img],
        'inLanguage' => $lang,
        'datePublished' => date('c', strtotime($published . ' 09:00:00')),
        'dateModified' => date('c', strtotime($updated . ' 09:00:00')),
        'mainEntityOfPage' => $url,
        'articleSection' => $t['cat'][$segment] ?? $t['cat']['general'],
        'keywords' => implode(', ', $post['keywords'] ?? []),
        'author' => ['@type' => 'Organization', 'name' => 'Land Istanbul', 'url' => SITE_URL . '/'],
        'publisher' => ['@type' => 'Organization', 'name' => 'Land Istanbul', 'logo' => ['@type' => 'ImageObject', 'url' => SITE_URL . '/logo.png']],
    ];
    $graph[] = [
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Land Istanbul', 'item' => SITE_URL . '/'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => $t['blog_title'], 'item' => li_index_url($lang)],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $post['title'], 'item' => $url],
        ],
    ];
    if (!empty($post['faq'])) {
        $qa = [];
        foreach ($post['faq'] as $f) {
            $qa[] = ['@type' => 'Question', 'name' => $f['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']]];
        }
        $graph[] = ['@type' => 'FAQPage', 'mainEntity' => $qa];
    }
    $schema = json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    $body = $post['body_html'] ?? '';
    $body = str_replace('<!--CTA-->', inline_cta_html($lang, $segment), $body);

    $html = page_head($seoTitle . ' | Land Istanbul', $desc, $url, $ogImg, [
        'lang' => $lang,
        'alternates' => $alternates,
        'published' => date('c', strtotime($published . ' 09:00:00')),
        'modified' => date('c', strtotime($updated . ' 09:00:00')),
    ]);
    $html .= '<script type="application/ld+json">' . $schema . '</script>';
    $html .= '<div class="crumb-bar"><a href="/blog/' . ($lang === 'en' ? '' : $lang . '/') . '">' . htmlspecialchars($t['all_articles']) . '</a>' . lang_switch_html($alternates, $lang) . '</div>';
    $html .= '<div class="blog-hero">';
    $html .= '<img src="' . htmlspecialchars($post['image']) . '" alt="' . htmlspecialchars($post['imageAlt'] ?? $post['title']) . '" fetchpriority="high">';
    $html .= '<div class="blog-hero-overlay"></div>';
    $html .= '<div class="blog-hero-text"><div class="blog-meta"><time class="blog-date-lg" datetime="' . htmlspecialchars($published) . '">' . htmlspecialchars(li_format_date($published, $lang)) . '</time><span class="blog-cat">' . htmlspecialchars($t['cat'][$segment] ?? $t['cat']['general']) . '</span></div><h1>' . htmlspecialchars($post['title']) . '</h1></div>';
    $html .= '</div>';
    $html .= '<article class="blog-content-wrap">';
    $html .= '<p class="blog-excerpt">' . htmlspecialchars($post['excerpt']) . '</p>';
    if ($updated !== $published) {
        $html .= '<p class="li-updated">' . htmlspecialchars($t['updated']) . ': <time datetime="' . htmlspecialchars($updated) . '">' . htmlspecialchars(li_format_date($updated, $lang)) . '</time></p>';
    }
    $html .= '<div class="blog-body">' . $body . '</div>';
    if (!empty($post['faq'])) {
        $html .= '<section class="li-faq"><h2>' . htmlspecialchars($t['faq']) . '</h2>';
        foreach ($post['faq'] as $f) {
            $html .= '<details><summary>' . htmlspecialchars($f['q']) . '</summary><p>' . htmlspecialchars($f['a']) . '</p></details>';
        }
        $html .= '</section>';
    }
    $html .= lead_box_html($lang, $segment, $post['title'], $url);
    if (!empty($post['sources'])) {
        $html .= '<section class="li-sources"><h2>' . htmlspecialchars($t['sources']) . '</h2><ol>';
        foreach ($post['sources'] as $s) {
            $html .= '<li><a href="' . htmlspecialchars($s['url']) . '" target="_blank" rel="noopener nofollow">' . htmlspecialchars($s['title']) . '</a></li>';
        }
        $html .= '</ol></section>';
    }
    $html .= '<p class="li-disclaimer">' . htmlspecialchars($t['disclaimer']) . '</p>';
    $html .= related_posts_html($post, $lang);
    $html .= '</article>';
    $html .= page_footer();
    return $html;
}

/** Write / overwrite the static page for a post at /blog/{id}/index.html */
function write_post_page(array $post) {
    $dir = SITE_ROOT . '/blog/' . $post['id'];
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    file_put_contents($dir . '/index.html', build_post_page_html($post));
}

/** Remove a post's generated static page folder. */
function delete_post_page($id) {
    $dir = SITE_ROOT . '/blog/' . $id;
    if (is_dir($dir)) {
        $file = $dir . '/index.html';
        if (file_exists($file)) unlink($file);
        @rmdir($dir);
    }
}

/* ───────────────────────── blog index pages ───────────────────────── */

function blog_card_html(array $p, $lang) {
    $t = li_t($lang);
    $date = !empty($p['published']) ? li_format_date($p['published'], $lang) : $p['date'];
    return '<a class="blog-card" href="' . htmlspecialchars($p['url']) . '">' .
        '<div class="blog-card-img"><img src="' . htmlspecialchars($p['image']) . '" alt="' . htmlspecialchars($p['imageAlt'] ?? $p['title']) . '" loading="lazy"><div class="blog-date">' . htmlspecialchars($date) . '</div></div>' .
        '<h3>' . htmlspecialchars($p['title']) . '</h3>' .
        '<p>' . htmlspecialchars($p['excerpt']) . '</p>' .
        '<div class="read-more">' . htmlspecialchars($t['read_more']) . '</div>' .
        '</a>';
}

/** Rebuild the crawlable /blog/ index pages (English + one per extra language). */
function build_blog_index(array $dynamicPosts) {
    $auto = li_ctx()['auto'];
    $langsWithPosts = ['en' => true];
    foreach ($auto as $p) $langsWithPosts[$p['lang']] = true;

    foreach (li_langs() as $lang) {
        if (empty($langsWithPosts[$lang])) continue;
        $t = li_t($lang);
        $all = [];
        foreach ($auto as $p) {
            if ($p['lang'] === $lang) $all[] = $p + ['url' => '/blog/' . $p['id'] . '/'];
        }
        if ($lang === 'en') {
            foreach ($dynamicPosts as $p) {
                $all[] = ['id' => $p['id'], 'title' => $p['title'], 'excerpt' => $p['excerpt'], 'image' => $p['image'], 'imageAlt' => $p['imageAlt'] ?? $p['title'], 'date' => $p['date'], 'url' => '/blog/' . $p['id'] . '/'];
            }
            foreach (legacy_posts() as $p) {
                $all[] = ['id' => $p['id'], 'title' => $p['title'], 'excerpt' => $p['excerpt'], 'image' => $p['image'], 'date' => $p['date'], 'url' => '/#blogs'];
            }
        }
        usort($all, function ($a, $b) {
            return li_post_ts($b) <=> li_post_ts($a);
        });

        $cardsHtml = '';
        foreach ($all as $p) $cardsHtml .= blog_card_html($p, $lang);

        $alternates = [];
        foreach (li_langs() as $l) if (!empty($langsWithPosts[$l])) $alternates[$l] = li_index_url($l);

        $html = page_head($t['blog_title'] . ' — Land Istanbul', $t['blog_desc'], li_index_url($lang), SITE_URL . '/og-image.png', [
            'lang' => $lang, 'alternates' => $alternates, 'type' => 'website',
        ]);
        $html .= '<div class="blog-index-header"><span class="section-tag">' . htmlspecialchars($t['blog_tag']) . '</span><h1>' . htmlspecialchars($t['blog_title']) . '</h1>' . lang_switch_html($alternates, $lang) . '</div>';
        $html .= '<div class="blog-list-grid">' . $cardsHtml . '</div>';
        $html .= page_footer();

        $dir = SITE_ROOT . '/blog' . ($lang === 'en' ? '' : '/' . $lang);
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        file_put_contents($dir . '/index.html', $html);
    }
}

/** Rewrite the auto-generated block of sitemap.xml between markers with current posts. */
function update_sitemap(array $dynamicPosts) {
    $sitemapFile = SITE_ROOT . '/sitemap.xml';
    if (!file_exists($sitemapFile)) return;

    $content = file_get_contents($sitemapFile);
    $startMarker = '<!-- BLOG-URLS-START -->';
    $endMarker = '<!-- BLOG-URLS-END -->';
    $auto = li_ctx()['auto'];

    $entries = "  <url>\n    <loc>" . SITE_URL . "/blog/</loc>\n    <changefreq>daily</changefreq>\n    <priority>0.7</priority>\n  </url>\n";
    if (function_exists('lv_url')) {
        foreach (['en', 'ar', 'ru'] as $l) {
            $entries .= "  <url>\n    <loc>" . lv_url($l) . "</loc>\n    <changefreq>monthly</changefreq>\n    <priority>" . ($l === 'en' ? '0.9' : '0.8') . "</priority>\n  </url>\n";
        }
    }
    foreach (['ar', 'ru'] as $l) {
        $entries .= "  <url>\n    <loc>" . SITE_URL . "/tax-calculator/" . $l . "/</loc>\n    <changefreq>monthly</changefreq>\n    <priority>0.8</priority>\n  </url>\n";
    }
    if (function_exists('le_url')) {
        foreach (['en', 'ar', 'ru'] as $l) {
            $entries .= "  <url>\n    <loc>" . le_url($l) . "</loc>\n    <changefreq>monthly</changefreq>\n    <priority>" . ($l === 'en' ? '0.9' : '0.8') . "</priority>\n  </url>\n";
        }
    }
    if (function_exists('lc_all_urls')) {
        foreach (lc_all_urls() as $u) {
            $entries .= "  <url>\n    <loc>" . $u . "</loc>\n    <changefreq>monthly</changefreq>\n    <priority>0.8</priority>\n  </url>\n";
        }
    }
    $seenLang = [];
    foreach ($auto as $p) {
        if ($p['lang'] !== 'en' && empty($seenLang[$p['lang']])) {
            $seenLang[$p['lang']] = true;
            $entries .= "  <url>\n    <loc>" . li_index_url($p['lang']) . "</loc>\n    <changefreq>daily</changefreq>\n    <priority>0.6</priority>\n  </url>\n";
        }
    }
    foreach ($auto as $p) {
        $lastmod = !empty($p['updated']) ? $p['updated'] : $p['published'];
        $entries .= "  <url>\n    <loc>" . htmlspecialchars(li_post_url($p['id'])) . "</loc>\n    <lastmod>" . htmlspecialchars($lastmod) . "</lastmod>\n    <changefreq>monthly</changefreq>\n    <priority>0.6</priority>\n  </url>\n";
    }
    foreach ($dynamicPosts as $p) {
        $lastmod = date('Y-m-d', strtotime($p['date']) ?: time());
        $entries .= "  <url>\n    <loc>" . SITE_URL . "/blog/" . htmlspecialchars($p['id']) . "/</loc>\n    <lastmod>" . $lastmod . "</lastmod>\n    <changefreq>monthly</changefreq>\n    <priority>0.6</priority>\n  </url>\n";
    }

    $block = $startMarker . "\n" . $entries . $endMarker;

    if (strpos($content, $startMarker) !== false && strpos($content, $endMarker) !== false) {
        $content = preg_replace('/' . preg_quote($startMarker, '/') . '.*?' . preg_quote($endMarker, '/') . '/s', str_replace(['\\', '$'], ['\\\\', '\\$'], $block), $content);
    } else {
        $content = str_replace('</urlset>', $block . "\n</urlset>", $content);
    }

    file_put_contents($sitemapFile, $content);
}

/** Remove pages of automatic posts that were removed from the repository. */
function cleanup_auto_pages(array $auto) {
    $now = array_map(function ($p) { return $p['id']; }, $auto);
    $before = file_exists(AUTO_PAGES_FILE) ? (json_decode(file_get_contents(AUTO_PAGES_FILE), true) ?: []) : [];
    foreach (array_diff($before, $now) as $gone) {
        if (is_string($gone) && $gone !== '' && strpos($gone, '..') === false) delete_post_page($gone);
    }
    if (is_dir(dirname(AUTO_PAGES_FILE))) {
        file_put_contents(AUTO_PAGES_FILE, json_encode(array_values($now), JSON_UNESCAPED_SLASHES));
    }
}

/**
 * Public feed of the newest English posts (admin + automatic) for the homepage's blog section.
 * Same shape as blog-data.json entries; index.html reads it first and falls back to blog-data.json.
 */
function write_homepage_feed(array $dynamicPosts, array $auto, $limit = 6) {
    $all = [];
    foreach ($dynamicPosts as $p) {
        $all[] = ['id' => $p['id'], 'title' => $p['title'], 'excerpt' => $p['excerpt'], 'image' => $p['image'],
                  'imageAlt' => $p['imageAlt'] ?? $p['title'], 'date' => $p['date']];
    }
    foreach ($auto as $p) {
        if (($p['lang'] ?? '') !== 'en') continue;
        $all[] = ['id' => $p['id'], 'title' => $p['title'], 'excerpt' => $p['excerpt'], 'image' => $p['image'],
                  'imageAlt' => $p['imageAlt'] ?? $p['title'], 'date' => $p['date'], 'published' => $p['published']];
    }
    usort($all, function ($a, $b) {
        return li_post_ts($b) <=> li_post_ts($a);
    });
    $all = array_slice($all, 0, $limit);
    foreach ($all as &$p) unset($p['published']);
    unset($p);
    file_put_contents(SITE_ROOT . '/blog-feed.json', json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}

/** Regenerate everything derived from blog-data.json and blog-auto.json (call after any save/delete). */
function regenerate_all(array $dynamicPosts) {
    $dynamicIds = array_column($dynamicPosts, 'id');
    $auto = array_values(array_filter(load_auto_posts(), function ($p) use ($dynamicIds) {
        return !empty($p['id']) && !empty($p['lang']) && !in_array($p['id'], $dynamicIds, true);
    }));
    li_ctx(['dynamic' => $dynamicPosts, 'auto' => $auto]);

    foreach ($dynamicPosts as $p) {
        write_post_page($p);
    }
    foreach ($auto as $p) {
        write_post_page($p);
    }
    cleanup_auto_pages($auto);
    build_blog_index($dynamicPosts);
    update_sitemap($dynamicPosts);
    write_homepage_feed($dynamicPosts, $auto);
    if (function_exists('write_valuation_pages')) write_valuation_pages();
    if (function_exists('write_eligibility_pages')) write_eligibility_pages();
    if (function_exists('write_country_pages')) write_country_pages();
}
