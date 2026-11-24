<?php
/**
 * Turkish citizenship / residence eligibility check: /turkish-citizenship-eligibility/ (+ /ar/, /ru/).
 * Rules as of November 2026: citizenship by property USD 400,000 (3-year hold, qualifying title, Turkish seller);
 * residence permit by property USD 200,000 for purchases since 16 Oct 2023 (residential, own use);
 * investor residence decision of Nov 2026: USD 150,000 (3 yrs) / 200,000 (5 yrs) in deposits, bonds, funds.
 */

function le_url($lang) {
    return SITE_URL . '/turkish-citizenship-eligibility/' . ($lang === 'en' ? '' : $lang . '/');
}

function le_t($lang) {
    $en = [
        'seo_title' => 'Turkish Citizenship Eligibility Check 2026: Do You Qualify?',
        'description' => 'Answer 4 questions and see in 60 seconds whether you qualify for Turkish citizenship or a residence permit through property under the 2026 rules.',
        'tag' => 'Free check · 60 seconds',
        'h1' => 'Do you qualify for Turkish citizenship?',
        'lead' => 'Answer four quick questions. You will see which route fits your budget (citizenship, residence permit or investment only) and what to check before you buy. Based on the rules in force in November 2026.',
        'q' => [
            ['budget', 'What is your budget?', [['lt150', 'Under $150,000'], ['150', '$150,000 – $199,999'], ['200', '$200,000 – $399,999'], ['400', '$400,000 – $499,999'], ['500', '$500,000 or more']]],
            ['buy', 'What do you plan to buy?', [['ready', 'A ready apartment or villa'], ['offplan', 'An off-plan (under construction) unit'], ['land', 'Land'], ['commercial', 'A shop or office'], ['unsure', 'Not sure yet']]],
            ['family', 'Who should be included?', [['me', 'Just me'], ['spouse', 'Me and my spouse'], ['kids', 'Me, my spouse and children under 18'], ['adult', 'Also adult children']]],
            ['when', 'When do you want to apply?', [['3', 'Within 3 months'], ['6', 'In 3–6 months'], ['12', 'Later this year or next year'], ['res', 'Just researching']]],
        ],
        'see' => 'See my result', 'restart' => 'Start again', 'step' => 'Question',
        'r' => [
            'cit_h' => 'Yes: your budget qualifies for Turkish citizenship through property.',
            'res_h' => 'Not enough for citizenship, but you can get a residence permit through property.',
            'inv_h' => 'Yes, a residence permit is possible: the new $150,000 investor route fits your budget.',
            'buy_h' => 'Your budget fits an investment purchase, without residency or citizenship.',
            'ready' => 'A ready apartment or villa with full condominium title (kat mülkiyeti) qualifies. Buy it from a Turkish owner or company: a unit registered to a foreigner does not qualify.',
            'offplan' => 'Off-plan qualifies only if at least $400,000 is paid upfront under one notarised sales contract and a 3-year no-transfer commitment is annotated on the register.',
            'land' => 'Empty land and fields do not qualify for citizenship. Land with a licensed building does; otherwise choose an apartment, villa or commercial unit.',
            'commercial' => 'Shops and offices with full or construction title qualify, and often bring rental income.',
            'unsure' => 'Ready apartments and villas are the simplest route. Off-plan works only with $400,000 paid upfront; empty land does not qualify.',
            'rule400' => 'The declared price, the official valuation and every bank transfer must each reach $400,000, and the property is kept for 3 years.',
            'deposit' => 'With $500,000 or more you could also use a bank deposit or an approved fund, but property is the only route where your money sits in an asset you can live in or rent out.',
            'fam_me' => 'You can add your spouse and children under 18 to the same file at no extra investment.',
            'fam_spouse' => 'Your spouse is included in the same file at no extra investment.',
            'fam_kids' => 'Your spouse and children under 18 are included in the same file at no extra investment.',
            'fam_adult' => 'Adult children are included only if they are dependent on you; otherwise they need their own route.',
            'time' => 'Plan for 6 to 12 months from purchase to passport in 2026.',
            'res1' => 'Since 16 October 2023 a residence permit through property needs a home worth at least $200,000, in any city.',
            'res2' => 'The home must be residential and used by you; a property you rent out does not support the permit.',
            'res3' => 'The permit is short-term and renewable, and your family can apply with you. Citizenship through property starts at $400,000.',
            'inv1' => 'Buying property gives residency only from $200,000, so at this budget the investor route comes first; a home can be added later.',
            'inv2' => 'Since 18 November 2026, $150,000 placed in a Turkish bank deposit, government bonds, real estate or venture capital fund shares, or a private pension gives a 3-year residence permit; $200,000 gives 5 years. Your spouse and children under 18 are included.',
            'inv3' => 'The investment must stay in place for at least half of the permit term (18 months for a 3-year permit). The Interior Ministry is setting the application procedure, so check before you transfer money.',
            'res4' => 'Prefer not to buy yet? The same $200,000 in a bank deposit, bonds or approved funds now gives a 5-year investor residence permit.',
            'buy1' => 'Below $200,000 a property purchase does not lead to a residence permit, but it can still be a good investment for rental income and long-term growth.',
            'buy2' => 'Tourist, family or work permits are separate routes and do not depend on property.',
            'cta_cit' => 'Get a shortlist of eligible properties', 'cta_other' => 'Get properties that fit your budget', 'cta_inv' => 'Get a free consultation on your residence route',
            'form_p' => 'Tell us how to reach you. We will send suitable properties and the next steps in your language.',
            'disclaimer' => 'General information, not legal advice. Rules change; every file is checked by our lawyers before you pay.',
        ],
        'ok' => 'Thank you! We will send you a shortlist and the next steps shortly.',
        'err' => 'Something went wrong. Please try again or message us on WhatsApp.',
        'need' => 'Please enter your name and a phone number or email.',
        'sending' => 'Sending…', 'name' => 'Full name', 'phone' => 'Phone / WhatsApp', 'email' => 'Email', 'send' => 'Send me the shortlist',
        'privacy' => 'We use your details only to respond to your request.',
        'facts_h' => 'The 2026 thresholds at a glance',
        'facts' => [['$400,000', 'Citizenship through property, kept 3 years'], ['$500,000', 'Citizenship through deposit, bonds or funds'], ['$200,000', 'Residence permit through property'], ['$150,000', 'New investor residence (deposits, bonds, funds)']],
        'read' => 'Read the full guide', 'guide_url' => '/blog/turkish-citizenship-by-investment-2026/',
        'crumb' => 'Citizenship check',
        'wa_text' => 'Hello Land Istanbul, I checked my eligibility for Turkish citizenship and would like advice.',
    ];
    $ar = [
        'seo_title' => 'اختبار أهلية الجنسية التركية 2026: هل أنت مؤهل؟',
        'description' => 'أجب عن 4 أسئلة واعرف خلال 60 ثانية هل أنت مؤهل للجنسية التركية أو الإقامة عبر شراء عقار وفق قواعد 2026.',
        'tag' => 'اختبار مجاني · 60 ثانية',
        'h1' => 'هل أنت مؤهل للجنسية التركية؟',
        'lead' => 'أجب عن أربعة أسئلة سريعة، وسترى المسار المناسب لميزانيتك (الجنسية أو الإقامة أو الاستثمار فقط) وما يجب التحقق منه قبل الشراء. وفق القواعد السارية في نوفمبر 2026.',
        'q' => [
            ['budget', 'ما ميزانيتك؟', [['lt150', 'أقل من 150,000 دولار'], ['150', '150,000 – 199,999 دولار'], ['200', '200,000 – 399,999 دولار'], ['400', '400,000 – 499,999 دولار'], ['500', '500,000 دولار أو أكثر']]],
            ['buy', 'ماذا تخطط أن تشتري؟', [['ready', 'شقة أو فيلا جاهزة'], ['offplan', 'وحدة قيد الإنشاء'], ['land', 'أرض'], ['commercial', 'محل أو مكتب'], ['unsure', 'لم أقرر بعد']]],
            ['family', 'من يجب أن يشمله الطلب؟', [['me', 'أنا فقط'], ['spouse', 'أنا وزوجي/زوجتي'], ['kids', 'أنا والزوج والأبناء دون 18 عاماً'], ['adult', 'ومعنا أبناء بالغون']]],
            ['when', 'متى تريد التقديم؟', [['3', 'خلال 3 أشهر'], ['6', 'خلال 3–6 أشهر'], ['12', 'لاحقاً هذا العام أو العام المقبل'], ['res', 'أجمع المعلومات فقط']]],
        ],
        'see' => 'اعرض النتيجة', 'restart' => 'ابدأ من جديد', 'step' => 'السؤال',
        'r' => [
            'cit_h' => 'نعم: ميزانيتك تؤهلك للجنسية التركية عبر شراء عقار.',
            'res_h' => 'الميزانية لا تكفي للجنسية، لكن يمكنك الحصول على إقامة عبر شراء عقار.',
            'inv_h' => 'نعم، الإقامة ممكنة: مسار المستثمر الجديد بقيمة 150 ألف دولار يناسب ميزانيتك.',
            'buy_h' => 'ميزانيتك تناسب شراءً استثمارياً، دون إقامة أو جنسية.',
            'ready' => 'الشقة أو الفيلا الجاهزة ذات الطابو الكامل (kat mülkiyeti) مؤهلة. اشترِها من مالك أو شركة تركية، فالوحدة المسجلة باسم أجنبي غير مؤهلة.',
            'offplan' => 'الوحدة قيد الإنشاء مؤهلة فقط إذا دُفع 400 ألف دولار على الأقل مقدماً بموجب عقد بيع واحد موثّق، مع تسجيل التزام بعدم النقل لمدة 3 سنوات.',
            'land' => 'الأراضي الفارغة والحقول غير مؤهلة للجنسية. الأرض المقام عليها مبنى مرخّص مؤهلة، وإلا فاختر شقة أو فيلا أو وحدة تجارية.',
            'commercial' => 'المحلات والمكاتب ذات الطابو الكامل أو الإنشائي مؤهلة، وغالباً ما تحقق دخلاً من الإيجار.',
            'unsure' => 'الشقق والفلل الجاهزة هي المسار الأبسط. الوحدة قيد الإنشاء تصلح فقط مع دفع 400 ألف دولار مقدماً، والأرض الفارغة غير مؤهلة.',
            'rule400' => 'يجب أن يبلغ كل من السعر المصرّح به والتقييم الرسمي وكل تحويل بنكي 400 ألف دولار، وأن يُحتفظ بالعقار 3 سنوات.',
            'deposit' => 'بمبلغ 500 ألف دولار أو أكثر يمكنك أيضاً استخدام وديعة بنكية أو صندوق معتمد، لكن العقار هو المسار الوحيد الذي تبقى فيه أموالك في أصل يمكنك السكن فيه أو تأجيره.',
            'fam_me' => 'يمكنك إضافة الزوج/الزوجة والأبناء دون 18 عاماً إلى الملف نفسه دون استثمار إضافي.',
            'fam_spouse' => 'يُدرج الزوج/الزوجة في الملف نفسه دون استثمار إضافي.',
            'fam_kids' => 'يُدرج الزوج/الزوجة والأبناء دون 18 عاماً في الملف نفسه دون استثمار إضافي.',
            'fam_adult' => 'لا يُدرج الأبناء البالغون إلا إذا كانوا معالين، وإلا فيحتاجون إلى مسار خاص بهم.',
            'time' => 'خطّط لفترة من 6 إلى 12 شهراً من الشراء حتى الجواز في 2026.',
            'res1' => 'منذ 16 أكتوبر 2023 تتطلب الإقامة عبر العقار منزلاً لا تقل قيمته عن 200 ألف دولار في أي مدينة.',
            'res2' => 'يجب أن يكون العقار سكنياً وأن تستخدمه بنفسك؛ العقار المؤجَّر لا يصلح أساساً للإقامة.',
            'res3' => 'الإقامة قصيرة الأمد وقابلة للتجديد، ويمكن لعائلتك التقديم معك. أما الجنسية عبر العقار فتبدأ من 400 ألف دولار.',
            'inv1' => 'شراء العقار يمنح الإقامة ابتداءً من 200 ألف دولار فقط، لذا يأتي مسار المستثمر أولاً بهذه الميزانية، ويمكن شراء منزل لاحقاً.',
            'inv2' => 'منذ 18 نوفمبر 2026، يمنح إيداع 150 ألف دولار في بنك تركي أو في سندات حكومية أو حصص صناديق الاستثمار العقاري أو رأس المال المخاطر أو نظام التقاعد الخاص إقامةً لمدة 3 سنوات، و200 ألف دولار إقامةً لمدة 5 سنوات. ويشمل ذلك الزوج/الزوجة والأبناء دون 18 عاماً.',
            'inv3' => 'يجب الإبقاء على الاستثمار نصف مدة الإقامة على الأقل (18 شهراً لإقامة 3 سنوات). وتحدد وزارة الداخلية إجراءات التقديم، فتحقق منها قبل تحويل الأموال.',
            'res4' => 'لا تريد الشراء الآن؟ المبلغ نفسه (200 ألف دولار) في وديعة بنكية أو سندات أو صناديق معتمدة يمنح الآن إقامة مستثمر لمدة 5 سنوات.',
            'buy1' => 'دون 200 ألف دولار لا يؤدي شراء العقار إلى إقامة، لكنه قد يكون استثماراً جيداً لدخل الإيجار والنمو على المدى الطويل.',
            'buy2' => 'الإقامة السياحية أو العائلية أو إقامة العمل مسارات منفصلة لا تعتمد على العقار.',
            'cta_cit' => 'احصل على قائمة بالعقارات المؤهلة', 'cta_other' => 'احصل على عقارات تناسب ميزانيتك', 'cta_inv' => 'احصل على استشارة مجانية حول مسار إقامتك',
            'form_p' => 'أخبرنا كيف نتواصل معك، وسنرسل لك عقارات مناسبة والخطوات التالية بلغتك.',
            'disclaimer' => 'معلومات عامة وليست استشارة قانونية. القواعد قد تتغير، ويراجع محامونا كل ملف قبل أن تدفع.',
        ],
        'ok' => 'شكراً لك! سنرسل لك القائمة والخطوات التالية قريباً.',
        'err' => 'حدث خطأ. يرجى المحاولة مرة أخرى أو مراسلتنا عبر واتساب.',
        'need' => 'يرجى إدخال اسمك ورقم هاتفك أو بريدك الإلكتروني.',
        'sending' => 'جارٍ الإرسال…', 'name' => 'الاسم الكامل', 'phone' => 'الهاتف / واتساب', 'email' => 'البريد الإلكتروني', 'send' => 'أرسلوا لي القائمة',
        'privacy' => 'نستخدم بياناتك فقط للرد على طلبك.',
        'facts_h' => 'حدود 2026 في لمحة',
        'facts' => [['400,000 $', 'الجنسية عبر العقار مع الاحتفاظ 3 سنوات'], ['500,000 $', 'الجنسية عبر وديعة أو سندات أو صناديق'], ['200,000 $', 'الإقامة عبر شراء عقار'], ['150,000 $', 'إقامة المستثمر الجديدة (ودائع، سندات، صناديق)']],
        'read' => 'اقرأ الدليل الكامل', 'guide_url' => '/blog/ar/turkish-citizenship-by-investment-2026/',
        'crumb' => 'اختبار الأهلية',
        'wa_text' => 'مرحباً لاند إسطنبول، أجريت اختبار أهلية الجنسية التركية وأرغب في استشارة.',
    ];
    $ru = [
        'seo_title' => 'Проверка права на гражданство Турции 2026: подходите ли вы?',
        'description' => 'Ответьте на 4 вопроса и за 60 секунд узнайте, подходите ли вы для гражданства Турции или ВНЖ через покупку недвижимости по правилам 2026 года.',
        'tag' => 'Бесплатная проверка · 60 секунд',
        'h1' => 'Подходите ли вы для гражданства Турции?',
        'lead' => 'Ответьте на четыре коротких вопроса и узнайте, какой путь подходит вашему бюджету (гражданство, ВНЖ или только инвестиция) и что проверить до покупки. По правилам, действующим в ноябре 2026 года.',
        'q' => [
            ['budget', 'Какой у вас бюджет?', [['lt150', 'До $150 000'], ['150', '$150 000 – $199 999'], ['200', '$200 000 – $399 999'], ['400', '$400 000 – $499 999'], ['500', '$500 000 и больше']]],
            ['buy', 'Что вы планируете купить?', [['ready', 'Готовую квартиру или виллу'], ['offplan', 'Объект на стадии строительства'], ['land', 'Землю'], ['commercial', 'Магазин или офис'], ['unsure', 'Ещё не решил(а)']]],
            ['family', 'Кого нужно включить?', [['me', 'Только меня'], ['spouse', 'Меня и супруга(у)'], ['kids', 'Меня, супруга(у) и детей до 18 лет'], ['adult', 'Также взрослых детей']]],
            ['when', 'Когда вы хотите подать документы?', [['3', 'В ближайшие 3 месяца'], ['6', 'Через 3–6 месяцев'], ['12', 'Позже в этом или в следующем году'], ['res', 'Пока изучаю']]],
        ],
        'see' => 'Показать результат', 'restart' => 'Начать заново', 'step' => 'Вопрос',
        'r' => [
            'cit_h' => 'Да: ваш бюджет позволяет получить гражданство Турции через недвижимость.',
            'res_h' => 'Для гражданства недостаточно, но вы можете получить ВНЖ через покупку недвижимости.',
            'inv_h' => 'Да, ВНЖ возможен: вам подходит новый путь для инвесторов от $150 000.',
            'buy_h' => 'Ваш бюджет подходит для инвестиционной покупки без ВНЖ и гражданства.',
            'ready' => 'Готовая квартира или вилла с полным тапу (kat mülkiyeti) подходит. Покупайте у турецкого собственника или компании: объект, оформленный на иностранца, не подходит.',
            'offplan' => 'Строящийся объект подходит, только если не менее $400 000 оплачено вперёд по одному нотариальному договору и в реестр внесено обязательство не передавать объект 3 года.',
            'land' => 'Пустая земля и поля для гражданства не подходят. Подходит участок с законно построенным зданием; иначе выберите квартиру, виллу или коммерческое помещение.',
            'commercial' => 'Магазины и офисы с полным тапу или тапу на стадии строительства подходят и часто приносят арендный доход.',
            'unsure' => 'Проще всего с готовыми квартирами и виллами. Строящийся объект подходит только при оплате $400 000 вперёд; пустая земля не подходит.',
            'rule400' => 'Цена в договоре, официальная оценка и каждый банковский перевод должны отдельно достигать $400 000, а объект нужно держать 3 года.',
            'deposit' => 'С $500 000 и больше можно также использовать депозит или одобренный фонд, но только недвижимость оставляет ваши деньги в активе, где можно жить или который можно сдавать.',
            'fam_me' => 'В то же досье можно включить супруга(у) и детей до 18 лет без дополнительных инвестиций.',
            'fam_spouse' => 'Супруг(а) включается в то же досье без дополнительных инвестиций.',
            'fam_kids' => 'Супруг(а) и дети до 18 лет включаются в то же досье без дополнительных инвестиций.',
            'fam_adult' => 'Взрослые дети включаются, только если находятся на вашем иждивении; иначе им нужен свой путь.',
            'time' => 'Закладывайте 6–12 месяцев от покупки до паспорта в 2026 году.',
            'res1' => 'С 16 октября 2023 года для ВНЖ через недвижимость нужно жильё стоимостью не менее $200 000 в любом городе.',
            'res2' => 'Объект должен быть жилым и использоваться вами; сдаваемая в аренду недвижимость для ВНЖ не подходит.',
            'res3' => 'Это краткосрочный ВНЖ с продлением, семья может подать документы вместе с вами. Гражданство через недвижимость начинается с $400 000.',
            'inv1' => 'Покупка недвижимости даёт ВНЖ только от $200 000, поэтому при таком бюджете на первом месте путь инвестора; жильё можно купить позже.',
            'inv2' => 'С 18 ноября 2026 года $150 000 на депозите в турецком банке, в гособлигациях, паях фондов недвижимости или венчурных фондов либо в частной пенсионной системе дают ВНЖ на 3 года, $200 000 — на 5 лет. Супруг(а) и дети до 18 лет включаются.',
            'inv3' => 'Инвестицию нужно сохранять не меньше половины срока ВНЖ (18 месяцев для ВНЖ на 3 года). Порядок подачи определяет МВД, поэтому уточните его до перевода денег.',
            'res4' => 'Пока не хотите покупать? Те же $200 000 на депозите, в облигациях или одобренных фондах теперь дают ВНЖ инвестора на 5 лет.',
            'buy1' => 'При покупке до $200 000 ВНЖ не выдаётся, но объект может быть хорошей инвестицией ради аренды и долгосрочного роста.',
            'buy2' => 'Туристический, семейный и рабочий ВНЖ оформляются отдельно и не зависят от недвижимости.',
            'cta_cit' => 'Получить подборку подходящих объектов', 'cta_other' => 'Получить объекты под ваш бюджет', 'cta_inv' => 'Бесплатная консультация по вашему ВНЖ',
            'form_p' => 'Оставьте контакты: мы пришлём подходящие объекты и следующие шаги на вашем языке.',
            'disclaimer' => 'Общая информация, а не юридическая консультация. Правила меняются; наши юристы проверяют каждое досье до оплаты.',
        ],
        'ok' => 'Спасибо! Скоро пришлём подборку и следующие шаги.',
        'err' => 'Произошла ошибка. Попробуйте ещё раз или напишите нам в WhatsApp.',
        'need' => 'Укажите имя и телефон или email.',
        'sending' => 'Отправка…', 'name' => 'Имя и фамилия', 'phone' => 'Телефон / WhatsApp', 'email' => 'Эл. почта', 'send' => 'Прислать подборку',
        'privacy' => 'Ваши данные используются только для ответа на ваш запрос.',
        'facts_h' => 'Пороги 2026 года коротко',
        'facts' => [['$400 000', 'Гражданство через недвижимость, владение 3 года'], ['$500 000', 'Гражданство через депозит, облигации или фонды'], ['$200 000', 'ВНЖ через недвижимость'], ['$150 000', 'Новый ВНЖ инвестора (депозиты, облигации, фонды)']],
        'read' => 'Читать полное руководство', 'guide_url' => '/blog/ru/turkish-citizenship-by-investment-2026/',
        'crumb' => 'Проверка права',
        'wa_text' => 'Здравствуйте, Land Istanbul! Я прошёл(ла) проверку права на гражданство Турции и хочу получить консультацию.',
    ];
    $all = ['en' => $en, 'ar' => $ar, 'ru' => $ru];
    return $all[$lang] ?? $en;
}

function build_eligibility_page_html($lang) {
    $t = le_t($lang);
    $url = le_url($lang);
    $alternates = ['en' => le_url('en'), 'ar' => le_url('ar'), 'ru' => le_url('ru')];
    $wa = 'https://wa.me/' . WHATSAPP_NUMBER . '?text=' . rawurlencode($t['wa_text']);
    $schema = json_encode(['@context' => 'https://schema.org', '@graph' => [
        ['@type' => 'WebApplication', 'name' => $t['h1'], 'description' => $t['description'], 'url' => $url, 'inLanguage' => $lang,
         'applicationCategory' => 'UtilitiesApplication', 'operatingSystem' => 'All', 'isAccessibleForFree' => true,
         'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'USD'],
         'publisher' => ['@type' => 'RealEstateAgent', 'name' => 'Land Istanbul', 'url' => SITE_URL . '/']],
        ['@type' => 'BreadcrumbList', 'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Land Istanbul', 'item' => SITE_URL . '/'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => $t['crumb'], 'item' => $url]]],
    ]], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    $html = page_head($t['seo_title'] . ' | Land Istanbul', $t['description'], $url, SITE_URL . '/og-image.png', [
        'lang' => $lang, 'alternates' => $alternates, 'type' => 'website',
    ]);
    $html .= '<script type="application/ld+json">' . $schema . '</script>';
    $html .= '<main class="le"><section class="le-hero"><div class="lv-wrap">';
    $html .= '<div class="li-lang-switch">';
    foreach ($alternates as $l => $u) {
        $name = li_t($l)['lang_name'];
        $html .= $l === $lang ? '<span class="is-current">' . htmlspecialchars($name) . '</span>' : '<a href="' . htmlspecialchars(str_replace(SITE_URL, '', $u)) . '" hreflang="' . $l . '">' . htmlspecialchars($name) . '</a>';
    }
    $html .= '</div><span class="lv-tag">' . htmlspecialchars($t['tag']) . '</span><h1>' . htmlspecialchars($t['h1']) . '</h1><p class="lv-lead">' . htmlspecialchars($t['lead']) . '</p></div></section>';

    // quiz
    $html .= '<section class="le-quiz-wrap"><div class="lv-wrap"><div class="le-quiz" id="le-quiz" data-lang="' . $lang . '">';
    $html .= '<div class="le-bar"><i></i></div>';
    foreach ($t['q'] as $i => $q) {
        $html .= '<fieldset class="le-q" data-key="' . $q[0] . '"' . ($i ? ' hidden' : '') . '><legend><small>' . htmlspecialchars($t['step']) . ' ' . ($i + 1) . '/' . count($t['q']) . '</small>' . htmlspecialchars($q[1]) . '</legend><div class="le-opts">';
        foreach ($q[2] as $opt) {
            $html .= '<button type="button" class="le-opt" data-v="' . $opt[0] . '">' . htmlspecialchars($opt[1]) . '</button>';
        }
        $html .= '</div></fieldset>';
    }
    $html .= '<div class="le-result" hidden><div class="le-verdict"><span class="le-badge"></span><h2></h2></div><ul class="le-points"></ul>';
    $html .= '<p class="le-disc">' . htmlspecialchars($t['r']['disclaimer']) . '</p>';
    $html .= '<div class="le-form"><h3></h3><p>' . htmlspecialchars($t['r']['form_p']) . '</p>';
    $html .= '<form class="li-lead-form" method="post" action="/mail.php" novalidate data-ok="' . htmlspecialchars($t['ok']) . '" data-err="' . htmlspecialchars($t['err']) . '" data-need="' . htmlspecialchars($t['need']) . '" data-sending="' . htmlspecialchars($t['sending']) . '">';
    $html .= '<input type="hidden" name="source" value="' . htmlspecialchars($url) . '"><input type="hidden" name="lang" value="' . $lang . '"><input type="hidden" name="interest" value="Turkish citizenship by investment">';
    foreach ($t['q'] as $q) $html .= '<input type="hidden" name="p_' . $q[0] . '" value="">';
    $html .= '<input type="hidden" name="p_result" value="">';
    $html .= '<div class="li-hp" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>';
    $html .= '<input type="text" name="name" placeholder="' . htmlspecialchars($t['name']) . '" aria-label="' . htmlspecialchars($t['name']) . '" autocomplete="name">';
    $html .= '<div class="lv-two"><input type="tel" name="phone" dir="ltr" placeholder="' . htmlspecialchars($t['phone']) . '" aria-label="' . htmlspecialchars($t['phone']) . '" autocomplete="tel"><input type="email" name="email" placeholder="' . htmlspecialchars($t['email']) . '" aria-label="' . htmlspecialchars($t['email']) . '" autocomplete="email"></div>';
    $html .= '<button type="submit" class="li-submit">' . htmlspecialchars($t['send']) . '</button><p class="li-status" role="status" aria-live="polite"></p><p class="li-privacy">' . htmlspecialchars($t['privacy']) . '</p></form>';
    $html .= '<a class="lv-wa" href="' . htmlspecialchars($wa) . '" target="_blank" rel="noopener" data-track="whatsapp">WhatsApp</a></div>';
    $html .= '<button type="button" class="le-restart">' . htmlspecialchars($t['restart']) . '</button></div>';
    $html .= '</div></div></section>';

    // facts
    $html .= '<section class="lv-band"><div class="lv-wrap"><h2>' . htmlspecialchars($t['facts_h']) . '</h2><div class="le-facts">';
    foreach ($t['facts'] as $f) $html .= '<div><b dir="ltr">' . htmlspecialchars($f[0]) . '</b><span>' . htmlspecialchars($f[1]) . '</span></div>';
    $html .= '</div><a class="lv-taxlink" href="' . htmlspecialchars($t['guide_url']) . '">' . htmlspecialchars($t['read']) . ' →</a></div></section>';
    $html .= '</main>';
    $html .= '<script>window.LE_T=' . json_encode($t['r'] + ['q' => $t['q']], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . ';</script>';
    $html .= '<script>' . le_js() . '</script>';
    $html .= page_footer();
    return $html;
}

function le_js() {
    return <<<'JS'
(function(){
  var T = window.LE_T, quiz = document.getElementById('le-quiz'); if (!quiz) return;
  var qs = quiz.querySelectorAll('.le-q'), res = quiz.querySelector('.le-result'), bar = quiz.querySelector('.le-bar i');
  var a = {}, i = 0;
  function track(n, p){ try { if (typeof gtag === 'function') gtag('event', n, p || {}); } catch (e) {} }
  function label(key, v){ for (var k = 0; k < T.q.length; k++) if (T.q[k][0] === key) for (var j = 0; j < T.q[k][2].length; j++) if (T.q[k][2][j][0] === v) return T.q[k][2][j][1]; return v; }
  function go(n){ qs.forEach(function(q, k){ q.hidden = k !== n; }); bar.style.width = (n / qs.length * 100) + '%'; i = n; }
  function li(text){ var el = document.createElement('li'); el.textContent = text; return el; }
  function result(){
    qs.forEach(function(q){ q.hidden = true; }); bar.style.width = '100%';
    var b = a.budget, route = (b === '400' || b === '500') ? 'cit' : b === '200' ? 'res' : b === '150' ? 'inv' : 'buy';
    var ul = res.querySelector('.le-points'); ul.innerHTML = '';
    var badge = res.querySelector('.le-badge');
    badge.className = 'le-badge le-' + route; badge.textContent = route === 'cit' ? '✓' : route === 'res' ? '≈' : 'i';
    res.querySelector('h2').textContent = T[route + '_h'];
    if (route === 'cit') {
      ul.appendChild(li(T[a.buy] || T.unsure)); ul.appendChild(li(T.rule400));
      if (b === '500') ul.appendChild(li(T.deposit));
      ul.appendChild(li(T['fam_' + (a.family || 'me')] || T.fam_me));
      ul.appendChild(li(T.time));
    } else if (route === 'res') { [T.res1, T.res2, T.res3, T.res4].forEach(function(x){ ul.appendChild(li(x)); }); }
    else if (route === 'inv') { [T.inv2, T.inv3, T.inv1].forEach(function(x){ ul.appendChild(li(x)); }); }
    else { [T.buy1, T.buy2].forEach(function(x){ ul.appendChild(li(x)); }); }
    res.querySelector('.le-form h3').textContent = route === 'cit' ? T.cta_cit : route === 'inv' ? T.cta_inv : T.cta_other;
    var f = res.querySelector('form');
    f.querySelector('[name=interest]').value = { cit: 'Turkish citizenship by investment', res: 'Residence permit by property', inv: 'Investor residence permit', buy: 'Buying an apartment' }[route];
    Object.keys(a).forEach(function(k){ var h = f.querySelector('[name=p_' + k + ']'); if (h) h.value = label(k, a[k]); });
    f.querySelector('[name=p_result]').value = route;
    res.hidden = false;
    track('eligibility_result', { route: route, language: quiz.dataset.lang });
    res.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
  quiz.querySelectorAll('.le-opt').forEach(function(btn){
    btn.addEventListener('click', function(){
      var q = btn.closest('.le-q'); a[q.dataset.key] = btn.dataset.v;
      q.querySelectorAll('.le-opt').forEach(function(o){ o.classList.toggle('on', o === btn); });
      if (i === 0) track('eligibility_start', { language: quiz.dataset.lang });
      setTimeout(function(){ if (i < qs.length - 1) go(i + 1); else result(); }, 180);
    });
  });
  quiz.querySelector('.le-restart').addEventListener('click', function(){ a = {}; res.hidden = true; quiz.querySelectorAll('.le-opt').forEach(function(o){ o.classList.remove('on'); }); go(0); });
  go(0);
})();
JS;
}

function write_eligibility_pages() {
    foreach (['en', 'ar', 'ru'] as $lang) {
        $dir = SITE_ROOT . '/turkish-citizenship-eligibility' . ($lang === 'en' ? '' : '/' . $lang);
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        file_put_contents($dir . '/index.html', build_eligibility_page_html($lang));
    }
}
