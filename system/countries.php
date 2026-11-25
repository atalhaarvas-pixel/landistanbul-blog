<?php
/**
 * Country landing pages for international buyers:
 *   /buy-property-in-turkey/                 hub (EN)      /buy-property-in-turkey/ar/   hub (AR)
 *   /buy-property-in-turkey/<country>/       guide (EN)    .../<country>/ar/             guide (AR, Arab countries)
 * Facts checked in November 2026; every country page lists its sources. Update lc_countries() when rules change.
 */

function lc_base() { return SITE_URL . '/buy-property-in-turkey/'; }
function lc_url($slug, $lang) {
    return lc_base() . ($slug ? $slug . '/' : '') . ($lang === 'en' ? '' : $lang . '/');
}
function lc_sfx($lang) { return $lang === 'en' ? '' : $lang . '/'; }

function lc_t($lang) {
    $en = [
        'hub_title' => 'Buying Property in Turkey From Abroad: Country Guides 2026',
        'hub_desc' => 'Visa, property rights, dual citizenship and money transfers for buyers from Pakistan, Saudi Arabia, the UAE, Qatar, Kuwait, Iraq, Germany and the UK.',
        'hub_tag' => 'International buyers',
        'hub_h1' => 'Buying property in Turkey from your country',
        'hub_lead' => 'The rules that matter most depend on your passport: whether you need a visa, whether your country lets you keep a second nationality, and how you can send money. Pick your country for a guide written for you.',
        'hub_other_h' => 'Your country is not listed?',
        'hub_other_p' => 'We work with buyers from many countries. Send us your nationality and plans, and we will check the rules for you.',
        'title' => 'Buying Property in Turkey From %s: 2026 Guide',
        'desc' => 'Visa, property rights, dual citizenship, residence and citizenship options and money transfers for %s buyers of property in Turkey, updated %s.',
        'tag' => 'Guide for buyers from %s',
        'h1' => 'Buying property in Turkey from %s',
        'glance' => 'At a glance for buyers from %s',
        'lead' => 'What a buyer from %s needs to check before buying in Turkey: the visa, your right to buy, dual citizenship, the residence and citizenship routes, and how to send the money. Checked in %s.',
        'rows' => ['visa' => 'Visiting Turkey', 'buy' => 'Can you buy property?', 'dual' => 'Dual citizenship at home', 'routes' => 'Residence and citizenship', 'money' => 'Sending the money'],
        'routes' => 'Residence permit with a home worth $200,000; investor residence from $150,000 in deposits, bonds or funds; citizenship with $400,000 of qualifying property.',
        'fit_h' => 'What usually makes sense for you',
        'steps_h' => 'How buying works when you live abroad',
        'steps' => [
            ['Shortlist and view remotely', 'We send verified options and run live video viewings, so your first trip is to decide, not to search.'],
            ['Tax number and bank account', 'You need a Turkish tax number and a Turkish bank account. Both can be arranged with a power of attorney.'],
            ['Power of attorney', 'Sign it at a Turkish consulate or before a notary in your country (legalised or apostilled as required) if you will not be in Turkey for the deed.'],
            ['Checks before you pay', 'Title type, debts and liens on the deed, building and occupancy permits, earthquake-safety record and the price against the market.'],
            ['Valuation and payment', 'An SPK-licensed valuation report, then payment through the bank. From 1 December 2026 sales go through the bank-held secure payment system.'],
            ['Title deed and handover', 'The deed is issued in your name at the land registry; then earthquake insurance (DASK), utilities and, if you need it, the residence permit file.'],
        ],
        'tools_h' => 'Free tools',
        'tools' => [['Citizenship & residence check', 'See in 60 seconds which route fits your budget.', 'elig'], ['Free property valuation', 'Already own in Turkey? Get a realistic price range.', 'val'], ['Capital gains tax calculator', 'Selling? Check the tax in Turkish lira.', 'tax']],
        'faq_h' => 'Questions buyers from %s ask',
        'sources_h' => 'Sources (checked %s)',
        'disclaimer' => 'General information, not legal or tax advice. Visa, nationality and banking rules change; confirm your case with the authorities of your country and with a lawyer in Turkey before you pay.',
        'form_h' => 'Get a free consultation',
        'form_p' => 'Tell us your budget and plans. We reply in your language, usually the same day.',
        'f_country' => 'Country',
        'interests' => ['Buying an apartment' => 'Buying a home or investment property', 'Turkish citizenship by investment' => 'Turkish citizenship by investment', 'Residence permit by property' => 'Residence permit', 'Selling my property in Turkey' => 'Selling my property in Turkey', 'Buying land' => 'Buying land'],
        'wa_text' => 'Hello Land Istanbul, I am writing from %s about buying property in Turkey.',
        'all' => 'All country guides',
        'crumb' => 'International buyers',
        'read' => 'Read the guide →',
        'updated_label' => 'November 2026',
    ];
    $ar = [
        'hub_title' => 'شراء عقار في تركيا من الخارج: أدلة حسب الدولة 2026',
        'hub_desc' => 'التأشيرة وحق التملك والجنسية المزدوجة وتحويل الأموال للمشترين من السعودية والإمارات وقطر والكويت والعراق.',
        'hub_tag' => 'المشترون الدوليون',
        'hub_h1' => 'شراء عقار في تركيا من بلدك',
        'hub_lead' => 'القواعد الأهم تعتمد على جواز سفرك: هل تحتاج إلى تأشيرة، وهل يسمح بلدك بجنسية ثانية، وكيف تحوّل الأموال. اختر بلدك لتقرأ دليلاً كُتب لك.',
        'hub_other_h' => 'بلدك غير موجود في القائمة؟',
        'hub_other_p' => 'نعمل مع مشترين من دول كثيرة. أرسل لنا جنسيتك وخططك وسنتحقق من القواعد لك.',
        'title' => 'شراء عقار في تركيا من %s: دليل 2026',
        'desc' => 'التأشيرة وحق التملك والجنسية المزدوجة وخيارات الإقامة والجنسية وتحويل الأموال للمشترين من %s، محدَّث %s.',
        'tag' => 'دليل للمشترين من %s',
        'h1' => 'شراء عقار في تركيا من %s',
        'glance' => 'لمحة سريعة للمشترين من %s',
        'lead' => 'ما يحتاج المشتري من %s إلى التحقق منه قبل الشراء في تركيا: التأشيرة، وحقك في التملك، والجنسية المزدوجة، ومسارات الإقامة والجنسية، وطريقة تحويل الأموال. تم التحقق في %s.',
        'rows' => ['visa' => 'زيارة تركيا', 'buy' => 'هل يمكنك شراء عقار؟', 'dual' => 'الجنسية المزدوجة في بلدك', 'routes' => 'الإقامة والجنسية', 'money' => 'تحويل الأموال'],
        'routes' => 'إقامة بمنزل قيمته 200 ألف دولار؛ إقامة المستثمر من 150 ألف دولار في ودائع أو سندات أو صناديق؛ الجنسية بعقار مؤهل بقيمة 400 ألف دولار.',
        'fit_h' => 'ما الذي يناسبك عادةً',
        'steps_h' => 'كيف يتم الشراء وأنت تعيش في الخارج',
        'steps' => [
            ['قائمة مختارة ومعاينة عن بُعد', 'نرسل لك خيارات موثّقة ونجري معاينات مباشرة بالفيديو، فتكون رحلتك الأولى لاتخاذ القرار لا للبحث.'],
            ['الرقم الضريبي والحساب البنكي', 'تحتاج إلى رقم ضريبي تركي وحساب في بنك تركي، ويمكن ترتيبهما بوكالة.'],
            ['الوكالة', 'وقّعها في قنصلية تركية أو لدى كاتب عدل في بلدك (مع التصديق أو الأبوستيل حسب الحاجة) إذا لم تكن في تركيا يوم نقل الطابو.'],
            ['التحقق قبل الدفع', 'نوع الطابو، والديون والرهون عليه، وتراخيص البناء والإسكان، وسجل السلامة الزلزالية، والسعر مقارنة بالسوق.'],
            ['التقييم والدفع', 'تقرير تقييم من شركة مرخّصة من هيئة أسواق المال، ثم الدفع عبر البنك. اعتباراً من 1 ديسمبر 2026 تتم عمليات البيع عبر نظام الدفع الآمن لدى البنوك.'],
            ['الطابو والاستلام', 'يصدر الطابو باسمك في دائرة الطابو، ثم تأمين الزلازل (DASK) والعدادات، وملف الإقامة إذا احتجت إليه.'],
        ],
        'tools_h' => 'أدوات مجانية',
        'tools' => [['اختبار الجنسية والإقامة', 'اعرف خلال 60 ثانية المسار المناسب لميزانيتك.', 'elig'], ['تقييم مجاني للعقار', 'تملك عقاراً في تركيا؟ احصل على نطاق سعر واقعي.', 'val'], ['حاسبة ضريبة الأرباح', 'تبيع؟ احسب الضريبة بالليرة التركية.', 'tax']],
        'faq_h' => 'أسئلة يطرحها المشترون من %s',
        'sources_h' => 'المصادر (تم التحقق في %s)',
        'disclaimer' => 'معلومات عامة وليست استشارة قانونية أو ضريبية. قواعد التأشيرة والجنسية والبنوك تتغير؛ تأكد من حالتك لدى سلطات بلدك ومع محامٍ في تركيا قبل الدفع.',
        'form_h' => 'احصل على استشارة مجانية',
        'form_p' => 'أخبرنا بميزانيتك وخططك، وسنرد عليك بلغتك، غالباً في اليوم نفسه.',
        'f_country' => 'الدولة',
        'interests' => ['Buying an apartment' => 'شراء منزل أو عقار استثماري', 'Turkish citizenship by investment' => 'الجنسية التركية عبر الاستثمار', 'Residence permit by property' => 'الإقامة', 'Selling my property in Turkey' => 'بيع عقاري في تركيا', 'Buying land' => 'شراء أرض'],
        'wa_text' => 'مرحباً لاند إسطنبول، أكتب لكم من %s بخصوص شراء عقار في تركيا.',
        'all' => 'كل أدلة الدول',
        'crumb' => 'المشترون الدوليون',
        'read' => 'اقرأ الدليل ←',
        'updated_label' => 'نوفمبر 2026',
    ];
    return $lang === 'ar' ? $ar : $en;
}

function lc_countries() {
    return [
        'pakistan' => [
            'code' => 'PK', 'langs' => ['en'],
            'en' => [
                'name' => 'Pakistan', 'from' => 'Pakistan', 'buyers' => 'Pakistan',
                'visa' => 'A visa is required. A single-entry e-Visa for up to 30 days is available if you hold a valid US, UK, Ireland or Schengen visa or residence permit; otherwise apply for a sticker visa at a Turkish mission.',
                'buy' => 'Yes. Pakistani citizens can buy homes, commercial units and land, within the limits that apply to all foreigners (no military or security zones, area caps per person and per district).',
                'dual' => 'Pakistan allows dual nationality only with countries on its official list (22 after the 2024 amendment). Türkiye is not on it yet; Pakistan has said it is working on an arrangement. Check with the Directorate General of Immigration & Passports before applying for Turkish citizenship.',
                'money' => 'Residents of Pakistan must follow State Bank of Pakistan foreign-exchange rules for sending money abroad, so speak to your bank first. Overseas Pakistanis usually pay from accounts abroad.',
                'fit' => [
                    'For many Pakistani families the first question is not the property but the passport: until Türkiye is added to Pakistan\'s dual-nationality list, taking Turkish citizenship may mean giving up Pakistani nationality. We check this with you before anything else.',
                    'Because of that, many buyers start with residence: a home worth at least $200,000 gives a residence permit for the family, and since 18 November 2026 a $150,000 investment in Turkish deposits, bonds or funds gives a 3-year investor permit.',
                    'Families who are ready for citizenship use the $400,000 property route, which covers the spouse and children under 18 in one file.',
                ],
                'faq' => [
                    ['Can Pakistani nationals get Turkish citizenship by investment?', 'Yes. The $400,000 property route is open to Pakistani nationals. The open question is on the Pakistani side: Türkiye is not yet on Pakistan\'s dual-nationality list, so confirm with the Directorate General of Immigration & Passports whether you would need to give up Pakistani nationality.'],
                    ['Do I have to travel to Turkey to buy?', 'No. You can view properties by video and sign a power of attorney at a Turkish consulate or before a notary, so that a lawyer completes the tax number, bank account and title deed for you.'],
                    ['Can I get a residence permit if I buy a home?', 'Yes, if the home is worth at least $200,000 at purchase, is residential and you use it as your home. The permit is issued for up to two years at a time and renewed while the conditions are met.'],
                    ['How do I enter Turkey to view properties?', 'With a Turkish visa. If you hold a valid US, UK, Ireland or Schengen visa or residence permit, you can apply online for a conditional e-Visa; otherwise apply at a Turkish mission.'],
                ],
                'sources' => [
                    ['Gulf News: Pakistan expands dual nationality to 22 countries; work begun on Türkiye', 'https://gulfnews.com/world/asia/pakistan/new-citizenship-law-pakistan-expands-dual-nationality-to-22-additional-countries-1.500107051'],
                    ['Express Tribune: New law lets Pakistanis hold dual nationality with 22 countries', 'https://tribune.com.pk/story/2542032/new-law-lets-pakistanis-hold-dual-nationality-with-22-countries'],
                    ['DGIP Pakistan: Dual nationality', 'https://dgip.gov.pk/immigration/dual_nationality.php'],
                    ['My Turkey Adventure: Turkey visa for Pakistani citizens 2026', 'https://myturkeyadventure.com/s/turkey-visa-for-pakistan'],
                ],
            ],
        ],
        'saudi-arabia' => [
            'code' => 'SA', 'langs' => ['en', 'ar'],
            'en' => [
                'name' => 'Saudi Arabia', 'from' => 'Saudi Arabia', 'buyers' => 'Saudi Arabia',
                'visa' => 'No visa needed: Saudi citizens with ordinary passports can stay up to 90 days in any 180-day period. Longer stays need a residence permit.',
                'buy' => 'Yes. Saudi citizens can buy homes, commercial units and land, within the limits that apply to all foreigners.',
                'dual' => 'Saudi nationality law does not generally recognise dual nationality, so most Saudi buyers do not apply for Turkish citizenship. Check with the Saudi authorities before taking another nationality.',
                'money' => 'Transfers go bank to bank. Turkish banks ask for documents showing the source of the funds, so keep them ready.',
                'fit' => [
                    'With 90 visa-free days in every 180, most Saudi families buy for the home itself: a summer base, a city apartment near hospitals, schools and shopping, or a property that earns rent while you are away.',
                    'For longer stays, a home worth at least $200,000 that you live in supports a residence permit for the family; the new investor permit from $150,000 is an option if you prefer to keep part of your money in deposits or funds.',
                    'Because Saudi law does not generally allow a second nationality, we plan Saudi purchases around value, location and rental demand, not around citizenship.',
                ],
                'faq' => [
                    ['Do Saudi citizens need a visa to view property in Turkey?', 'No. Ordinary passport holders can stay up to 90 days in any 180-day period without a visa.'],
                    ['Can I rent out my apartment while I am in Saudi Arabia?', 'Yes. Long-term rentals are allowed; short-term holiday letting needs a licence. Rental income is declared in Turkey.'],
                    ['Can my family stay longer than 90 days?', 'Yes, with a short-term residence permit. Owning a home worth at least $200,000 that you use as your residence is one basis for it.'],
                    ['Can a Saudi citizen apply for Turkish citizenship?', 'The Turkish route is open, but Saudi nationality law does not generally recognise dual nationality. Confirm with the Saudi authorities before applying.'],
                ],
                'sources' => [
                    ['Arab News: Saudi tourists get visa exemption to visit Türkiye', 'https://www.arabnews.pk/node/2431051/business-economy'],
                    ['Wego: Türkiye and Saudi Arabia visa agreement (May 2026)', 'https://blog.wego.com/turkiye-and-saudi-arabia-visa-agreement/'],
                    ['The New Arab: Saudi citizenship rules on dual nationality', 'https://english.alaraby.co.uk/news/saudi-arabia-allow-mothers-pass-citizenship'],
                ],
            ],
            'ar' => [
                'name' => 'السعودية', 'from' => 'السعودية', 'buyers' => 'السعودية',
                'visa' => 'لا حاجة إلى تأشيرة: يمكن لحاملي الجوازات العادية من المواطنين السعوديين البقاء حتى 90 يوماً خلال كل 180 يوماً. الإقامة الأطول تتطلب تصريح إقامة.',
                'buy' => 'نعم. يمكن للمواطنين السعوديين شراء المنازل والوحدات التجارية والأراضي ضمن القيود التي تسري على جميع الأجانب.',
                'dual' => 'قانون الجنسية السعودي لا يعترف عموماً بالجنسية المزدوجة، لذا لا يتقدم معظم المشترين السعوديين للجنسية التركية. تأكد من السلطات السعودية قبل اكتساب جنسية أخرى.',
                'money' => 'التحويل يتم من بنك إلى بنك، وتطلب البنوك التركية مستندات تثبت مصدر الأموال، فاحرص على تجهيزها.',
                'fit' => [
                    'مع 90 يوماً دون تأشيرة في كل 180 يوماً، تشتري معظم العائلات السعودية من أجل المنزل نفسه: مصيف، أو شقة في المدينة قرب المستشفيات والمدارس والأسواق، أو عقار يدرّ دخلاً من الإيجار في غيابك.',
                    'للإقامة الأطول، المنزل الذي لا تقل قيمته عن 200 ألف دولار وتسكنه يدعم إقامة العائلة، وإقامة المستثمر الجديدة من 150 ألف دولار خيار إذا فضّلت إبقاء جزء من أموالك في ودائع أو صناديق.',
                    'ولأن القانون السعودي لا يسمح عموماً بجنسية ثانية، نخطط لمشتريات العملاء السعوديين حول القيمة والموقع والطلب على الإيجار، لا حول الجنسية.',
                ],
                'faq' => [
                    ['هل يحتاج المواطن السعودي إلى تأشيرة لمعاينة العقارات في تركيا؟', 'لا. يمكن لحاملي الجوازات العادية البقاء حتى 90 يوماً خلال كل 180 يوماً دون تأشيرة.'],
                    ['هل يمكنني تأجير شقتي وأنا في السعودية؟', 'نعم. الإيجار طويل الأمد مسموح، أما الإيجار السياحي قصير الأمد فيحتاج إلى ترخيص. ويُصرَّح بدخل الإيجار في تركيا.'],
                    ['هل يمكن لعائلتي البقاء أكثر من 90 يوماً؟', 'نعم، بتصريح إقامة قصيرة الأمد. وامتلاك منزل لا تقل قيمته عن 200 ألف دولار تستخدمه للسكن أحد أسسه.'],
                    ['هل يمكن للمواطن السعودي التقدم للجنسية التركية؟', 'المسار التركي متاح، لكن قانون الجنسية السعودي لا يعترف عموماً بالجنسية المزدوجة. تأكد من السلطات السعودية قبل التقديم.'],
                ],
            ],
        ],
        'uae' => [
            'code' => 'AE', 'langs' => ['en', 'ar'],
            'en' => [
                'name' => 'the UAE', 'from' => 'the UAE', 'buyers' => 'the UAE', 'title_name' => 'the UAE',
                'visa' => 'No visa needed for UAE citizens: up to 90 days in any 180-day period. If you live in the UAE on another passport, the visa rules of your own nationality apply.',
                'buy' => 'Yes. UAE citizens can buy homes, commercial units and land, within the limits that apply to all foreigners.',
                'dual' => 'For Emirati citizens, a second nationality is allowed only in limited cases; confirm with the UAE authorities before applying for another citizenship. UAE residents of other nationalities follow their own country\'s rules.',
                'money' => 'Transfers go bank to bank from the UAE. Turkish banks ask for documents showing the source of the funds.',
                'fit' => [
                    'Many people who live in the UAE compare Dubai with Istanbul: Dubai for tax-free income, Istanbul for a large, year-round local housing market and a different lifestyle a short flight away.',
                    'Emirati families mostly buy for use and rent: visa-free stays cover holidays, and a home worth $200,000 or more supports a residence permit for longer stays.',
                    'Expat residents of the UAE should look at their own passport first. For nationalities whose home country allows dual citizenship, the $400,000 property route to a Turkish passport can be the reason to buy.',
                ],
                'faq' => [
                    ['I live in the UAE but hold another passport. Which rules apply to me?', 'Turkish visa and citizenship rules follow your nationality, not your country of residence. Tell us your passport and we will check the rules that apply.'],
                    ['Do UAE citizens need a visa for Turkey?', 'No. Ordinary passport holders can stay up to 90 days in any 180-day period without a visa.'],
                    ['Can I rent out my Istanbul apartment while I live in Dubai?', 'Yes. Long-term rentals are allowed; short-term holiday letting needs a licence. Rental income is declared in Turkey.'],
                    ['Can I buy for citizenship from the UAE?', 'Yes, if your own nationality allows a second passport. The property must be worth at least $400,000, qualify under the 2026 rules and be kept for three years.'],
                ],
                'sources' => [
                    ['Gulf News: Turkey offers visa-free entry for UAE, Saudi and 4 other countries', 'https://gulfnews.com/world/europe/turkey-offers-visa-free-entry-for-uae-saudi-and-citizens-of-4-other-countries-to-boost-tourism-1.100094817'],
                    ['The National: UAE permits dual citizenship under certain conditions', 'https://thenationalnews.com/business/money/2024/01/31/why-it-pays-to-obtain-dual-citizenship-in-the-uae'],
                ],
            ],
            'ar' => [
                'name' => 'الإمارات', 'from' => 'الإمارات', 'buyers' => 'الإمارات',
                'visa' => 'لا حاجة إلى تأشيرة لمواطني الإمارات: حتى 90 يوماً خلال كل 180 يوماً. إذا كنت تقيم في الإمارات بجواز آخر فتسري عليك قواعد جنسيتك.',
                'buy' => 'نعم. يمكن لمواطني الإمارات شراء المنازل والوحدات التجارية والأراضي ضمن القيود التي تسري على جميع الأجانب.',
                'dual' => 'بالنسبة للمواطنين الإماراتيين، الجنسية الثانية مسموحة في حالات محدودة فقط؛ تأكد من السلطات الإماراتية قبل التقدم لجنسية أخرى. أما المقيمون من جنسيات أخرى فتسري عليهم قواعد بلدانهم.',
                'money' => 'التحويل يتم من بنك إلى بنك من الإمارات، وتطلب البنوك التركية مستندات تثبت مصدر الأموال.',
                'fit' => [
                    'كثير من المقيمين في الإمارات يقارنون دبي بإسطنبول: دبي للدخل المعفى من الضرائب، وإسطنبول لسوق إسكان محلي كبير على مدار العام ونمط حياة مختلف على بُعد رحلة قصيرة.',
                    'تشتري العائلات الإماراتية غالباً للاستخدام والتأجير: الإقامة دون تأشيرة تغطي العطلات، والمنزل الذي تبلغ قيمته 200 ألف دولار أو أكثر يدعم الإقامة للفترات الأطول.',
                    'على المقيمين الأجانب في الإمارات النظر إلى جوازهم أولاً. فإذا كان بلدهم يسمح بالجنسية المزدوجة، قد يكون مسار العقار بقيمة 400 ألف دولار نحو الجواز التركي سبب الشراء.',
                ],
                'faq' => [
                    ['أعيش في الإمارات وأحمل جوازاً آخر. أي القواعد تنطبق عليّ؟', 'قواعد التأشيرة والجنسية التركية تتبع جنسيتك لا بلد إقامتك. أخبرنا بجوازك وسنتحقق من القواعد المنطبقة.'],
                    ['هل يحتاج مواطنو الإمارات إلى تأشيرة لتركيا؟', 'لا. يمكن لحاملي الجوازات العادية البقاء حتى 90 يوماً خلال كل 180 يوماً دون تأشيرة.'],
                    ['هل يمكنني تأجير شقتي في إسطنبول وأنا أعيش في دبي؟', 'نعم. الإيجار طويل الأمد مسموح، والإيجار السياحي قصير الأمد يحتاج إلى ترخيص. ويُصرَّح بدخل الإيجار في تركيا.'],
                    ['هل يمكنني الشراء للجنسية من الإمارات؟', 'نعم، إذا كانت جنسيتك تسمح بجواز ثانٍ. يجب ألا تقل قيمة العقار عن 400 ألف دولار وأن يكون مؤهلاً وفق قواعد 2026 وأن يُحتفظ به ثلاث سنوات.'],
                ],
            ],
        ],
        'qatar' => [
            'code' => 'QA', 'langs' => ['en', 'ar'],
            'en' => [
                'name' => 'Qatar', 'from' => 'Qatar', 'buyers' => 'Qatar',
                'visa' => 'No visa needed: Qatari citizens have had visa-free entry to Turkey since 2016.',
                'buy' => 'Yes. Qatari citizens can buy homes, commercial units and land, within the limits that apply to all foreigners.',
                'dual' => 'Qatar does not allow dual nationality; acquiring another citizenship can lead to loss of Qatari nationality. Qatari buyers therefore buy for use, rent and long-term value.',
                'money' => 'Transfers go bank to bank. Turkish banks ask for documents showing the source of the funds.',
                'fit' => [
                    'Qatari families mostly buy a second home they will actually use: an Istanbul apartment with a view and good services, or a quieter home for the summer months.',
                    'Visa-free visits cover most holiday stays; a home worth $200,000 or more that you live in supports a residence permit if you want to stay longer.',
                    'Because citizenship is not on the table for Qatari nationals, we focus on what protects value: legal title, earthquake-safe buildings, location and resale demand.',
                ],
                'faq' => [
                    ['Do Qatari citizens need a visa for Turkey?', 'No. Qatari citizens have been visa-exempt since 2016.'],
                    ['Can I buy for Turkish citizenship as a Qatari?', 'Qatar does not allow dual nationality, so taking Turkish citizenship could cost you Qatari nationality. Qatari buyers use property for living, renting and investment instead.'],
                    ['Can my family stay longer than a holiday?', 'Yes, with a short-term residence permit. A residential property worth at least $200,000 that you use as your home is one basis for it.'],
                ],
                'sources' => [
                    ['Shafaq News: Turkey visa waivers; Qatar (2016) and Kuwait (2017) already exempt', 'https://shafaq.com/en/World/Ignoring-Iraq-Turkey-issues-visa-waivers-to-six-states-including-US-KSA'],
                    ['Seven Seas Worldwide: Countries that ban dual citizenship', 'https://www.sevenseasworldwide.com/need-help/what-is-dual-citizenship/'],
                ],
            ],
            'ar' => [
                'name' => 'قطر', 'from' => 'قطر', 'buyers' => 'قطر',
                'visa' => 'لا حاجة إلى تأشيرة: يدخل المواطنون القطريون تركيا دون تأشيرة منذ 2016.',
                'buy' => 'نعم. يمكن للمواطنين القطريين شراء المنازل والوحدات التجارية والأراضي ضمن القيود التي تسري على جميع الأجانب.',
                'dual' => 'لا تسمح قطر بالجنسية المزدوجة، وقد يؤدي اكتساب جنسية أخرى إلى فقدان الجنسية القطرية. لذلك يشتري القطريون للاستخدام والتأجير والقيمة طويلة الأمد.',
                'money' => 'التحويل يتم من بنك إلى بنك، وتطلب البنوك التركية مستندات تثبت مصدر الأموال.',
                'fit' => [
                    'تشتري العائلات القطرية غالباً منزلاً ثانياً تستخدمه فعلاً: شقة في إسطنبول بإطلالة وخدمات جيدة، أو منزلاً هادئاً لأشهر الصيف.',
                    'الزيارات دون تأشيرة تغطي معظم العطلات، والمنزل الذي تبلغ قيمته 200 ألف دولار أو أكثر وتسكنه يدعم الإقامة إذا أردت البقاء أطول.',
                    'ولأن الجنسية ليست خياراً للمواطنين القطريين، نركز على ما يحمي القيمة: سند ملكية سليم، ومبانٍ آمنة زلزالياً، والموقع، والطلب عند إعادة البيع.',
                ],
                'faq' => [
                    ['هل يحتاج المواطن القطري إلى تأشيرة لتركيا؟', 'لا. المواطنون القطريون معفون من التأشيرة منذ 2016.'],
                    ['هل يمكنني الشراء للجنسية التركية بصفتي قطرياً؟', 'قطر لا تسمح بالجنسية المزدوجة، لذا قد يكلفك اكتساب الجنسية التركية جنسيتك القطرية. يستخدم المشترون القطريون العقار للسكن والتأجير والاستثمار.'],
                    ['هل يمكن لعائلتي البقاء أطول من عطلة؟', 'نعم، بتصريح إقامة قصيرة الأمد. والعقار السكني الذي لا تقل قيمته عن 200 ألف دولار وتستخدمه للسكن أحد أسسه.'],
                ],
            ],
        ],
        'kuwait' => [
            'code' => 'KW', 'langs' => ['en', 'ar'],
            'en' => [
                'name' => 'Kuwait', 'from' => 'Kuwait', 'buyers' => 'Kuwait',
                'visa' => 'No visa needed: Kuwaiti citizens have had visa-free entry to Turkey since 2017.',
                'buy' => 'Yes. Kuwaiti citizens can buy homes, commercial units and land, within the limits that apply to all foreigners.',
                'dual' => 'Kuwait bans dual nationality, and a decree-law of April 2026 made the rules stricter. Kuwaiti buyers should not plan on Turkish citizenship.',
                'money' => 'Transfers go bank to bank. Turkish banks ask for documents showing the source of the funds.',
                'fit' => [
                    'Kuwaiti families typically buy a home for holidays and family visits, or an apartment in Istanbul that is rented out for the rest of the year.',
                    'For longer stays, a residential property worth $200,000 or more that you live in supports a short-term residence permit, renewable while you keep it.',
                    'With citizenship ruled out by Kuwaiti law, the purchase has to make sense on its own: we check the title, the building and the rent the area really achieves.',
                ],
                'faq' => [
                    ['Do Kuwaiti citizens need a visa for Turkey?', 'No. Kuwaiti citizens have been visa-exempt since 2017.'],
                    ['Can a Kuwaiti citizen take Turkish citizenship?', 'Kuwait bans dual nationality and tightened its rules in 2026, so Kuwaiti buyers should not plan on a Turkish passport.'],
                    ['Can I rent the apartment out while I am in Kuwait?', 'Yes. Long-term rentals are allowed; short-term holiday letting needs a licence. Rental income is declared in Turkey. Ask us how owners abroad usually organise tenants and payments.'],
                ],
                'sources' => [
                    ['Shafaq News: Qatar (2016) and Kuwait (2017) visa exemptions', 'https://shafaq.com/en/World/Ignoring-Iraq-Turkey-issues-visa-waivers-to-six-states-including-US-KSA'],
                    ['Wego: Kuwait\'s dual citizenship rule and the 2026 law change', 'https://blog.wego.com/kuwaits-dual-citizenship-rule-explained/'],
                    ['KPMG: Kuwait Decree-Law No. 52 of 2026 amending the citizenship law', 'https://kpmg.com/xx/en/our-insights/gms-flash-alert/2026/flash-alert-2026-111.html'],
                ],
            ],
            'ar' => [
                'name' => 'الكويت', 'from' => 'الكويت', 'buyers' => 'الكويت',
                'visa' => 'لا حاجة إلى تأشيرة: يدخل المواطنون الكويتيون تركيا دون تأشيرة منذ 2017.',
                'buy' => 'نعم. يمكن للمواطنين الكويتيين شراء المنازل والوحدات التجارية والأراضي ضمن القيود التي تسري على جميع الأجانب.',
                'dual' => 'الكويت تحظر الجنسية المزدوجة، وقد شدّد مرسوم بقانون صدر في أبريل 2026 القواعد. لا ينبغي للمشترين الكويتيين التخطيط للجنسية التركية.',
                'money' => 'التحويل يتم من بنك إلى بنك، وتطلب البنوك التركية مستندات تثبت مصدر الأموال.',
                'fit' => [
                    'تشتري العائلات الكويتية عادةً منزلاً للعطلات والزيارات العائلية، أو شقة في إسطنبول تُؤجَّر بقية العام.',
                    'للإقامة الأطول، العقار السكني الذي تبلغ قيمته 200 ألف دولار أو أكثر وتسكنه يدعم إقامة قصيرة الأمد قابلة للتجديد ما دمت تملكه.',
                    'ومع استبعاد الجنسية بموجب القانون الكويتي، يجب أن يكون الشراء مجدياً بحد ذاته: نتحقق من الطابو والمبنى والإيجار الذي تحققه المنطقة فعلاً.',
                ],
                'faq' => [
                    ['هل يحتاج المواطن الكويتي إلى تأشيرة لتركيا؟', 'لا. المواطنون الكويتيون معفون من التأشيرة منذ 2017.'],
                    ['هل يمكن للمواطن الكويتي اكتساب الجنسية التركية؟', 'الكويت تحظر الجنسية المزدوجة وشدّدت قواعدها في 2026، لذا لا ينبغي للمشترين الكويتيين التخطيط لجواز تركي.'],
                    ['هل يمكنني تأجير الشقة وأنا في الكويت؟', 'نعم. الإيجار طويل الأمد مسموح، والإيجار السياحي قصير الأمد يحتاج إلى ترخيص، ويُصرَّح بدخل الإيجار في تركيا. اسألنا كيف ينظّم الملّاك في الخارج عادةً المستأجرين والمدفوعات.'],
                ],
            ],
        ],
        'iraq' => [
            'code' => 'IQ', 'langs' => ['en', 'ar'],
            'en' => [
                'name' => 'Iraq', 'from' => 'Iraq', 'buyers' => 'Iraq',
                'visa' => 'A visa is required: Iraq was not included in the visa waivers Turkey granted to Gulf countries. Apply before you travel.',
                'buy' => 'Yes. Iraqi citizens can buy homes, commercial units and land, within the limits that apply to all foreigners.',
                'dual' => 'Iraq recognises dual nationality (Constitution, Article 18), although holders of senior state posts may not keep a second nationality. Turkish citizenship by investment is therefore a realistic option for most Iraqi families.',
                'money' => 'Payments for citizenship must arrive through a bank as foreign currency with a foreign-exchange certificate (DAB). Cash is not accepted, so plan the transfer route with your bank early.',
                'fit' => [
                    'Iraqis are the largest group of Arab visitors to Turkey, and for many families a home in Istanbul is about education, healthcare and stability as much as investment.',
                    'Because Iraq allows dual nationality, the $400,000 property route can give the whole family Turkish passports while you keep Iraqi citizenship. The property must qualify under the 2026 rules and be kept for three years.',
                    'With a smaller budget, a home worth $200,000 supports a residence permit, and the new $150,000 investor permit is another way to live in Turkey legally.',
                ],
                'faq' => [
                    ['Can Iraqis keep Iraqi citizenship after becoming Turkish citizens?', 'Iraq recognises dual nationality, so most Iraqis can hold both. People in senior state posts are an exception under the constitution.'],
                    ['Do Iraqis need a visa to view property?', 'Yes. Iraq is not on Turkey\'s visa-exemption list, so apply for a visa before you travel. After you buy, a residence permit makes repeat visits easier.'],
                    ['Can I pay in cash?', 'No. Payments must go through a bank; for citizenship the currency is converted at a Turkish bank and documented with a DAB certificate.'],
                    ['Which areas do Iraqi families choose in Istanbul?', 'It depends on schools, budget and whether you want to live there or rent it out. Tell us your plans and we will shortlist areas with the reasons.'],
                ],
                'sources' => [
                    ['Shafaq News: Iraqis remain subject to visa procedures; top Arab visitors to Turkey', 'https://shafaq.com/en/World/Ignoring-Iraq-Turkey-issues-visa-waivers-to-six-states-including-US-KSA'],
                    ['Constitution of the Republic of Iraq 2005, Article 18 (UN Women)', 'https://constitutions.unwomen.org/en/countries/asia/iraq'],
                    ['Naharnet / AFP: Article 18 allows dual citizenship except for senior posts', 'https://naharnet.com/stories/90790-iraq-seeks-to-bar-top-officials-from-dual-citizenship/print'],
                ],
            ],
            'ar' => [
                'name' => 'العراق', 'from' => 'العراق', 'buyers' => 'العراق',
                'visa' => 'التأشيرة مطلوبة: لم يُدرج العراق ضمن الإعفاءات التي منحتها تركيا لدول الخليج، فقدّم طلبك قبل السفر.',
                'buy' => 'نعم. يمكن للمواطنين العراقيين شراء المنازل والوحدات التجارية والأراضي ضمن القيود التي تسري على جميع الأجانب.',
                'dual' => 'يعترف العراق بالجنسية المزدوجة (الدستور، المادة 18)، باستثناء من يشغلون مناصب سيادية عليا. لذا فالجنسية التركية عبر الاستثمار خيار واقعي لمعظم العائلات العراقية.',
                'money' => 'يجب أن تصل مدفوعات الجنسية عبر بنك بالعملة الأجنبية مع شهادة صرف العملة (DAB). لا يُقبل الدفع نقداً، فخطّط لمسار التحويل مع بنكك مبكراً.',
                'fit' => [
                    'العراقيون أكبر مجموعة من الزوار العرب إلى تركيا، وبالنسبة لكثير من العائلات فإن المنزل في إسطنبول يتعلق بالتعليم والرعاية الصحية والاستقرار بقدر ما يتعلق بالاستثمار.',
                    'ولأن العراق يسمح بالجنسية المزدوجة، يمكن لمسار العقار بقيمة 400 ألف دولار أن يمنح العائلة كلها الجواز التركي مع الاحتفاظ بالجنسية العراقية. يجب أن يكون العقار مؤهلاً وفق قواعد 2026 وأن يُحتفظ به ثلاث سنوات.',
                    'وبميزانية أصغر، المنزل الذي تبلغ قيمته 200 ألف دولار يدعم الإقامة، وإقامة المستثمر الجديدة من 150 ألف دولار طريق آخر للعيش في تركيا بشكل قانوني.',
                ],
                'faq' => [
                    ['هل يحتفظ العراقي بجنسيته بعد الحصول على الجنسية التركية؟', 'يعترف العراق بالجنسية المزدوجة، لذا يمكن لمعظم العراقيين حمل الجنسيتين. يُستثنى من يشغلون مناصب سيادية عليا وفق الدستور.'],
                    ['هل يحتاج العراقيون إلى تأشيرة لمعاينة العقارات؟', 'نعم. العراق ليس ضمن قائمة الإعفاء التركية، فقدّم طلب التأشيرة قبل السفر. وبعد الشراء تسهّل الإقامة الزيارات المتكررة.'],
                    ['هل يمكنني الدفع نقداً؟', 'لا. يجب أن تمر المدفوعات عبر بنك؛ وفي حالة الجنسية تُحوَّل العملة في بنك تركي وتُوثَّق بشهادة DAB.'],
                    ['ما المناطق التي تختارها العائلات العراقية في إسطنبول؟', 'يعتمد ذلك على المدارس والميزانية وهل تريد السكن أم التأجير. أخبرنا بخططك وسنرشح لك مناطق مع الأسباب.'],
                ],
            ],
        ],
        'germany' => [
            'code' => 'DE', 'langs' => ['en'],
            'en' => [
                'name' => 'Germany', 'from' => 'Germany', 'buyers' => 'Germany',
                'visa' => 'German citizens can visit Turkey without a visa for short stays. Longer stays need a residence permit.',
                'buy' => 'Yes. German citizens can buy homes, commercial units and land, within the limits that apply to all foreigners.',
                'dual' => 'Since 27 June 2024 Germans can acquire another nationality without losing German citizenship, so Turkish citizenship by investment no longer forces a choice.',
                'money' => 'SEPA and international transfers go bank to bank. Turkish banks ask for documents showing the source of the funds.',
                'fit' => [
                    'Most German buyers look for a home they will use for part of the year, on the coast or in Istanbul, or for a rental apartment in a city with strong year-round demand.',
                    'Germany\'s 2024 nationality reform changed the picture: a German can now take Turkish citizenship through the $400,000 property route and keep the German passport.',
                    'If you plan to live in Turkey for longer periods, a home worth $200,000 or more that you use supports a residence permit. Check where you will be tax resident before you move, with a tax adviser in both countries.',
                ],
                'faq' => [
                    ['Can Germans keep German citizenship if they become Turkish citizens?', 'Yes, for acquisitions on or after 27 June 2024, when Germany\'s new nationality law took effect.'],
                    ['Do I need to be in Turkey to complete the purchase?', 'No. A notarised power of attorney lets a lawyer complete the tax number, bank account and title deed for you.'],
                    ['Can I rent the apartment out when I am in Germany?', 'Yes. Long-term rentals are allowed; short-term holiday letting needs a licence. Rental income is declared in Turkey, and your German tax adviser will tell you how it is treated in Germany.'],
                ],
                'sources' => [
                    ['German Federal Foreign Office: Germany\'s nationality law, significant changes (27 June 2024)', 'https://www.auswaertiges-amt.de/en/-/2664574'],
                    ['Federal Ministry of the Interior: New law on nationality takes effect', 'https://bmi.bund.de/SharedDocs/kurzmeldungen/EN/2024/06/mod-staatsangehoerigkeitsrecht.html'],
                ],
            ],
        ],
        'united-kingdom' => [
            'code' => 'GB', 'langs' => ['en'],
            'en' => [
                'name' => 'the UK', 'from' => 'the UK', 'buyers' => 'the UK', 'title_name' => 'the UK',
                'visa' => 'British citizens can visit Turkey without a visa for up to 90 days in any 180-day period. Longer stays need a residence permit.',
                'buy' => 'Yes. British citizens can buy homes, commercial units and land, within the limits that apply to all foreigners.',
                'dual' => 'The UK allows dual nationality, so British buyers can take Turkish citizenship through investment and keep their British passport.',
                'money' => 'Transfers go bank to bank. Turkish banks ask for documents showing the source of the funds; for citizenship the currency must be converted at a Turkish bank with a DAB certificate.',
                'fit' => [
                    'British buyers have a long history in Turkey, mostly on the coast. In Istanbul the focus is different: apartments with strong rental demand, or a city base for part of the year.',
                    'With 90 visa-free days in every 180, a holiday home needs no permit; if you want to spend longer, a home worth $200,000 or more that you live in supports a residence permit.',
                    'Because the UK allows dual nationality, the $400,000 property route to Turkish citizenship is open to British families who want a second passport.',
                ],
                'faq' => [
                    ['How long can I stay in Turkey without a residence permit?', 'Up to 90 days in any 180-day period. Beyond that you need a short-term residence permit before your 90 days end.'],
                    ['Can I keep my British passport if I become a Turkish citizen?', 'Yes. The UK allows dual nationality.'],
                    ['Do I need a Turkish bank account to buy?', 'Yes. You need a Turkish tax number and bank account; both can be arranged with a power of attorney.'],
                ],
                'sources' => [
                    ['GOV.UK: Turkey travel advice, entry requirements', 'https://gov.uk/foreign-travel-advice/turkey/entry-requirements'],
                    ['GOV.UK: Living in Turkey', 'https://gov.uk/living-in-turkey'],
                ],
            ],
        ],
    ];
}

function lc_field($c, $lang, $key) {
    return $c[$lang][$key] ?? $c['en'][$key] ?? '';
}

function lc_form_html($lang, $countryName, $url) {
    $t = lc_t($lang);
    $g = li_t($lang);
    $h = function ($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); };
    $o = '<form class="li-lead-form lc-form" method="post" action="/mail.php" novalidate data-ok="' . $h($g['f_ok']) . '" data-err="' . $h($g['f_err']) . '" data-need="' . $h($g['f_need']) . '" data-sending="' . $h($g['f_sending']) . '">';
    $o .= '<input type="hidden" name="source" value="' . $h($url) . '"><input type="hidden" name="lang" value="' . $lang . '">';
    $o .= '<div class="li-hp" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>';
    $o .= '<div class="lv-f"><input type="text" name="name" autocomplete="name" placeholder="' . $h($g['f_name']) . '" aria-label="' . $h($g['f_name']) . '"></div>';
    $o .= '<div class="lv-two"><div class="lv-f"><input type="tel" name="phone" dir="ltr" autocomplete="tel" placeholder="' . $h($g['f_phone']) . '" aria-label="' . $h($g['f_phone']) . '"></div>';
    $o .= '<div class="lv-f"><input type="email" name="email" dir="ltr" autocomplete="email" placeholder="' . $h($g['f_email']) . '" aria-label="' . $h($g['f_email']) . '"></div></div>';
    if ($countryName === null) {
        $o .= '<div class="lv-f"><input type="text" name="p_country" placeholder="' . $h($t['f_country']) . '" aria-label="' . $h($t['f_country']) . '"></div>';
    } else {
        $o .= '<input type="hidden" name="p_country" value="' . $h($countryName) . '">';
    }
    $o .= '<div class="lv-two"><div class="lv-f"><select name="interest" aria-label="' . $h($g['f_interest']) . '">';
    foreach ($t['interests'] as $v => $label) $o .= '<option value="' . $h($v) . '">' . $h($label) . '</option>';
    $o .= '</select></div><div class="lv-f"><select name="budget" aria-label="' . $h($g['f_budget']) . '"><option value="">' . $h($g['f_budget']) . '</option>';
    foreach ($g['budgets'] as $b) $o .= '<option>' . $h($b) . '</option>';
    $o .= '</select></div></div>';
    $o .= '<div class="lv-f"><textarea name="message" rows="3" placeholder="' . $h($g['f_message']) . '" aria-label="' . $h($g['f_message']) . '"></textarea></div>';
    $o .= '<button type="submit" class="li-submit">' . $h($g['f_submit']) . '</button><p class="li-status" role="status" aria-live="polite"></p><p class="li-privacy">' . $h($g['f_privacy']) . '</p></form>';
    return $o;
}

function lc_badge($code) {
    return '<span class="lc-code">' . htmlspecialchars($code) . '</span>';
}

function build_country_page_html($slug, $lang) {
    $all = lc_countries();
    $c = $all[$slug];
    $t = lc_t($lang);
    $h = function ($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); };
    $name = lc_field($c, $lang, 'name');
    $from = lc_field($c, $lang, 'from');
    $url = lc_url($slug, $lang);
    $alternates = [];
    foreach ($c['langs'] as $l) $alternates[$l] = lc_url($slug, $l);
    $title = sprintf($t['title'], $lang === 'en' ? ucfirst($from) : $from);
    $desc = sprintf($t['desc'], $from, $t['updated_label']);
    $faq = lc_field($c, $lang, 'faq');
    $sources = $c['en']['sources'] ?? [];
    $wa = 'https://wa.me/' . WHATSAPP_NUMBER . '?text=' . rawurlencode(sprintf($t['wa_text'], $from));

    $faqSchema = [];
    foreach ($faq as $f) $faqSchema[] = ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]];
    $schema = ['@context' => 'https://schema.org', '@graph' => [
        ['@type' => 'Service', 'name' => $title, 'serviceType' => 'Real estate consultancy for international buyers', 'url' => $url, 'inLanguage' => $lang,
         'areaServed' => ['@type' => 'Country', 'name' => $c['en']['name'] === 'the UAE' ? 'United Arab Emirates' : ($c['en']['name'] === 'the UK' ? 'United Kingdom' : $c['en']['name'])],
         'provider' => ['@type' => 'RealEstateAgent', 'name' => 'Land Istanbul', 'url' => SITE_URL . '/', 'telephone' => '+905468916349', 'email' => 'info@landistanbul.com', 'parentOrganization' => ['@type' => 'Organization', 'name' => 'Math Investment', 'alternateName' => 'Mat Yatırım', 'taxID' => '0850564655'], 'address' => ['@type' => 'PostalAddress', 'streetAddress' => 'Kavaklı, Olimpiyat Cd. No:58', 'addressLocality' => 'Beylikdüzü', 'addressRegion' => 'İstanbul', 'postalCode' => '34520', 'addressCountry' => 'TR']]],
        ['@type' => 'FAQPage', 'mainEntity' => $faqSchema],
        ['@type' => 'BreadcrumbList', 'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Land Istanbul', 'item' => SITE_URL . '/'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => $t['crumb'], 'item' => lc_url('', $lang === 'ar' ? 'ar' : 'en')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $name, 'item' => $url]]],
    ]];

    $o = page_head($title . ' | Land Istanbul', $desc, $url, SITE_URL . '/og-image.png', ['lang' => $lang, 'alternates' => count($alternates) > 1 ? $alternates : [], 'type' => 'website']);
    $o .= '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) . '</script>';
    $o .= '<main class="lv lc"><section class="lv-hero"><div class="lv-wrap lv-hero-grid"><div class="lv-intro">';
    if (count($alternates) > 1) {
        $o .= '<div class="li-lang-switch">';
        foreach ($alternates as $l => $u) {
            $nm = li_t($l)['lang_name'];
            $o .= $l === $lang ? '<span class="is-current">' . $h($nm) . '</span>' : '<a href="' . $h(str_replace(SITE_URL, '', $u)) . '" hreflang="' . $l . '">' . $h($nm) . '</a>';
        }
        $o .= '</div>';
    }
    $o .= '<a class="lc-back" href="' . $h(str_replace(SITE_URL, '', lc_url('', $lang === 'ar' ? 'ar' : 'en'))) . '">← ' . $h($t['all']) . '</a>';
    $o .= '<span class="lv-tag">' . lc_badge($c['code']) . ' ' . $h(sprintf($t['tag'], $from)) . '</span>';
    $o .= '<h1>' . $h(sprintf($t['h1'], $from)) . '</h1>';
    $o .= '<p class="lv-lead">' . $h(sprintf($t['lead'], $from, $t['updated_label'])) . '</p>';
    $o .= '<div class="lc-glance"><h2>' . $h(sprintf($t['glance'], $from)) . '</h2><dl>';
    foreach (['visa', 'buy', 'dual', 'routes', 'money'] as $k) {
        $val = $k === 'routes' ? $t['routes'] : lc_field($c, $lang, $k);
        $o .= '<div class="lc-row lc-' . $k . '"><dt>' . $h($t['rows'][$k]) . '</dt><dd>' . $h($val) . '</dd></div>';
    }
    $o .= '</dl></div></div>';
    $o .= '<div class="lv-card" id="get-offer"><h2>' . $h($t['form_h']) . '</h2><p class="lc-form-p">' . $h($t['form_p']) . '</p>' . lc_form_html($lang, $c['en']['name'], $url);
    $o .= '<a class="lv-wa" href="' . $h($wa) . '" target="_blank" rel="noopener" data-track="whatsapp">WhatsApp</a></div>';
    $o .= '</div></section>';

    $o .= '<section class="lv-band"><div class="lv-wrap"><h2>' . $h($t['fit_h']) . '</h2><div class="lc-fit">';
    foreach (lc_field($c, $lang, 'fit') as $i => $p) $o .= '<p' . ($i === 0 ? ' class="lc-first"' : '') . '>' . $h($p) . '</p>';
    $o .= '</div></div></section>';

    $o .= '<section class="lv-band lv-dark"><div class="lv-wrap"><h2>' . $h($t['steps_h']) . '</h2><ol class="lv-how">';
    foreach ($t['steps'] as $s) $o .= '<li><h3>' . $h($s[0]) . '</h3><p>' . $h($s[1]) . '</p></li>';
    $o .= '</ol></div></section>';

    $links = ['elig' => '/turkish-citizenship-eligibility/' . lc_sfx($lang), 'val' => '/free-property-valuation/' . lc_sfx($lang), 'tax' => '/tax-calculator/' . lc_sfx($lang)];
    $o .= '<section class="lv-band lv-alt"><div class="lv-wrap"><h2>' . $h($t['tools_h']) . '</h2><div class="lc-tools">';
    foreach ($t['tools'] as $tool) $o .= '<a class="lc-tool" href="' . $links[$tool[2]] . '"><b>' . $h($tool[0]) . '</b><span>' . $h($tool[1]) . '</span></a>';
    $o .= '</div></div></section>';

    $o .= '<section class="lv-band"><div class="lv-wrap"><h2>' . $h(sprintf($t['faq_h'], $from)) . '</h2><div class="li-faq">';
    foreach ($faq as $f) $o .= '<details><summary>' . $h($f[0]) . '</summary><p>' . $h($f[1]) . '</p></details>';
    $o .= '</div>';
    if ($sources) {
        $o .= '<div class="lc-sources"><h3>' . $h(sprintf($t['sources_h'], $t['updated_label'])) . '</h3><ul>';
        foreach ($sources as $s) $o .= '<li><a href="' . $h($s[1]) . '" target="_blank" rel="noopener nofollow">' . $h($s[0]) . '</a></li>';
        $o .= '</ul></div>';
    }
    $o .= '<p class="lc-disc">' . $h($t['disclaimer']) . '</p></div></section>';
    $o .= '<section class="lv-cta"><h2>' . $h($t['form_h']) . '</h2><p>' . $h($t['form_p']) . '</p><a class="lv-cta-btn" href="#get-offer">' . $h(li_t($lang)['f_submit']) . '</a></section>';
    $o .= '</main>' . page_footer();
    return $o;
}

function build_country_hub_html($lang) {
    $t = lc_t($lang);
    $h = function ($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); };
    $url = lc_url('', $lang);
    $countries = lc_countries();
    $list = [];
    foreach ($countries as $slug => $c) {
        if ($lang === 'ar' && !in_array('ar', $c['langs'], true)) continue;
        $list[$slug] = $c;
    }
    $items = [];
    $i = 1;
    foreach ($list as $slug => $c) $items[] = ['@type' => 'ListItem', 'position' => $i++, 'url' => lc_url($slug, $lang), 'name' => sprintf($t['h1'], lc_field($c, $lang, 'from'))];
    $schema = ['@context' => 'https://schema.org', '@graph' => [
        ['@type' => 'CollectionPage', 'name' => $t['hub_title'], 'url' => $url, 'inLanguage' => $lang, 'description' => $t['hub_desc']],
        ['@type' => 'ItemList', 'itemListElement' => $items],
    ]];
    $o = page_head($t['hub_title'] . ' | Land Istanbul', $t['hub_desc'], $url, SITE_URL . '/og-image.png', ['lang' => $lang, 'alternates' => ['en' => lc_url('', 'en'), 'ar' => lc_url('', 'ar')], 'type' => 'website']);
    $o .= '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) . '</script>';
    $o .= '<main class="lv lc"><section class="lv-hero lc-hub-hero"><div class="lv-wrap"><div class="li-lang-switch">';
    foreach (['en', 'ar'] as $l) {
        $nm = li_t($l)['lang_name'];
        $o .= $l === $lang ? '<span class="is-current">' . $h($nm) . '</span>' : '<a href="' . $h(str_replace(SITE_URL, '', lc_url('', $l))) . '" hreflang="' . $l . '">' . $h($nm) . '</a>';
    }
    $o .= '</div><span class="lv-tag">' . $h($t['hub_tag']) . '</span><h1>' . $h($t['hub_h1']) . '</h1><p class="lv-lead">' . $h($t['hub_lead']) . '</p>';
    $o .= '<div class="lc-grid">';
    foreach ($list as $slug => $c) {
        $o .= '<a class="lc-card" href="' . $h(str_replace(SITE_URL, '', lc_url($slug, $lang))) . '">' . lc_badge($c['code']) . '<b>' . $h($c[$lang]['title_name'] ?? $c[$lang]['name'] ?? $c['en']['name']) . '</b>';
        $o .= '<p>' . $h(lc_field($c, $lang, 'dual')) . '</p><em>' . $h($t['read']) . '</em></a>';
    }
    $o .= '</div></div></section>';
    $o .= '<section class="lv-band lv-alt"><div class="lv-wrap lc-other"><div><h2>' . $h($t['hub_other_h']) . '</h2><p class="lv-p">' . $h($t['hub_other_p']) . '</p></div>';
    $o .= '<div class="lv-card" id="get-offer">' . lc_form_html($lang, null, $url) . '</div></div></section>';
    $o .= '</main>' . page_footer();
    return $o;
}

function lc_all_urls() {
    $urls = [lc_url('', 'en'), lc_url('', 'ar')];
    foreach (lc_countries() as $slug => $c) foreach ($c['langs'] as $l) $urls[] = lc_url($slug, $l);
    return $urls;
}

function write_country_pages() {
    $base = SITE_ROOT . '/buy-property-in-turkey';
    foreach (['en', 'ar'] as $lang) {
        $dir = $base . ($lang === 'en' ? '' : '/ar');
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        file_put_contents($dir . '/index.html', build_country_hub_html($lang));
    }
    foreach (lc_countries() as $slug => $c) {
        foreach ($c['langs'] as $lang) {
            $dir = $base . '/' . $slug . ($lang === 'en' ? '' : '/' . $lang);
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            file_put_contents($dir . '/index.html', build_country_page_html($slug, $lang));
        }
    }
}
