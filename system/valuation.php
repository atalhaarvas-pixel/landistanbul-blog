<?php
/**
 * Free property valuation pages: /free-property-valuation/ (en), /free-property-valuation/ar/, /free-property-valuation/ru/
 * Built by regenerate_all() in generator.php. The form posts to /mail.php (interest "Free property valuation").
 */

function lv_url($lang) {
    return SITE_URL . '/free-property-valuation/' . ($lang === 'en' ? '' : $lang . '/');
}

function lv_t($lang) {
    $en = [
        'seo_title' => "Free Property Valuation in Turkey: What's My Home Worth?",
        'description' => 'Find out what your apartment, villa or land in Turkey is worth. Free, no-obligation valuation by local experts in any city, usually within 24 hours.',
        'tag' => 'Free valuation · Any city in Turkey',
        'h1' => 'What is your property in Turkey worth?',
        'lead' => 'A local expert compares your home with similar properties in the same neighbourhood and sends you a realistic price range, usually within 24 hours. Free, no obligation, in English, Arabic or Russian.',
        'chips' => ['100% free, no obligation', 'Any city in Turkey', 'Usually within 24 hours', 'English · العربية · Русский'],
        'form_title' => 'Get your free valuation',
        'steps' => ['Location', 'Property', 'Contact'],
        'next' => 'Next', 'back' => 'Back', 'submit' => 'Send my valuation request', 'required' => 'Please fill in the marked fields.',
        'f' => [
            'city' => 'City', 'district' => 'District', 'neighbourhood' => 'Neighbourhood or complex name (optional)',
            'type' => 'Property type', 'rooms' => 'Rooms', 'size' => 'Net size (m²)', 'floor' => 'Floor', 'age' => 'Building age',
            'features' => 'Features', 'deed' => 'Title deed', 'occupancy' => 'Currently', 'goal' => 'Your plan', 'price' => 'Price you have in mind (optional)',
            'name' => 'Full name', 'phone' => 'Phone / WhatsApp', 'email' => 'Email', 'message' => 'Anything else we should know? (optional)',
        ],
        'ph' => ['city' => 'e.g. Istanbul', 'district' => 'e.g. Beylikdüzü', 'neighbourhood' => 'e.g. Adnan Kahveci, or the complex name', 'size' => 'e.g. 95', 'price' => 'e.g. $250,000 or ₺10,000,000'],
        'o' => [
            'type' => ['Apartment', 'Apartment in a complex (site / residence)', 'Villa', 'Penthouse or duplex', 'Commercial (shop / office)', 'Land / plot'],
            'rooms' => ['Studio (1+0)', '1+1', '2+1', '3+1', '4+1', '5+1 or more'],
            'floor' => ['Garden / ground floor', 'Low floor (1–3)', 'Middle floor (4–10)', 'High floor (11+)', 'Top floor / penthouse'],
            'age' => ['New / under construction', '0–5 years', '6–10 years', '11–20 years', 'Over 20 years'],
            'features' => ['Sea or Bosphorus view', 'Pool', '24/7 security', 'Indoor parking', 'Elevator', 'Balcony or terrace', 'Furnished'],
            'deed' => ['Full title (kat mülkiyeti)', 'Construction title (kat irtifakı)', 'Shared title (hisseli)', 'Not sure'],
            'occupancy' => ['I live there', 'Rented out', 'Empty'],
            'goal' => ['Selling now', 'Selling within 6 months', 'Just want to know the value', 'Want to rent it out'],
        ],
        'choose' => 'Choose…',
        'ok' => 'Thank you! Your request is in. An expert will send your price range, usually within 24 hours.',
        'err' => 'Something went wrong. Please try again or message us on WhatsApp.',
        'need' => 'Please enter your name and a phone number or email.',
        'sending' => 'Sending…',
        'privacy' => 'We use your details only to send your valuation.',
        'wa' => 'Prefer WhatsApp?', 'wa_text' => 'Hello Land Istanbul, I would like a free valuation of my property in Turkey.',
        'why_h' => 'Why two similar flats can differ three times in price',
        'why_p' => 'In the same district, two 2+1 apartments can be listed at very different prices. Online averages miss what buyers actually pay for. These are the factors we check:',
        'factors' => [
            ['Exact location', 'Street, distance to metro and sea, the neighbourhood’s reputation and projects planned nearby.'],
            ['Building age and safety', 'Year of construction, compliance with earthquake codes and urban-renewal status.'],
            ['Floor, view and light', 'A sea or Bosphorus view, a higher floor and good daylight can add a large premium.'],
            ['Complex and amenities', 'Pool, security, parking and gym in a managed complex, or a stand-alone building.'],
            ['Title deed and permits', 'Full condominium title and an occupancy permit (iskan) make a property easier to sell and finance.'],
            ['Condition and layout', 'Renovation, usable net area, layout, and whether it is sold furnished.'],
        ],
        'how_h' => 'How it works',
        'how' => [
            ['Tell us about the property', 'Two minutes, no documents needed.'],
            ['We compare it with the market', 'Recent listings and transactions of similar homes in the same area.'],
            ['Receive your price range', 'On WhatsApp or by email, with the reasoning and a suggested asking price.'],
        ],
        'after_h' => 'After the valuation, you decide',
        'after' => [
            ['Sell with Land Istanbul', 'We market your property to local buyers and to foreign buyers in English, Arabic and Russian.'],
            ['Rent it out', 'Tenant search and property management while you are abroad.'],
            ['Keep it', 'No obligation. The valuation is yours to keep.'],
        ],
        'tax_link' => 'Selling within 5 years of purchase? Estimate your capital gains tax',
        'faq_h' => 'Questions owners ask',
        'faq' => [
            ['Is the valuation really free?', 'Yes. There is no fee and no obligation to sell or sign anything.'],
            ['Which cities do you cover?', 'Any city in Turkey: Istanbul, Antalya, Alanya, Bodrum, Fethiye, Izmir, Bursa, Ankara, Trabzon and elsewhere.'],
            ['How accurate is it?', 'You get a realistic price range based on comparable properties, not an automatic average. For a sharper figure we may ask for photos or arrange a visit.'],
            ['Is this an official valuation report?', 'No. It is a market valuation by our team. Banks, courts and citizenship applications require a report from an SPK-licensed valuation firm, which we can arrange for a fee.'],
            ['I live abroad. Can you value and sell my property?', 'Yes. Many of our sellers live abroad. The valuation is done remotely, and a sale can be completed with a power of attorney.'],
            ['Do I need any documents?', 'No documents are needed for the valuation. If you decide to sell, we will ask for the title deed (tapu) details.'],
        ],
        'cta_h' => 'Ready to know your price?', 'cta_p' => 'It takes two minutes and costs nothing.', 'cta_btn' => 'Start my free valuation',
        'crumb' => 'Free valuation',
    ];
    $ar = [
        'seo_title' => 'تقييم عقاري مجاني في تركيا: كم يساوي منزلك؟',
        'description' => 'اعرف القيمة الحقيقية لشقتك أو فيلتك أو أرضك في تركيا. تقييم مجاني ودون أي التزام من خبراء محليين في أي مدينة، خلال 24 ساعة عادةً.',
        'tag' => 'تقييم مجاني · في أي مدينة تركية',
        'h1' => 'كم يساوي عقارك في تركيا؟',
        'lead' => 'يقارن خبير محلي منزلك بعقارات مشابهة في الحي نفسه، ويرسل لك نطاق سعر واقعياً خلال 24 ساعة عادةً. مجاناً ودون أي التزام، بالعربية أو الإنجليزية أو الروسية.',
        'chips' => ['مجاني 100% ودون التزام', 'أي مدينة في تركيا', 'خلال 24 ساعة عادةً', 'العربية · English · Русский'],
        'form_title' => 'احصل على تقييمك المجاني',
        'steps' => ['الموقع', 'العقار', 'التواصل'],
        'next' => 'التالي', 'back' => 'رجوع', 'submit' => 'أرسل طلب التقييم', 'required' => 'يرجى تعبئة الحقول المطلوبة.',
        'f' => [
            'city' => 'المدينة', 'district' => 'المنطقة', 'neighbourhood' => 'الحي أو اسم المجمع (اختياري)',
            'type' => 'نوع العقار', 'rooms' => 'عدد الغرف', 'size' => 'المساحة الصافية (م²)', 'floor' => 'الطابق', 'age' => 'عمر المبنى',
            'features' => 'المزايا', 'deed' => 'سند الملكية', 'occupancy' => 'الوضع الحالي', 'goal' => 'خطتك', 'price' => 'السعر الذي تفكر فيه (اختياري)',
            'name' => 'الاسم الكامل', 'phone' => 'الهاتف / واتساب', 'email' => 'البريد الإلكتروني', 'message' => 'هل هناك ما تود إضافته؟ (اختياري)',
        ],
        'ph' => ['city' => 'مثال: إسطنبول', 'district' => 'مثال: بيليك دوزو', 'neighbourhood' => 'مثال: اسم الحي أو المجمع', 'size' => 'مثال: 95', 'price' => 'مثال: 250,000 دولار'],
        'o' => [
            'type' => ['شقة', 'شقة في مجمع سكني', 'فيلا', 'بنتهاوس أو دوبلكس', 'تجاري (محل / مكتب)', 'أرض'],
            'rooms' => ['استوديو (1+0)', '1+1', '2+1', '3+1', '4+1', '5+1 أو أكثر'],
            'floor' => ['حديقة / طابق أرضي', 'طابق منخفض (1–3)', 'طابق متوسط (4–10)', 'طابق مرتفع (11+)', 'الطابق الأخير / بنتهاوس'],
            'age' => ['جديد / قيد الإنشاء', '0–5 سنوات', '6–10 سنوات', '11–20 سنة', 'أكثر من 20 سنة'],
            'features' => ['إطلالة على البحر أو البوسفور', 'مسبح', 'حراسة على مدار الساعة', 'موقف سيارات داخلي', 'مصعد', 'شرفة أو تراس', 'مفروش'],
            'deed' => ['طابو كامل (kat mülkiyeti)', 'طابو إنشائي (kat irtifakı)', 'طابو مشترك (hisseli)', 'لست متأكداً'],
            'occupancy' => ['أسكن فيه', 'مؤجَّر', 'فارغ'],
            'goal' => ['أريد البيع الآن', 'البيع خلال 6 أشهر', 'أريد معرفة القيمة فقط', 'أريد تأجيره'],
        ],
        'choose' => 'اختر…',
        'ok' => 'شكراً لك! تم استلام طلبك. سيرسل لك خبيرنا نطاق السعر خلال 24 ساعة عادةً.',
        'err' => 'حدث خطأ. يرجى المحاولة مرة أخرى أو مراسلتنا عبر واتساب.',
        'need' => 'يرجى إدخال اسمك ورقم هاتفك أو بريدك الإلكتروني.',
        'sending' => 'جارٍ الإرسال…',
        'privacy' => 'نستخدم بياناتك فقط لإرسال التقييم إليك.',
        'wa' => 'تفضّل واتساب؟', 'wa_text' => 'مرحباً لاند إسطنبول، أرغب في تقييم مجاني لعقاري في تركيا.',
        'why_h' => 'لماذا قد يختلف سعر شقتين متشابهتين ثلاثة أضعاف؟',
        'why_p' => 'في المنطقة نفسها قد تُعرض شقتان من نوع 2+1 بأسعار متباعدة جداً. المتوسطات المنشورة على الإنترنت لا ترى ما يدفع المشترون مقابله فعلاً. هذه هي العوامل التي ندرسها:',
        'factors' => [
            ['الموقع الدقيق', 'الشارع، والقرب من المترو والبحر، وسمعة الحي، والمشاريع المخطط لها حوله.'],
            ['عمر المبنى وسلامته', 'سنة البناء، ومطابقته لأنظمة الزلازل، ووضعه في برامج التحول الحضري.'],
            ['الطابق والإطلالة والإضاءة', 'الإطلالة على البحر أو البوسفور والطابق المرتفع والإضاءة الجيدة قد ترفع السعر كثيراً.'],
            ['المجمع والخدمات', 'المسبح والحراسة والموقف والنادي الرياضي في مجمع مُدار، أو مبنى مستقل.'],
            ['سند الملكية والتراخيص', 'الطابو الكامل ورخصة الإسكان (iskan) تجعل البيع والتمويل أسهل.'],
            ['الحالة والتصميم', 'التجديدات، والمساحة الصافية القابلة للاستخدام، وتوزيع الغرف، وهل يُباع مفروشاً.'],
        ],
        'how_h' => 'كيف يعمل التقييم؟',
        'how' => [
            ['أخبرنا عن العقار', 'دقيقتان فقط، ودون الحاجة إلى أي مستندات.'],
            ['نقارنه بالسوق', 'الإعلانات والصفقات الأخيرة لمنازل مشابهة في المنطقة نفسها.'],
            ['استلم نطاق السعر', 'عبر واتساب أو البريد الإلكتروني، مع الأسباب وسعر عرض مقترح.'],
        ],
        'after_h' => 'بعد التقييم، القرار لك',
        'after' => [
            ['بع مع لاند إسطنبول', 'نسوّق عقارك للمشترين المحليين وللمشترين الأجانب بالعربية والإنجليزية والروسية.'],
            ['أجّره', 'البحث عن مستأجر وإدارة العقار وأنت خارج تركيا.'],
            ['احتفظ به', 'دون أي التزام، والتقييم لك.'],
        ],
        'tax_link' => 'تبيع قبل مرور 5 سنوات على الشراء؟ احسب ضريبة أرباح العقار',
        'faq_h' => 'أسئلة يطرحها الملاك',
        'faq' => [
            ['هل التقييم مجاني فعلاً؟', 'نعم. لا توجد أي رسوم ولا أي التزام بالبيع أو بتوقيع أي شيء.'],
            ['ما المدن التي تغطونها؟', 'أي مدينة في تركيا: إسطنبول وأنطاليا وألانيا وبودروم وفتحية وإزمير وبورصة وأنقرة وطرابزون وغيرها.'],
            ['ما مدى دقة التقييم؟', 'تحصل على نطاق سعر واقعي مبني على عقارات مماثلة، لا على متوسط آلي. وللحصول على رقم أدق قد نطلب صوراً أو نرتب زيارة.'],
            ['هل هذا تقرير تقييم رسمي؟', 'لا. هو تقييم سوقي يعدّه فريقنا. البنوك والمحاكم وملفات الجنسية تتطلب تقريراً من شركة تقييم مرخّصة من هيئة أسواق المال (SPK)، ويمكننا ترتيبه مقابل رسوم.'],
            ['أعيش خارج تركيا. هل يمكنكم تقييم عقاري وبيعه؟', 'نعم. كثير من عملائنا البائعين يعيشون في الخارج. يتم التقييم عن بُعد، ويمكن إتمام البيع بموجب وكالة.'],
            ['هل أحتاج إلى مستندات؟', 'لا حاجة لأي مستندات للتقييم. إذا قررت البيع سنطلب بيانات سند الملكية (الطابو).'],
        ],
        'cta_h' => 'هل أنت مستعد لمعرفة سعر عقارك؟', 'cta_p' => 'يستغرق الأمر دقيقتين ولا يكلّفك شيئاً.', 'cta_btn' => 'ابدأ التقييم المجاني',
        'crumb' => 'تقييم مجاني',
    ];
    $ru = [
        'seo_title' => 'Бесплатная оценка недвижимости в Турции: сколько стоит ваша квартира?',
        'description' => 'Узнайте, сколько стоит ваша квартира, вилла или участок в Турции. Бесплатная оценка без обязательств от местных экспертов в любом городе, обычно за 24 часа.',
        'tag' => 'Бесплатная оценка · Любой город Турции',
        'h1' => 'Сколько стоит ваша недвижимость в Турции?',
        'lead' => 'Местный эксперт сравнит ваш объект с похожими в том же районе и пришлёт реалистичный диапазон цены, обычно в течение 24 часов. Бесплатно, без обязательств, на русском, английском или арабском.',
        'chips' => ['100% бесплатно, без обязательств', 'Любой город Турции', 'Обычно за 24 часа', 'Русский · English · العربية'],
        'form_title' => 'Получить бесплатную оценку',
        'steps' => ['Расположение', 'Объект', 'Контакты'],
        'next' => 'Далее', 'back' => 'Назад', 'submit' => 'Отправить заявку на оценку', 'required' => 'Заполните отмеченные поля.',
        'f' => [
            'city' => 'Город', 'district' => 'Район', 'neighbourhood' => 'Микрорайон или название комплекса (необязательно)',
            'type' => 'Тип объекта', 'rooms' => 'Комнаты', 'size' => 'Полезная площадь (м²)', 'floor' => 'Этаж', 'age' => 'Возраст здания',
            'features' => 'Особенности', 'deed' => 'Тип тапу', 'occupancy' => 'Сейчас', 'goal' => 'Ваши планы', 'price' => 'Цена, на которую вы рассчитываете (необязательно)',
            'name' => 'Имя и фамилия', 'phone' => 'Телефон / WhatsApp', 'email' => 'Эл. почта', 'message' => 'Что ещё нам стоит знать? (необязательно)',
        ],
        'ph' => ['city' => 'например, Стамбул', 'district' => 'например, Бейликдюзю', 'neighbourhood' => 'например, название комплекса', 'size' => 'например, 95', 'price' => 'например, $250 000'],
        'o' => [
            'type' => ['Квартира', 'Квартира в жилом комплексе (сите)', 'Вилла', 'Пентхаус или дуплекс', 'Коммерческая (магазин / офис)', 'Земельный участок'],
            'rooms' => ['Студия (1+0)', '1+1', '2+1', '3+1', '4+1', '5+1 и больше'],
            'floor' => ['Сад / первый этаж', 'Низкий (1–3)', 'Средний (4–10)', 'Высокий (11+)', 'Последний / пентхаус'],
            'age' => ['Новый / строится', '0–5 лет', '6–10 лет', '11–20 лет', 'Более 20 лет'],
            'features' => ['Вид на море или Босфор', 'Бассейн', 'Круглосуточная охрана', 'Подземный паркинг', 'Лифт', 'Балкон или терраса', 'С мебелью'],
            'deed' => ['Полное тапу (kat mülkiyeti)', 'Тапу на стадии строительства (kat irtifakı)', 'Долевое тапу (hisseli)', 'Не знаю'],
            'occupancy' => ['Живу сам(а)', 'Сдаётся', 'Пустует'],
            'goal' => ['Продаю сейчас', 'Продам в ближайшие 6 месяцев', 'Хочу только узнать цену', 'Хочу сдать в аренду'],
        ],
        'choose' => 'Выберите…',
        'ok' => 'Спасибо! Заявка получена. Эксперт пришлёт диапазон цены, обычно в течение 24 часов.',
        'err' => 'Произошла ошибка. Попробуйте ещё раз или напишите нам в WhatsApp.',
        'need' => 'Укажите имя и телефон или email.',
        'sending' => 'Отправка…',
        'privacy' => 'Ваши данные используются только для отправки оценки.',
        'wa' => 'Удобнее в WhatsApp?', 'wa_text' => 'Здравствуйте, Land Istanbul! Хочу получить бесплатную оценку моей недвижимости в Турции.',
        'why_h' => 'Почему цены на похожие квартиры отличаются в три раза',
        'why_p' => 'В одном и том же районе две квартиры 2+1 могут продаваться по совершенно разным ценам. Средние цифры в интернете не учитывают то, за что покупатели действительно платят. Вот что мы проверяем:',
        'factors' => [
            ['Точное расположение', 'Улица, расстояние до метро и моря, репутация района и проекты, запланированные поблизости.'],
            ['Возраст и безопасность здания', 'Год постройки, соответствие сейсмическим нормам, статус в программе реновации.'],
            ['Этаж, вид и освещение', 'Вид на море или Босфор, высокий этаж и хорошее освещение могут заметно поднять цену.'],
            ['Комплекс и инфраструктура', 'Бассейн, охрана, парковка и спортзал в управляемом комплексе или отдельный дом.'],
            ['Тапу и разрешения', 'Полное тапу и разрешение на заселение (iskan) упрощают продажу и ипотеку.'],
            ['Состояние и планировка', 'Ремонт, полезная площадь, планировка и продаётся ли объект с мебелью.'],
        ],
        'how_h' => 'Как это работает',
        'how' => [
            ['Расскажите об объекте', 'Две минуты, документы не нужны.'],
            ['Мы сравним его с рынком', 'Актуальные объявления и сделки по похожим объектам в том же районе.'],
            ['Получите диапазон цены', 'В WhatsApp или по почте, с обоснованием и рекомендуемой ценой продажи.'],
        ],
        'after_h' => 'После оценки решение за вами',
        'after' => [
            ['Продать с Land Istanbul', 'Мы предлагаем ваш объект местным покупателям и иностранным покупателям на русском, английском и арабском.'],
            ['Сдать в аренду', 'Поиск арендатора и управление недвижимостью, пока вы за границей.'],
            ['Оставить себе', 'Никаких обязательств. Оценка остаётся у вас.'],
        ],
        'tax_link' => 'Продаёте раньше чем через 5 лет после покупки? Рассчитайте налог на прирост капитала',
        'faq_h' => 'Вопросы владельцев',
        'faq' => [
            ['Оценка действительно бесплатная?', 'Да. Никакой оплаты и никаких обязательств что-либо продавать или подписывать.'],
            ['В каких городах вы работаете?', 'В любом городе Турции: Стамбул, Анталья, Аланья, Бодрум, Фетхие, Измир, Бурса, Анкара, Трабзон и другие.'],
            ['Насколько точна оценка?', 'Вы получаете реалистичный диапазон цены на основе сопоставимых объектов, а не автоматическое среднее. Для более точной цифры мы можем попросить фото или организовать осмотр.'],
            ['Это официальный отчёт об оценке?', 'Нет. Это рыночная оценка нашей команды. Банкам, судам и для получения гражданства нужен отчёт оценочной компании с лицензией SPK; мы можем организовать его за плату.'],
            ['Я живу за границей. Можете оценить и продать мой объект?', 'Да. Многие наши клиенты-продавцы живут за границей. Оценка проводится дистанционно, а продажу можно оформить по доверенности.'],
            ['Нужны ли документы?', 'Для оценки документы не нужны. Если решите продавать, мы попросим данные тапу.'],
        ],
        'cta_h' => 'Готовы узнать цену?', 'cta_p' => 'Это займёт две минуты и ничего не стоит.', 'cta_btn' => 'Начать бесплатную оценку',
        'crumb' => 'Бесплатная оценка',
    ];
    $all = ['en' => $en, 'ar' => $ar, 'ru' => $ru];
    return $all[$lang] ?? $en;
}

function lv_select($name, $label, array $labels, array $values, $choose, $req = true) {
    $h = '<div class="lv-f"><label for="lv-' . $name . '">' . htmlspecialchars($label) . ($req ? ' <i>*</i>' : '') . '</label><select id="lv-' . $name . '" name="p_' . $name . '"' . ($req ? ' data-req="1"' : '') . '><option value="">' . htmlspecialchars($choose) . '</option>';
    foreach ($labels as $i => $l) $h .= '<option value="' . htmlspecialchars($values[$i]) . '">' . htmlspecialchars($l) . '</option>';
    return $h . '</select></div>';
}

function lv_input($name, $label, $ph = '', $req = true, $type = 'text', $field = null) {
    $field = $field ?: 'p_' . $name;
    return '<div class="lv-f"><label for="lv-' . $name . '">' . htmlspecialchars($label) . ($req ? ' <i>*</i>' : '') . '</label><input id="lv-' . $name . '" type="' . $type . '" name="' . $field . '" placeholder="' . htmlspecialchars($ph) . '"' . ($req ? ' data-req="1"' : '') . ($type === 'tel' ? ' dir="ltr"' : '') . '></div>';
}

function build_valuation_page_html($lang) {
    $t = lv_t($lang);
    $en = lv_t('en');
    $url = lv_url($lang);
    $alternates = ['en' => lv_url('en'), 'ar' => lv_url('ar'), 'ru' => lv_url('ru')];
    $wa = 'https://wa.me/' . WHATSAPP_NUMBER . '?text=' . rawurlencode($t['wa_text']);

    $faq = [];
    foreach ($t['faq'] as $f) $faq[] = ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]];
    $schema = json_encode(['@context' => 'https://schema.org', '@graph' => [
        ['@type' => 'Service', 'name' => $t['h1'], 'serviceType' => 'Property valuation', 'description' => $t['description'], 'url' => $url, 'inLanguage' => $lang,
         'areaServed' => ['@type' => 'Country', 'name' => 'Turkey'],
         'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'USD'],
         'provider' => ['@type' => 'RealEstateAgent', 'name' => 'Land Istanbul', 'url' => SITE_URL . '/', 'logo' => SITE_URL . '/logo.png']],
        ['@type' => 'FAQPage', 'mainEntity' => $faq],
        ['@type' => 'BreadcrumbList', 'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Land Istanbul', 'item' => SITE_URL . '/'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => $t['crumb'], 'item' => $url]]],
    ]], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    $f = $t['f']; $o = $t['o']; $eo = $en['o'];
    $cities = ['Istanbul', 'Antalya', 'Alanya', 'Muğla (Bodrum, Fethiye, Marmaris)', 'Izmir', 'Bursa', 'Ankara', 'Mersin', 'Kocaeli', 'Yalova', 'Trabzon', 'Sakarya', 'Tekirdağ', 'Aydın (Kuşadası, Didim)'];

    // form
    $form = '<form class="li-lead-form lv-form" id="valuation-form" method="post" action="/mail.php" novalidate'
        . ' data-ok="' . htmlspecialchars($t['ok']) . '" data-err="' . htmlspecialchars($t['err']) . '" data-need="' . htmlspecialchars($t['need']) . '" data-sending="' . htmlspecialchars($t['sending']) . '" data-required="' . htmlspecialchars($t['required']) . '">';
    $form .= '<input type="hidden" name="interest" value="Free property valuation"><input type="hidden" name="source" value="' . htmlspecialchars($url) . '"><input type="hidden" name="lang" value="' . $lang . '">';
    $form .= '<div class="li-hp" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>';
    $form .= '<div class="lv-progress"><ol>';
    foreach ($t['steps'] as $i => $s) $form .= '<li' . ($i === 0 ? ' class="on"' : '') . '><b>' . ($i + 1) . '</b> ' . htmlspecialchars($s) . '</li>';
    $form .= '</ol></div>';
    // step 1
    $form .= '<div class="lv-step" data-step="1">';
    $form .= '<div class="lv-f"><label for="lv-city">' . htmlspecialchars($f['city']) . ' <i>*</i></label><input id="lv-city" name="p_city" list="lv-cities" placeholder="' . htmlspecialchars($t['ph']['city']) . '" data-req="1" autocomplete="address-level1"><datalist id="lv-cities">';
    foreach ($cities as $c) $form .= '<option value="' . htmlspecialchars($c) . '">';
    $form .= '</datalist></div>';
    $form .= lv_input('district', $f['district'], $t['ph']['district']);
    $form .= lv_input('neighbourhood', $f['neighbourhood'], $t['ph']['neighbourhood'], false);
    $form .= lv_select('type', $f['type'], $o['type'], $eo['type'], $t['choose']);
    $form .= '<div class="lv-nav"><span></span><button type="button" class="lv-next">' . htmlspecialchars($t['next']) . ' →</button></div></div>';
    // step 2
    $form .= '<div class="lv-step" data-step="2" hidden><div class="lv-two">';
    $form .= lv_select('rooms', $f['rooms'], $o['rooms'], $eo['rooms'], $t['choose']);
    $form .= lv_input('size', $f['size'], $t['ph']['size'], true, 'number');
    $form .= lv_select('floor', $f['floor'], $o['floor'], $eo['floor'], $t['choose'], false);
    $form .= lv_select('age', $f['age'], $o['age'], $eo['age'], $t['choose']);
    $form .= lv_select('deed', $f['deed'], $o['deed'], $eo['deed'], $t['choose'], false);
    $form .= lv_select('occupancy', $f['occupancy'], $o['occupancy'], $eo['occupancy'], $t['choose'], false);
    $form .= '</div><fieldset class="lv-checks"><legend>' . htmlspecialchars($f['features']) . '</legend>';
    foreach ($o['features'] as $i => $l) $form .= '<label><input type="checkbox" name="p_features[]" value="' . htmlspecialchars($eo['features'][$i]) . '"> ' . htmlspecialchars($l) . '</label>';
    $form .= '</fieldset>';
    $form .= '<div class="lv-nav"><button type="button" class="lv-back">' . htmlspecialchars($t['back']) . '</button><button type="button" class="lv-next">' . htmlspecialchars($t['next']) . ' →</button></div></div>';
    // step 3
    $form .= '<div class="lv-step" data-step="3" hidden>';
    $form .= lv_select('goal', $f['goal'], $o['goal'], $eo['goal'], $t['choose'], false);
    $form .= lv_input('price', $f['price'], $t['ph']['price'], false);
    $form .= lv_input('name', $f['name'], '', true, 'text', 'name');
    $form .= '<div class="lv-two">' . lv_input('phone', $f['phone'], '+', false, 'tel', 'phone') . lv_input('email', $f['email'], '', false, 'email', 'email') . '</div>';
    $form .= '<div class="lv-f"><label for="lv-message">' . htmlspecialchars($f['message']) . '</label><textarea id="lv-message" name="message" rows="2"></textarea></div>';
    $form .= '<div class="lv-nav"><button type="button" class="lv-back">' . htmlspecialchars($t['back']) . '</button><button type="submit" class="li-submit">' . htmlspecialchars($t['submit']) . '</button></div>';
    $form .= '<p class="li-status" role="status" aria-live="polite"></p><p class="li-privacy">' . htmlspecialchars($t['privacy']) . '</p></div>';
    $form .= '</form>';

    $html = page_head($t['seo_title'] . ' | Land Istanbul', $t['description'], $url, SITE_URL . '/og-image.png', [
        'lang' => $lang, 'alternates' => $alternates, 'type' => 'website',
    ]);
    $html .= '<script type="application/ld+json">' . $schema . '</script>';
    $html .= '<main class="lv">';
    $html .= '<section class="lv-hero"><div class="lv-wrap lv-hero-grid">';
    $html .= '<div class="lv-intro"><div class="li-lang-switch">';
    foreach ($alternates as $l => $u) {
        $name = li_t($l)['lang_name'];
        $html .= $l === $lang ? '<span class="is-current">' . htmlspecialchars($name) . '</span>' : '<a href="' . htmlspecialchars(str_replace(SITE_URL, '', $u)) . '" hreflang="' . $l . '">' . htmlspecialchars($name) . '</a>';
    }
    $html .= '</div><span class="lv-tag">' . htmlspecialchars($t['tag']) . '</span><h1>' . htmlspecialchars($t['h1']) . '</h1><p class="lv-lead">' . htmlspecialchars($t['lead']) . '</p><ul class="lv-chips">';
    foreach ($t['chips'] as $c) $html .= '<li>' . htmlspecialchars($c) . '</li>';
    $html .= '</ul>' . lv_house_svg() . '</div>';
    $html .= '<div class="lv-card"><h2>' . htmlspecialchars($t['form_title']) . '</h2>' . $form . '<a class="lv-wa" href="' . htmlspecialchars($wa) . '" target="_blank" rel="noopener" data-track="whatsapp">' . htmlspecialchars($t['wa']) . ' WhatsApp</a></div>';
    $html .= '</div></section>';

    $html .= '<section class="lv-band"><div class="lv-wrap"><h2>' . htmlspecialchars($t['why_h']) . '</h2><p class="lv-p">' . htmlspecialchars($t['why_p']) . '</p><div class="lv-factors">';
    foreach ($t['factors'] as $i => $x) $html .= '<div class="lv-factor"><b>' . ($i + 1) . '</b><h3>' . htmlspecialchars($x[0]) . '</h3><p>' . htmlspecialchars($x[1]) . '</p></div>';
    $html .= '</div></div></section>';

    $html .= '<section class="lv-band lv-dark"><div class="lv-wrap"><h2>' . htmlspecialchars($t['how_h']) . '</h2><ol class="lv-how">';
    foreach ($t['how'] as $x) $html .= '<li><h3>' . htmlspecialchars($x[0]) . '</h3><p>' . htmlspecialchars($x[1]) . '</p></li>';
    $html .= '</ol></div></section>';

    $html .= '<section class="lv-band"><div class="lv-wrap"><h2>' . htmlspecialchars($t['after_h']) . '</h2><div class="lv-after">';
    foreach ($t['after'] as $x) $html .= '<div><h3>' . htmlspecialchars($x[0]) . '</h3><p>' . htmlspecialchars($x[1]) . '</p></div>';
    $html .= '</div><a class="lv-taxlink" href="/tax-calculator/">' . htmlspecialchars($t['tax_link']) . ' →</a></div></section>';

    $html .= '<section class="lv-band lv-alt"><div class="lv-wrap li-faq"><h2>' . htmlspecialchars($t['faq_h']) . '</h2>';
    foreach ($t['faq'] as $x) $html .= '<details><summary>' . htmlspecialchars($x[0]) . '</summary><p>' . htmlspecialchars($x[1]) . '</p></details>';
    $html .= '</div></section>';

    $html .= '<section class="lv-cta"><h2>' . htmlspecialchars($t['cta_h']) . '</h2><p>' . htmlspecialchars($t['cta_p']) . '</p><a href="#valuation-form" class="lv-cta-btn">' . htmlspecialchars($t['cta_btn']) . '</a></section>';
    $html .= '</main>';
    $html .= page_footer();
    return $html;
}

function lv_house_svg() {
    return '<svg class="lv-art" viewBox="0 0 520 220" role="img" aria-hidden="true">'
        . '<rect x="0" y="196" width="520" height="24" fill="#171717"/>'
        . '<rect x="40" y="70" width="120" height="126" fill="#171717"/><polygon points="30,74 100,24 170,74" fill="#c50000"/>'
        . '<g fill="#fffdef"><rect x="62" y="96" width="24" height="24"/><rect x="114" y="96" width="24" height="24"/><rect x="62" y="140" width="24" height="24"/><rect x="114" y="140" width="24" height="56"/></g>'
        . '<rect x="190" y="38" width="90" height="158" fill="#2b2b2b"/><g fill="#e7e2d4">'
        . '<rect x="204" y="54" width="16" height="16"/><rect x="250" y="54" width="16" height="16"/><rect x="204" y="86" width="16" height="16"/><rect x="250" y="86" width="16" height="16"/><rect x="204" y="118" width="16" height="16"/><rect x="250" y="118" width="16" height="16"/><rect x="204" y="150" width="16" height="16"/><rect x="250" y="150" width="16" height="16"/></g>'
        . '<rect x="300" y="110" width="180" height="86" fill="#171717"/><polygon points="290,114 390,64 490,114" fill="#e70000"/>'
        . '<g fill="#fffdef"><rect x="322" y="132" width="34" height="22"/><rect x="372" y="132" width="34" height="22"/><rect x="422" y="132" width="34" height="22"/><rect x="372" y="166" width="34" height="30"/></g>'
        . '<g transform="translate(408 8)"><rect width="104" height="44" fill="#e70000"/><text x="52" y="29" text-anchor="middle" font-family="Roboto Condensed,Arial,sans-serif" font-weight="900" font-size="20" fill="#fff">₺ $ €</text></g>'
        . '</svg>';
}

function write_valuation_pages() {
    foreach (['en', 'ar', 'ru'] as $lang) {
        $dir = SITE_ROOT . '/free-property-valuation' . ($lang === 'en' ? '' : '/' . $lang);
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        file_put_contents($dir . '/index.html', build_valuation_page_html($lang));
    }
}
