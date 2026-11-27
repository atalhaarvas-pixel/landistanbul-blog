<?php
/**
 * Turkey property tax & buying-costs calculator: /turkey-property-tax-calculator/ (+ /ar/, /ru/).
 * Targets the Search Console query "property tax calculator turkey" (505 impressions, Nov 2026).
 * 2026 figures (check every January):
 *  - Annual property tax (Emlak Vergisi Kanunu 1319, rates unchanged for 2026; doubled inside metropolitan
 *    municipalities): residential 0.1% / 0.2%, other buildings 0.2% / 0.4%, land plot (arsa) 0.3% / 0.6%,
 *    field (arazi) 0.1% / 0.2%. Base = the municipal tax value, not the market price. Two instalments (May, Nov).
 *  - Valuable housing tax 2026 (89 Seri No.lu EVK Genel Tebliği, Resmî Gazete 31.12.2025): threshold
 *    ₺17,711,000; 0.3% up to ₺26,567,000, 0.6% up to ₺35,425,000, 1% above (on the part above the threshold).
 *  - Title deed fee (Harçlar Kanunu 492): 2% buyer + 2% seller on the declared price (not below the tax value).
 *  - TKGM revolving-fund fee 2026: indicator ₺2,227 × local coefficient (+₺307 per extra unit); e.g. ₺6,681 at 3.
 */
const PT_DATA = [
    'year' => 2026,
    'rates' => ['res' => 0.001, 'com' => 0.002, 'plot' => 0.003, 'field' => 0.001], // doubled in metropolitan areas
    'dkv' => [17711000, 26567000, 35425000], 'dkv_rates' => [0.003, 0.006, 0.01],
    'deed' => 0.02, 'tkgm' => 2227, 'coef' => 3,
];

function pt_url($lang) { return SITE_URL . '/turkey-property-tax-calculator/' . ($lang === 'en' ? '' : $lang . '/'); }

function pt_t($lang) {
    $en = [
        'seo_title' => 'Turkey Property Tax Calculator 2026: Annual Tax & Title Deed Fees',
        'description' => 'Free 2026 calculator: annual property tax (emlak vergisi), valuable housing tax and title deed fees when you buy property in Turkey. Official rates, in Turkish lira.',
        'tag' => 'Free calculator · 2026 rates', 'crumb' => 'Property tax calculator',
        'h1' => 'Turkey property tax calculator 2026',
        'lead' => 'Two answers in one place: how much property tax you pay every year in Turkey, and what the title deed fee costs when you buy. Official 2026 rates, all amounts in Turkish lira.',
        'tab_a' => 'Annual property tax', 'tab_b' => 'Buying costs (title deed)',
        'type' => 'Property type', 'types' => ['res' => 'Home (apartment, villa)', 'com' => 'Shop, office, other building', 'plot' => 'Building plot (arsa)', 'field' => 'Field (arazi)'],
        'where' => 'Where is it?', 'metro' => 'Istanbul or another metropolitan city', 'other' => 'Other city or town',
        'tv' => 'Tax value of the property (₺)', 'tv_hint' => 'The municipal tax value (emlak vergi değeri), usually well below the market price. Ask the municipality or check your title deed fee receipt. Not sure? Enter the price to see the maximum.',
        'annual' => 'Annual property tax', 'inst' => 'Paid in two instalments: May and November', 'each' => 'each',
        'dkv_h' => 'Valuable housing tax', 'dkv_none' => 'Not due: tax value is under ₺17,711,000 (2026 threshold).', 'dkv_yes' => 'May be due: homes with a tax value over ₺17,711,000. Declared and paid in February of the next year; exemptions exist.',
        'price' => 'Sale price written on the title deed (₺)', 'price_hint' => 'Must not be lower than the property\'s tax value; under-declaring brings fines.',
        'who' => 'Who pays the title deed fee?', 'split' => 'Split by law: 2% buyer + 2% seller', 'buyer_all' => 'Buyer pays all 4% (common in practice)',
        'coef' => 'Local coefficient for the land registry fee', 'coef_hint' => 'Set by TKGM for each registry office; 3 is used as an example. The exact fee is shown at your appointment.',
        'buyer' => 'Buyer pays', 'seller' => 'Seller pays', 'deed_fee' => 'Title deed fee', 'rf' => 'Land registry service fee',
        'extra_h' => 'Also budget for (foreign buyers)', 'extras' => ['Official valuation report (required for foreigners)', 'Sworn translator at the title deed office', 'Compulsory earthquake insurance (DASK)', 'Notary power of attorney, if you buy from abroad', 'VAT on new-build sales by developers (exemptions may apply)'],
        'cta_h' => 'Want the exact costs for a property?', 'cta_p' => 'Send the property or your budget. We check the tax value, title deed and zoning and send you a full cost list, free.',
        'interest' => 'Buying an apartment',
        'faq_h' => 'Questions foreigners ask',
        'faq' => [
            ['How much is property tax in Turkey?', 'Property tax is charged every year on the municipal tax value: 0.2% for homes inside metropolitan cities such as Istanbul (0.1% elsewhere), 0.4% for shops and offices, 0.6% for building plots and 0.2% for fields. It is paid in two instalments, in May and November.'],
            ['Is the property tax based on the price I paid?', 'No. It is based on the tax value set by the municipality, which is usually lower than the market price. Since 2026 the increase of this value is capped by law.'],
            ['How much is the title deed fee in Turkey in 2026?', '4% of the declared sale price: by law 2% is paid by the buyer and 2% by the seller, but in many sales the buyer pays all of it. A land registry service fee is added (₺2,227 × the local coefficient in 2026).'],
            ['What is the valuable housing tax?', 'An extra yearly tax on homes with a tax value above ₺17,711,000 in 2026: 0.3%, 0.6% or 1% on the part above the threshold, declared and paid in February of the following year. Some owners are exempt.'],
            ['Do foreigners pay the same property tax?', 'Yes. Foreign owners pay the same annual property tax and title deed fee as Turkish owners. Foreign buyers additionally need an official valuation report before the title deed transfer.'],
        ],
        'sources' => 'Sources: Property Tax Law 1319 and General Communiqué No. 89 (Official Gazette, 31 Dec 2025); Fees Law 492; TKGM 2026 fee tariff. General information, not tax advice; rates as of November 2026.',
        'other_tool' => 'Selling? Calculate capital gains tax →',
        'name' => 'Your name', 'phone' => 'Phone / WhatsApp', 'email' => 'Email', 'send' => 'Send me the cost list',
        'ok' => 'Thank you! We will contact you within one business day.', 'err' => 'Something went wrong. Please try WhatsApp.', 'need' => 'Please add a phone number or email.', 'sending' => 'Sending…',
        'privacy' => 'We use your details only to answer you.', 'wa_text' => 'Hello Land Istanbul, I would like the full cost list for buying a property.',
    ];
    $ar = [
        'seo_title' => 'حاسبة ضريبة العقار في تركيا 2026: الضريبة السنوية ورسوم الطابو',
        'description' => 'حاسبة مجانية لعام 2026: ضريبة العقار السنوية (Emlak Vergisi) وضريبة المساكن الفاخرة ورسوم الطابو عند شراء عقار في تركيا. أسعار رسمية، بالليرة التركية.',
        'tag' => 'حاسبة مجانية · أسعار 2026', 'crumb' => 'حاسبة ضريبة العقار',
        'h1' => 'حاسبة ضريبة العقار في تركيا 2026',
        'lead' => 'جوابان في مكان واحد: كم تدفع ضريبة عقار سنوياً في تركيا، وكم تكلّف رسوم الطابو عند الشراء. أسعار 2026 الرسمية، وكل المبالغ بالليرة التركية.',
        'tab_a' => 'ضريبة العقار السنوية', 'tab_b' => 'تكاليف الشراء (الطابو)',
        'type' => 'نوع العقار', 'types' => ['res' => 'مسكن (شقة، فيلا)', 'com' => 'محل، مكتب، مبنى آخر', 'plot' => 'أرض للبناء (Arsa)', 'field' => 'أرض زراعية (Arazi)'],
        'where' => 'أين يقع العقار؟', 'metro' => 'إسطنبول أو مدينة كبرى أخرى', 'other' => 'مدينة أو بلدة أخرى',
        'tv' => 'القيمة الضريبية للعقار (₺)', 'tv_hint' => 'القيمة الضريبية لدى البلدية (emlak vergi değeri)، وهي عادة أقل بكثير من سعر السوق. اسأل البلدية أو راجع إيصال رسوم الطابو. غير متأكد؟ أدخل السعر لترى الحد الأقصى.',
        'annual' => 'ضريبة العقار السنوية', 'inst' => 'تُدفع على قسطين: مايو ونوفمبر', 'each' => 'لكل قسط',
        'dkv_h' => 'ضريبة المساكن عالية القيمة', 'dkv_none' => 'غير مستحقة: القيمة الضريبية أقل من 17,711,000 ليرة (حد 2026).', 'dkv_yes' => 'قد تكون مستحقة: للمساكن التي تتجاوز قيمتها الضريبية 17,711,000 ليرة. يُصرَّح بها وتُدفع في فبراير من العام التالي، وتوجد إعفاءات.',
        'price' => 'سعر البيع المكتوب في سند الطابو (₺)', 'price_hint' => 'يجب ألا يقل عن القيمة الضريبية للعقار؛ التصريح بأقل من ذلك يترتب عليه غرامات.',
        'who' => 'من يدفع رسوم الطابو؟', 'split' => 'حسب القانون: 2% المشتري + 2% البائع', 'buyer_all' => 'المشتري يدفع 4% كاملة (شائع عملياً)',
        'coef' => 'المعامل المحلي لرسوم السجل العقاري', 'coef_hint' => 'تحدده المديرية العامة للطابو (TKGM) لكل مكتب؛ استخدمنا 3 كمثال. يظهر المبلغ الدقيق يوم الموعد.',
        'buyer' => 'يدفع المشتري', 'seller' => 'يدفع البائع', 'deed_fee' => 'رسوم الطابو', 'rf' => 'رسوم خدمة السجل العقاري',
        'extra_h' => 'ضع في ميزانيتك أيضاً (للمشترين الأجانب)', 'extras' => ['تقرير تقييم رسمي (إلزامي للأجانب)', 'مترجم محلّف في مكتب الطابو', 'تأمين الزلازل الإلزامي (DASK)', 'وكالة لدى كاتب العدل إذا كنت تشتري من الخارج', 'ضريبة القيمة المضافة على المشاريع الجديدة من المطوّرين (قد توجد إعفاءات)'],
        'cta_h' => 'تريد التكاليف الدقيقة لعقار معيّن؟', 'cta_p' => 'أرسل لنا العقار أو ميزانيتك. نتحقق من القيمة الضريبية والطابو والتنظيم العمراني ونرسل لك قائمة تكاليف كاملة مجاناً.',
        'interest' => 'Buying an apartment',
        'faq_h' => 'أسئلة يطرحها الأجانب',
        'faq' => [
            ['كم تبلغ ضريبة العقار في تركيا؟', 'تُفرض سنوياً على القيمة الضريبية لدى البلدية: 0.2% للمساكن داخل المدن الكبرى مثل إسطنبول (0.1% في غيرها)، و0.4% للمحلات والمكاتب، و0.6% لأراضي البناء، و0.2% للأراضي الزراعية. وتُدفع على قسطين في مايو ونوفمبر.'],
            ['هل تُحسب الضريبة على السعر الذي دفعته؟', 'لا. تُحسب على القيمة الضريبية التي تحددها البلدية، وهي عادة أقل من سعر السوق. ومنذ 2026 أصبحت زيادة هذه القيمة محدودة بالقانون.'],
            ['كم رسوم الطابو في تركيا عام 2026؟', '4% من سعر البيع المصرّح به: قانونياً 2% على المشتري و2% على البائع، لكن في كثير من الصفقات يدفعها المشتري كاملة. وتضاف رسوم خدمة السجل العقاري (2,227 ليرة × المعامل المحلي في 2026).'],
            ['ما ضريبة المساكن عالية القيمة؟', 'ضريبة سنوية إضافية على المساكن التي تتجاوز قيمتها الضريبية 17,711,000 ليرة في 2026: 0.3% أو 0.6% أو 1% على الجزء الزائد عن الحد، ويُصرَّح بها وتُدفع في فبراير من العام التالي. بعض المالكين معفون.'],
            ['هل يدفع الأجانب الضريبة نفسها؟', 'نعم. يدفع المالك الأجنبي ضريبة العقار السنوية ورسوم الطابو نفسها كالمالك التركي، ويحتاج المشتري الأجنبي إضافةً إلى ذلك إلى تقرير تقييم رسمي قبل نقل الملكية.'],
        ],
        'sources' => 'المصادر: قانون ضريبة العقار 1319 والبلاغ العام رقم 89 (الجريدة الرسمية، 31 ديسمبر 2025)؛ قانون الرسوم 492؛ تعرفة TKGM لعام 2026. معلومات عامة وليست استشارة ضريبية؛ الأسعار حتى نوفمبر 2026.',
        'other_tool' => 'تبيع؟ احسب ضريبة أرباح البيع ←',
        'name' => 'الاسم', 'phone' => 'الهاتف / واتساب', 'email' => 'البريد الإلكتروني', 'send' => 'أرسلوا لي قائمة التكاليف',
        'ok' => 'شكراً لك! سنتواصل معك خلال يوم عمل واحد.', 'err' => 'حدث خطأ. يرجى التواصل عبر واتساب.', 'need' => 'يرجى إضافة رقم هاتف أو بريد إلكتروني.', 'sending' => 'جارٍ الإرسال…',
        'privacy' => 'نستخدم بياناتك فقط للرد عليك.', 'wa_text' => 'مرحباً Land Istanbul، أرغب في قائمة التكاليف الكاملة لشراء عقار.',
    ];
    $ru = [
        'seo_title' => 'Калькулятор налога на недвижимость в Турции 2026: налог и сбор ТАПУ',
        'description' => 'Бесплатный калькулятор 2026: ежегодный налог на недвижимость (emlak vergisi), налог на дорогое жильё и сбор за ТАПУ при покупке в Турции. Официальные ставки, в лирах.',
        'tag' => 'Бесплатный калькулятор · ставки 2026', 'crumb' => 'Калькулятор налога на недвижимость',
        'h1' => 'Калькулятор налога на недвижимость в Турции 2026',
        'lead' => 'Два ответа в одном месте: сколько налога на недвижимость вы платите в Турции каждый год и сколько стоит сбор за ТАПУ при покупке. Официальные ставки 2026 года, все суммы в турецких лирах.',
        'tab_a' => 'Ежегодный налог', 'tab_b' => 'Расходы при покупке (ТАПУ)',
        'type' => 'Тип объекта', 'types' => ['res' => 'Жильё (квартира, вилла)', 'com' => 'Магазин, офис, другое здание', 'plot' => 'Участок под застройку (arsa)', 'field' => 'Сельхозземля (arazi)'],
        'where' => 'Где находится объект?', 'metro' => 'Стамбул или другой мегаполис', 'other' => 'Другой город',
        'tv' => 'Налоговая стоимость объекта (₺)', 'tv_hint' => 'Налоговая стоимость в муниципалитете (emlak vergi değeri), обычно значительно ниже рыночной цены. Узнайте в муниципалитете или по квитанции сбора ТАПУ. Не знаете? Введите цену, чтобы увидеть максимум.',
        'annual' => 'Ежегодный налог на недвижимость', 'inst' => 'Платится двумя частями: в мае и ноябре', 'each' => 'каждая',
        'dkv_h' => 'Налог на дорогое жильё', 'dkv_none' => 'Не начисляется: налоговая стоимость ниже ₺17 711 000 (порог 2026).', 'dkv_yes' => 'Может начисляться: жильё с налоговой стоимостью выше ₺17 711 000. Декларируется и платится в феврале следующего года; есть льготы.',
        'price' => 'Цена продажи в документе ТАПУ (₺)', 'price_hint' => 'Не может быть ниже налоговой стоимости объекта; занижение цены грозит штрафами.',
        'who' => 'Кто платит сбор ТАПУ?', 'split' => 'По закону: 2% покупатель + 2% продавец', 'buyer_all' => 'Покупатель платит все 4% (часто на практике)',
        'coef' => 'Местный коэффициент сбора реестра', 'coef_hint' => 'Устанавливается TKGM для каждого отделения; для примера взят 3. Точная сумма — в день сделки.',
        'buyer' => 'Платит покупатель', 'seller' => 'Платит продавец', 'deed_fee' => 'Сбор ТАПУ', 'rf' => 'Сбор за услуги реестра',
        'extra_h' => 'Заложите также (для иностранцев)', 'extras' => ['Официальный отчёт об оценке (обязателен для иностранцев)', 'Присяжный переводчик в отделении ТАПУ', 'Обязательная страховка от землетрясений (DASK)', 'Нотариальная доверенность, если покупаете из-за рубежа', 'НДС при покупке новостройки у застройщика (возможны льготы)'],
        'cta_h' => 'Нужны точные расходы по конкретному объекту?', 'cta_p' => 'Пришлите объект или бюджет. Мы проверим налоговую стоимость, ТАПУ и зонирование и бесплатно пришлём полный список расходов.',
        'interest' => 'Buying an apartment',
        'faq_h' => 'Частые вопросы иностранцев',
        'faq' => [
            ['Какой налог на недвижимость в Турции?', 'Налог платится ежегодно с налоговой стоимости в муниципалитете: 0,2% для жилья в мегаполисах, например в Стамбуле (0,1% в других местах), 0,4% для магазинов и офисов, 0,6% для участков под застройку и 0,2% для сельхозземли. Платится двумя частями — в мае и ноябре.'],
            ['Налог считается от цены покупки?', 'Нет. Он считается от налоговой стоимости, которую устанавливает муниципалитет; обычно она ниже рыночной цены. С 2026 года рост этой стоимости ограничен законом.'],
            ['Сколько стоит сбор ТАПУ в Турции в 2026 году?', '4% от заявленной цены: по закону 2% платит покупатель и 2% продавец, но во многих сделках всё платит покупатель. Добавляется сбор за услуги реестра (₺2 227 × местный коэффициент в 2026 году).'],
            ['Что такое налог на дорогое жильё?', 'Дополнительный ежегодный налог на жильё с налоговой стоимостью выше ₺17 711 000 в 2026 году: 0,3%, 0,6% или 1% с части выше порога; декларируется и платится в феврале следующего года. Некоторые владельцы освобождены.'],
            ['Иностранцы платят такой же налог?', 'Да. Иностранные владельцы платят тот же ежегодный налог и сбор ТАПУ, что и граждане Турции. Иностранному покупателю дополнительно нужен официальный отчёт об оценке перед переоформлением.'],
        ],
        'sources' => 'Источники: Закон о налоге на недвижимость 1319 и Общее сообщение № 89 (Официальная газета, 31.12.2025); Закон о сборах 492; тариф TKGM на 2026 год. Общая информация, не налоговая консультация; ставки на ноябрь 2026.',
        'other_tool' => 'Продаёте? Рассчитайте налог с продажи →',
        'name' => 'Ваше имя', 'phone' => 'Телефон / WhatsApp', 'email' => 'Эл. почта', 'send' => 'Пришлите список расходов',
        'ok' => 'Спасибо! Мы свяжемся с вами в течение рабочего дня.', 'err' => 'Что-то пошло не так. Напишите нам в WhatsApp.', 'need' => 'Укажите телефон или e-mail.', 'sending' => 'Отправка…',
        'privacy' => 'Мы используем ваши данные только для ответа вам.', 'wa_text' => 'Здравствуйте, Land Istanbul! Хочу получить полный список расходов на покупку недвижимости.',
    ];
    $all = ['en' => $en, 'ar' => $ar, 'ru' => $ru];
    return $all[$lang] ?? $en;
}

function build_proptax_page_html($lang) {
    $t = pt_t($lang);
    $h = function ($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); };
    $url = pt_url($lang);
    $alternates = ['en' => pt_url('en'), 'ar' => pt_url('ar'), 'ru' => pt_url('ru')];
    $wa = 'https://wa.me/' . WHATSAPP_NUMBER . '?text=' . rawurlencode($t['wa_text']);
    $faq = [];
    foreach ($t['faq'] as $f) $faq[] = ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]];
    $schema = json_encode(['@context' => 'https://schema.org', '@graph' => [
        ['@type' => 'WebApplication', 'name' => $t['h1'], 'description' => $t['description'], 'url' => $url, 'inLanguage' => $lang,
         'applicationCategory' => 'FinanceApplication', 'operatingSystem' => 'All', 'isAccessibleForFree' => true,
         'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'TRY'],
         'publisher' => ['@type' => 'RealEstateAgent', 'name' => 'Land Istanbul', 'url' => SITE_URL . '/']],
        ['@type' => 'BreadcrumbList', 'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Land Istanbul', 'item' => SITE_URL . '/'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => $t['crumb'], 'item' => $url]]],
        ['@type' => 'FAQPage', 'mainEntity' => $faq],
    ]], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);

    $o = page_head($t['seo_title'] . ' | Land Istanbul', $t['description'], $url, SITE_URL . '/og-image.png', [
        'lang' => $lang, 'alternates' => $alternates, 'type' => 'website',
    ]);
    $o .= '<script type="application/ld+json">' . $schema . '</script>';
    $o .= '<main class="le pt" id="pt" data-lang="' . $lang . '"><section class="le-hero"><div class="lv-wrap"><div class="li-lang-switch">';
    foreach ($alternates as $l => $u) {
        $name = li_t($l)['lang_name'];
        $o .= $l === $lang ? '<span class="is-current">' . $h($name) . '</span>' : '<a href="' . $h(str_replace(SITE_URL, '', $u)) . '" hreflang="' . $l . '">' . $h($name) . '</a>';
    }
    $o .= '</div><span class="lv-tag">' . $h($t['tag']) . '</span><h1>' . $h($t['h1']) . '</h1><p class="lv-lead">' . $h($t['lead']) . '</p></div></section>';

    $o .= '<section class="pt-calc"><div class="lv-wrap"><div class="pt-tabs" role="tablist"><button type="button" class="on" data-tab="a">' . $h($t['tab_a']) . '</button><button type="button" data-tab="b">' . $h($t['tab_b']) . '</button></div>';
    // panel A
    $o .= '<div class="pt-grid" data-panel="a"><div class="pt-form">';
    $o .= '<label>' . $h($t['type']) . '<select id="pt-type">';
    foreach ($t['types'] as $k => $v) $o .= '<option value="' . $k . '">' . $h($v) . '</option>';
    $o .= '</select></label><div class="pt-seg"><span>' . $h($t['where']) . '</span><label><input type="radio" name="pt-loc" value="metro" checked> ' . $h($t['metro']) . '</label><label><input type="radio" name="pt-loc" value="other"> ' . $h($t['other']) . '</label></div>';
    $o .= '<label>' . $h($t['tv']) . '<div class="pt-money"><b>₺</b><input id="pt-tv" dir="ltr" inputmode="numeric" value="5.000.000"></div><small>' . $h($t['tv_hint']) . '</small></label></div>';
    $o .= '<div class="pt-res"><span>' . $h($t['annual']) . '</span><strong id="pt-annual">—</strong><em id="pt-inst"></em><div class="pt-dkv"><b>' . $h($t['dkv_h']) . '</b><p id="pt-dkv"></p></div></div></div>';
    // panel B
    $o .= '<div class="pt-grid" data-panel="b" hidden><div class="pt-form">';
    $o .= '<label>' . $h($t['price']) . '<div class="pt-money"><b>₺</b><input id="pt-price" dir="ltr" inputmode="numeric" value="10.000.000"></div><small>' . $h($t['price_hint']) . '</small></label>';
    $o .= '<div class="pt-seg"><span>' . $h($t['who']) . '</span><label><input type="radio" name="pt-who" value="split" checked> ' . $h($t['split']) . '</label><label><input type="radio" name="pt-who" value="buyer"> ' . $h($t['buyer_all']) . '</label></div>';
    $o .= '<label>' . $h($t['coef']) . '<input id="pt-coef" dir="ltr" inputmode="decimal" value="3"><small>' . $h($t['coef_hint']) . '</small></label></div>';
    $o .= '<div class="pt-res"><div class="pt-two"><div><span>' . $h($t['buyer']) . '</span><strong id="pt-buyer">—</strong></div><div><span>' . $h($t['seller']) . '</span><strong id="pt-seller">—</strong></div></div>';
    $o .= '<ul class="pt-lines"><li><span>' . $h($t['deed_fee']) . '</span><b id="pt-deed">—</b></li><li><span>' . $h($t['rf']) . '</span><b id="pt-rf">—</b></li></ul>';
    $o .= '<div class="pt-extra"><b>' . $h($t['extra_h']) . '</b><ul>';
    foreach ($t['extras'] as $x) $o .= '<li>' . $h($x) . '</li>';
    $o .= '</ul></div></div></div>';
    $o .= '<p class="pt-src">' . $h($t['sources']) . '</p><a class="lv-taxlink" href="' . $h(str_replace(SITE_URL, '', SITE_URL . '/tax-calculator/' . ($lang === 'en' ? '' : $lang . '/'))) . '">' . $h($t['other_tool']) . '</a></div></section>';

    // lead form
    $o .= '<section class="lv-band"><div class="lv-wrap pt-cta"><div><h2>' . $h($t['cta_h']) . '</h2><p>' . $h($t['cta_p']) . '</p><a class="lv-wa" href="' . $h($wa) . '" target="_blank" rel="noopener" data-track="whatsapp">WhatsApp</a></div>';
    $o .= '<form class="li-lead-form" method="post" action="/mail.php" novalidate data-ok="' . $h($t['ok']) . '" data-err="' . $h($t['err']) . '" data-need="' . $h($t['need']) . '" data-sending="' . $h($t['sending']) . '">';
    $o .= '<input type="hidden" name="source" value="' . $h($url) . '"><input type="hidden" name="lang" value="' . $lang . '"><input type="hidden" name="interest" value="' . $h($t['interest']) . '"><input type="hidden" name="p_calculation" id="pt-calc" value="">';
    $o .= '<div class="li-hp" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>';
    $o .= '<input type="text" name="name" placeholder="' . $h($t['name']) . '" aria-label="' . $h($t['name']) . '" autocomplete="name">';
    $o .= '<div class="lv-two"><input type="tel" name="phone" dir="ltr" placeholder="' . $h($t['phone']) . '" aria-label="' . $h($t['phone']) . '" autocomplete="tel"><input type="email" name="email" placeholder="' . $h($t['email']) . '" aria-label="' . $h($t['email']) . '" autocomplete="email"></div>';
    $o .= '<button type="submit" class="li-submit">' . $h($t['send']) . '</button><p class="li-status" role="status" aria-live="polite"></p><p class="li-privacy">' . $h($t['privacy']) . '</p></form></div></section>';

    // FAQ (visible, matches schema)
    $o .= '<section class="pt-faq"><div class="lv-wrap"><h2>' . $h($t['faq_h']) . '</h2>';
    foreach ($t['faq'] as $f) $o .= '<details><summary>' . $h($f[0]) . '</summary><p>' . $h($f[1]) . '</p></details>';
    $o .= '</div></section></main>';
    $o .= '<script>window.PT=' . json_encode(['d' => PT_DATA, 'each' => $t['each'], 'inst' => $t['inst'], 'dkv_none' => $t['dkv_none'], 'dkv_yes' => $t['dkv_yes']], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . ';</script>';
    $o .= '<script>' . pt_js() . '</script>';
    $o .= page_footer();
    return $o;
}

function pt_js() {
    return <<<'JS'
(function(){
  var P = window.PT, D = P.d, root = document.getElementById('pt'); if (!root) return;
  var lang = root.dataset.lang, loc = lang === 'ar' ? 'ar-EG' : lang === 'ru' ? 'ru-RU' : 'en-GB';
  function $(id){ return document.getElementById(id); }
  function num(v){ v = String(v || '').replace(/[^\d]/g, ''); return v ? parseInt(v, 10) : 0; }
  function tl(n){ return '₺' + Math.round(n).toLocaleString('en-GB'); }
  function fmt(el){ var n = num(el.value); el.value = n ? n.toLocaleString('de-DE') : ''; }
  function track(n, p){ try { if (typeof gtag === 'function') gtag('event', n, p || {}); } catch (e) {} }
  var used = false;
  function calc(){
    var type = $('pt-type').value, metro = root.querySelector('[name=pt-loc]:checked').value === 'metro';
    var tv = num($('pt-tv').value), rate = D.rates[type] * (metro ? 2 : 1), tax = tv * rate;
    $('pt-annual').textContent = tv ? tl(tax) : '—';
    $('pt-inst').textContent = tv ? P.inst + ' · ' + tl(tax / 2) + ' ' + P.each + ' · ' + (rate * 100).toFixed(1).replace('.0', '') + '%' : '';
    var dk = 0;
    if (type === 'res' && tv > D.dkv[0]) {
      var b = D.dkv, r = D.dkv_rates;
      dk = (Math.min(tv, b[1]) - b[0]) * r[0] + Math.max(0, Math.min(tv, b[2]) - b[1]) * r[1] + Math.max(0, tv - b[2]) * r[2];
      $('pt-dkv').textContent = P.dkv_yes + ' ≈ ' + tl(dk);
    } else $('pt-dkv').textContent = P.dkv_none;
    var price = num($('pt-price').value), coef = parseFloat(String($('pt-coef').value).replace(',', '.')) || 1;
    var deed = price * D.deed, rf = D.tkgm * coef, all = root.querySelector('[name=pt-who]:checked').value === 'buyer';
    $('pt-deed').textContent = price ? tl(deed * 2) : '—';
    $('pt-rf').textContent = tl(rf);
    $('pt-buyer').textContent = price ? tl((all ? deed * 2 : deed) + rf) : '—';
    $('pt-seller').textContent = price ? tl(all ? 0 : deed) : '—';
    $('pt-calc').value = 'Annual tax: type ' + type + (metro ? ' metro' : '') + ', tax value ' + tl(tv) + ' -> ' + tl(tax) + (dk ? ' (+DKV ~' + tl(dk) + ')' : '') + ' | Purchase: price ' + tl(price) + ', ' + (all ? 'buyer pays 4%' : 'split 2+2') + ', buyer ~' + $('pt-buyer').textContent;
    if (!used) { used = true; } else track('proptax_calc', { language: lang });
  }
  root.querySelectorAll('.pt-tabs button').forEach(function(b){ b.addEventListener('click', function(){
    root.querySelectorAll('.pt-tabs button').forEach(function(x){ x.classList.toggle('on', x === b); });
    root.querySelectorAll('[data-panel]').forEach(function(p){ p.hidden = p.dataset.panel !== b.dataset.tab; });
  }); });
  ['pt-tv', 'pt-price'].forEach(function(id){ $(id).addEventListener('input', function(){ fmt(this); calc(); }); });
  root.querySelectorAll('select, input[type=radio], #pt-coef').forEach(function(el){ el.addEventListener('input', calc); el.addEventListener('change', calc); });
  calc();
})();
JS;
}

function write_proptax_pages() {
    foreach (['en', 'ar', 'ru'] as $lang) {
        $dir = SITE_ROOT . '/turkey-property-tax-calculator' . ($lang === 'en' ? '' : '/' . $lang);
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        file_put_contents($dir . '/index.html', build_proptax_page_html($lang));
    }
}
