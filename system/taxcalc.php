<?php
/**
 * Capital gains tax calculator pages: /tax-calculator/ (+ /ar/, /ru/). All amounts in Turkish lira.
 * Built by system/install.php from data/tax-data.json (Yİ-ÜFE, exemptions, non-wage brackets).
 */

function tc_logo() { return '<span class="li-logo-main">LAND ISTANBUL</span><span class="li-logo-by">by Math Investment</span>'; }
function tc_footer_line() {
    return '<p class="li-foot-line">© 2026 Land Istanbul by Math Investment · <a href="https://www.google.com/maps/place//data=!4m2!3m1!1s0x14caa181dce03687:0xc7290e74b462666c" target="_blank" rel="noopener">Kavaklı, Olimpiyat Cd. No:58, 34520 Beylikdüzü / İstanbul</a></p>';
}
function tc_asset($name) {
    $f = __DIR__ . '/' . $name;
    return '/' . $name . (is_file($f) ? '?v=' . substr(md5_file($f), 0, 10) : '');
}
function tc_path($lang) { return '/tax-calculator/' . ($lang === 'en' ? '' : $lang . '/'); }
function tc_url($lang) { return 'https://landistanbul.com' . tc_path($lang); }
function tc_loc($base, $lang) { return $base . ($lang === 'en' ? '' : $lang . '/'); }

function tc_t($lang) {
    $en = [
        'locale' => 'en_US', 'date_locale' => 'en-GB', 'num_locale' => 'en-US', 'lang_name' => 'English',
        'title' => 'Turkey Property Capital Gains Tax Calculator 2026 | Land Istanbul',
        'desc' => 'Free 2026 calculator for capital gains tax when you sell property in Turkey. Official GİB method: PPI indexing, ₺150,000 exemption, non-wage tax brackets, all in Turkish lira.',
        'og_title' => 'Turkey Property Capital Gains Tax Calculator 2026',
        'og_desc' => 'Selling property in Turkey? See in 30 seconds whether you owe capital gains tax, how much, and when your sale becomes tax-free.',
        'app' => 'Turkey Property Capital Gains Tax Calculator',
        'nav' => ['Home', 'Services', 'Free Valuation', 'Tax Calculator', 'Blog', 'Contact Us'],
        'crumb_home' => 'Home', 'crumb' => 'Tax Calculator',
        'h1' => 'Turkey Property Capital Gains Tax Calculator 2026',
        'lead' => 'Selling an apartment, villa or land in Turkey? See in 30 seconds whether you owe tax, how much, and the date your sale becomes tax-free. Enter the prices in Turkish lira, as written on your title deed and sale contract.',
        'badges' => ['Official GİB method', 'PPI data to <b id="ppi-latest"></b>', '2026 exemption <b>₺150,000</b>', 'All figures in Turkish lira'],
        'your_sale' => 'Your sale', 'example' => 'Example figures: replace them with yours', 'yours' => 'Your figures',
        'how' => 'How did you get the property?', 'bought' => 'I bought it', 'gift' => 'Inherited or gift',
        'd1' => 'Purchase date (title deed)', 'd2' => 'Sale date', 'buy' => 'Purchase price (₺)', 'sell' => 'Sale price (₺)',
        'fx_hint' => "Paid in dollars or euros? Convert at the rate on that date (your bank's exchange receipt, DAB, shows it), not at today's rate.",
        'more' => '+ Add deductible costs (optional)', 'exp' => 'Other documented selling costs (₺)',
        'exp_hint' => "Agent commission, notary and legal fees for the sale, and invoiced improvements. The seller's 2% title deed fee is added automatically.",
        'res_label' => 'Estimated capital gains tax', 'enter' => 'Enter your figures.', 'rule5' => '5-year rule',
        'deed' => "Seller's title deed fee (2%)", 'keep' => 'You keep after tax and fee',
        'btn_val' => 'Get a free valuation', 'btn_send' => 'Email me this result', 'btn_copy' => 'Copy result', 'copied' => 'Copied',
        'lead_h' => 'Get this calculation checked',
        'lead_p' => 'We will review your figures, send you a free valuation of the property and explain the cheapest time to sell.',
        'ok' => 'Thank you! We will be in touch shortly.', 'err' => 'Something went wrong. Please try again or message us on WhatsApp.',
        'need' => 'Please enter your name and an email or phone number.', 'sending' => 'Sending…',
        'name' => 'Full name', 'email' => 'Email', 'phone' => 'Phone / WhatsApp', 'send' => 'Send',
        'privacy' => 'We use your details only to respond to your request.',
        'show_calc' => 'Show the full calculation',
        'note' => 'Estimate for information only, not tax advice. Your tax office or accountant confirms the final figure.',
        'how_h' => 'How the tax is calculated',
        'how_p' => 'Turkey taxes the gain on a property sold within five years of acquisition (Income Tax Law, repeated Article 80). The calculation is always in Turkish lira, with the purchase cost adjusted for inflation:',
        'steps' => [
            ['Convert to lira at the right dates', 'Purchase price at the purchase-date rate, sale price at the sale-date rate.'],
            ['Index the purchase cost', 'Multiply by Yİ-ÜFE of the month before the sale ÷ Yİ-ÜFE of the month before the purchase, if the increase is 10% or more.'],
            ['Deduct selling costs', "The seller's 2% title deed fee and other documented costs of the sale."],
            ['Net gain', 'Sale price minus indexed cost minus costs. Zero or less means no tax.'],
            ['Annual exemption', '₺150,000 for sales in 2026, once per calendar year for all your property gains.'],
            ['Progressive tax', 'The non-wage income tariff of the year of sale, from 15% to 40%.'],
        ],
        'rates_h' => '2026 rates', 'th_gain' => 'Taxable gain, 2026 (₺)', 'th_rate' => 'Rate', 'upto' => 'Up to', 'above' => 'Above',
        'tariff_src' => "Non-wage income tariff for 2026 (General Communiqué No. 332). Property gains are not wage income, so the wage tariff's wider 27% band does not apply.",
        'th_year' => 'Year of sale', 'th_ex' => 'Annual exemption',
        'rules' => [
            ['5 years = no tax', 'Sell five years or more after the date on your title deed and the gain is not taxed, whatever the amount.'],
            ['Inherited or gift', 'Property received free of charge (inheritance or gift) is outside this tax, even if sold within five years.'],
            ['Declare in March', 'A taxable gain is declared on the income tax return in March of the year after the sale and paid in two instalments.'],
        ],
        'faq_h' => 'Questions sellers ask',
        'faq' => [
            ['Do foreigners pay capital gains tax when selling property in Turkey?', 'Yes, if the property is sold within 5 years of acquisition and the inflation-indexed gain is above the annual exemption (₺150,000 for sales in 2026). The rules are the same for Turkish citizens and foreigners. Property held 5 years or more, and property received by inheritance or as a gift, is not taxed on the gain.'],
            ['Which tax rates apply to property gains in 2026?', 'Gains from selling property are non-wage income, so the 2026 non-wage tariff applies: 15% up to ₺190,000, 20% up to ₺400,000, 27% up to ₺1,000,000, 35% up to ₺5,300,000 and 40% above that.'],
            ['I paid in dollars or euros. What do I enter?', "Enter both prices in Turkish lira. Convert the purchase price at the rate on the purchase date (the rate on your bank's foreign-exchange purchase certificate, DAB, is the best figure) and the sale price at the rate on the sale date. Converting both at today's rate gives a wrong result."],
            ['How is the purchase price indexed for inflation?', 'The purchase cost is multiplied by the ratio of the domestic producer price index (Yİ-ÜFE) of the month before the sale to that of the month before the purchase, provided the increase is at least 10%.'],
            ['I got citizenship with this property. Can I sell after 3 years tax-free?', 'The 3-year citizenship lock and the 5-year tax rule are separate. Selling in years 3 to 5 is allowed, but the indexed gain above the exemption is taxed. Use the calculator to compare selling now with waiting until the 5-year date.'],
            ['Is the title deed fee affected by the 5-year rule?', "No. The title deed fee (4% of the declared price, 2% paid by the seller and 2% by the buyer) is a transaction fee paid on every sale. The seller's share can be deducted as an expense when the gain is taxable."],
        ],
        'sources' => 'Sources: Revenue Administration (GİB) General Communiqué No. 332 for the 2026 tariff and exemption; TÜİK Yİ-ÜFE (2003=100). Last updated {upd}.',
        'cta_h' => 'Thinking of selling?',
        'cta_p' => "Know your property's real market value before you decide. Our free valuation covers any city in Turkey.",
        'cta_wa' => 'WhatsApp us', 'wa_text' => 'Hello Land Istanbul, I used your tax calculator and would like advice on selling.',
        'js' => [
            'months' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            'enter_all' => 'Enter the dates and both prices.', 'order' => 'The sale date must be after the purchase date.', 'no_ppi' => 'No price index for those dates.',
            'held' => 'Held {y} yr {m} mo', 'held0' => 'Held {m} mo', 'free' => 'Tax-free from {d}',
            'r_gift' => 'Inherited or gifted property is not taxed on the gain.', 'r_5' => 'Held 5 years or more: the gain is exempt.',
            'r_nogain' => 'No taxable gain after inflation indexing and costs.', 'r_below' => 'The gain is below the {y} exemption of {x}.',
            'not_pub' => '{y} rates are not published yet; {b} figures are used.', 'ppi_fb' => 'Yİ-ÜFE for {m} is not published yet; the latest month was used.',
            'bd_buy' => 'Purchase price', 'bd_sell' => 'Sale price', 'bd_ppi' => 'Yİ-ÜFE {a} → {b}', 'bd_na' => ' (under 10%: not applied)',
            'bd_idx' => 'Indexed purchase cost', 'bd_deed' => "Seller's title deed fee (2%)", 'bd_other' => 'Other selling costs',
            'bd_net' => 'Net gain', 'bd_ex' => 'Annual exemption ({y})', 'bd_base' => 'Taxable base', 'bd_on' => 'Tax on {s} at {r}%', 'bd_tax' => 'Estimated tax',
            'eff' => 'Effective rate {p}% of your net gain',
            'save' => 'Selling on or after <b>{d}</b>{w} would make this tax <b>zero</b>: a saving of about <b>{x}</b>.',
            'wait1' => ' (1 month later)', 'waitN' => ' ({n} months later)',
            'no_tax' => 'No tax', 'no_due' => 'No tax is due.',
            'sum_h' => 'Capital gains tax estimate', 'sum_buy' => 'Purchase', 'sum_sell' => 'Sale', 'sum_tax' => 'Estimated tax',
            'sum_deed' => "Seller's title deed fee", 'sum_free' => 'Tax-free from', 'sum_gift' => ' (inherited/gift)',
        ],
    ];
    $ar = [
        'locale' => 'ar_AR', 'date_locale' => 'ar-u-nu-latn', 'num_locale' => 'en-US', 'lang_name' => 'العربية',
        'title' => 'حاسبة ضريبة أرباح بيع العقار في تركيا 2026 | Land Istanbul',
        'desc' => 'حاسبة مجانية لعام 2026 لضريبة الأرباح عند بيع عقار في تركيا، بالطريقة الرسمية لإدارة الإيرادات: تعديل التكلفة وفق مؤشر أسعار المنتجين، وإعفاء 150,000 ليرة، وشرائح الضريبة، وكل المبالغ بالليرة التركية.',
        'og_title' => 'حاسبة ضريبة بيع العقار في تركيا 2026',
        'og_desc' => 'تبيع عقاراً في تركيا؟ اعرف خلال 30 ثانية هل عليك ضريبة، وكم تبلغ، ومتى يصبح البيع معفى منها.',
        'app' => 'حاسبة ضريبة أرباح بيع العقار في تركيا',
        'nav' => ['الرئيسية', 'الخدمات', 'تقييم مجاني', 'حاسبة الضريبة', 'المدونة', 'تواصل معنا'],
        'crumb_home' => 'الرئيسية', 'crumb' => 'حاسبة الضريبة',
        'h1' => 'حاسبة ضريبة أرباح بيع العقار في تركيا 2026',
        'lead' => 'تبيع شقة أو فيلا أو أرضاً في تركيا؟ اعرف خلال 30 ثانية هل عليك ضريبة، وكم تبلغ، والتاريخ الذي يصبح فيه البيع معفى منها. أدخل الأسعار بالليرة التركية كما هي مكتوبة في سند الطابو وعقد البيع.',
        'badges' => ['الطريقة الرسمية لإدارة الإيرادات (GİB)', 'بيانات المؤشر حتى <b id="ppi-latest"></b>', 'إعفاء 2026: <b dir="ltr">₺150,000</b>', 'كل المبالغ بالليرة التركية'],
        'your_sale' => 'بيانات البيع', 'example' => 'أرقام توضيحية: استبدلها بأرقامك', 'yours' => 'أرقامك',
        'how' => 'كيف حصلت على العقار؟', 'bought' => 'اشتريته', 'gift' => 'ميراث أو هبة',
        'd1' => 'تاريخ الشراء (في الطابو)', 'd2' => 'تاريخ البيع', 'buy' => 'سعر الشراء (₺)', 'sell' => 'سعر البيع (₺)',
        'fx_hint' => 'دفعت بالدولار أو اليورو؟ حوّل المبلغ بسعر الصرف في ذلك التاريخ (يظهر في إيصال صرف العملة من البنك DAB)، وليس بسعر اليوم.',
        'more' => '+ أضف تكاليف قابلة للخصم (اختياري)', 'exp' => 'تكاليف بيع أخرى موثقة (₺)',
        'exp_hint' => 'عمولة الوسيط، ورسوم الكاتب العدل والمحامي الخاصة بالبيع، والتحسينات الموثقة بفواتير. تُضاف رسوم الطابو على البائع (2%) تلقائياً.',
        'res_label' => 'الضريبة المقدّرة على الأرباح', 'enter' => 'أدخل أرقامك.', 'rule5' => 'قاعدة السنوات الخمس',
        'deed' => 'رسوم الطابو على البائع (2%)', 'keep' => 'ما يبقى لك بعد الضريبة والرسوم',
        'btn_val' => 'احصل على تقييم مجاني', 'btn_send' => 'أرسلوا لي هذه النتيجة', 'btn_copy' => 'انسخ النتيجة', 'copied' => 'تم النسخ',
        'lead_h' => 'دعنا نراجع هذا الحساب',
        'lead_p' => 'سنراجع أرقامك ونرسل لك تقييماً مجانياً للعقار ونوضح لك أنسب وقت للبيع من حيث التكلفة.',
        'ok' => 'شكراً لك! سنتواصل معك قريباً.', 'err' => 'حدث خطأ. يرجى المحاولة مرة أخرى أو مراسلتنا عبر واتساب.',
        'need' => 'يرجى إدخال اسمك وبريدك الإلكتروني أو رقم هاتفك.', 'sending' => 'جارٍ الإرسال…',
        'name' => 'الاسم الكامل', 'email' => 'البريد الإلكتروني', 'phone' => 'الهاتف / واتساب', 'send' => 'إرسال',
        'privacy' => 'نستخدم بياناتك فقط للرد على طلبك.',
        'show_calc' => 'اعرض الحساب كاملاً',
        'note' => 'تقدير للمعلومات فقط وليس استشارة ضريبية. يؤكد مكتب الضرائب أو المحاسب المبلغ النهائي.',
        'how_h' => 'كيف تُحسب الضريبة',
        'how_p' => 'تفرض تركيا ضريبة على الربح من بيع عقار خلال خمس سنوات من تملّكه (قانون ضريبة الدخل، المادة 80 المكررة). يُجرى الحساب دائماً بالليرة التركية، مع تعديل تكلفة الشراء وفق التضخم:',
        'steps' => [
            ['التحويل إلى الليرة بالتواريخ الصحيحة', 'سعر الشراء بسعر صرف يوم الشراء، وسعر البيع بسعر صرف يوم البيع.'],
            ['تعديل تكلفة الشراء', 'تُضرب في نسبة مؤشر Yİ-ÜFE للشهر السابق للبيع إلى مؤشر الشهر السابق للشراء، إذا بلغت الزيادة 10% أو أكثر.'],
            ['خصم تكاليف البيع', 'رسوم الطابو على البائع (2%) وتكاليف البيع الأخرى الموثقة.'],
            ['صافي الربح', 'سعر البيع ناقص التكلفة المعدّلة ناقص التكاليف. إذا كان صفراً أو أقل فلا ضريبة.'],
            ['الإعفاء السنوي', '150,000 ليرة للمبيعات في 2026، مرة واحدة في السنة لكل أرباحك العقارية.'],
            ['الضريبة التصاعدية', 'جدول ضريبة الدخل لغير الأجور لسنة البيع، من 15% إلى 40%.'],
        ],
        'rates_h' => 'شرائح 2026', 'th_gain' => 'الربح الخاضع للضريبة، 2026 (₺)', 'th_rate' => 'النسبة', 'upto' => 'حتى', 'above' => 'أكثر من',
        'tariff_src' => 'جدول ضريبة الدخل لغير الأجور لعام 2026 (البيان العام رقم 332). أرباح بيع العقار ليست دخل أجور، لذا لا تنطبق عليها شريحة 27% الأوسع الخاصة بالأجور.',
        'th_year' => 'سنة البيع', 'th_ex' => 'الإعفاء السنوي',
        'rules' => [
            ['5 سنوات = لا ضريبة', 'إذا بعت بعد خمس سنوات أو أكثر من التاريخ المسجل في الطابو فلا ضريبة على الربح مهما بلغ.'],
            ['ميراث أو هبة', 'العقار الذي حصلت عليه دون مقابل (بالميراث أو الهبة) لا يخضع لهذه الضريبة حتى لو بِيع خلال خمس سنوات.'],
            ['التصريح في مارس', 'يُصرَّح بالربح الخاضع للضريبة في إقرار ضريبة الدخل في مارس من السنة التالية للبيع، ويُدفع على قسطين.'],
        ],
        'faq_h' => 'أسئلة يطرحها البائعون',
        'faq' => [
            ['هل يدفع الأجانب ضريبة على أرباح بيع العقار في تركيا؟', 'نعم، إذا بيع العقار خلال 5 سنوات من تملّكه وكان الربح بعد تعديله وفق التضخم أعلى من الإعفاء السنوي (150,000 ليرة للمبيعات في 2026). القواعد نفسها تنطبق على المواطنين الأتراك والأجانب. أما العقار المملوك 5 سنوات أو أكثر، والعقار الموروث أو الموهوب، فلا ضريبة على ربحه.'],
            ['ما نسب الضريبة على أرباح العقار في 2026؟', 'أرباح بيع العقار دخل من غير الأجور، لذا يُطبق جدول 2026 لغير الأجور: 15% حتى 190,000 ليرة، و20% حتى 400,000، و27% حتى 1,000,000، و35% حتى 5,300,000، و40% لما يزيد على ذلك.'],
            ['دفعت بالدولار أو اليورو. ماذا أُدخل؟', 'أدخل السعرين بالليرة التركية. حوّل سعر الشراء بسعر الصرف في تاريخ الشراء (أفضل رقم هو السعر المذكور في شهادة شراء العملة من البنك DAB)، وسعر البيع بسعر الصرف في تاريخ البيع. تحويل السعرين بسعر اليوم يعطي نتيجة خاطئة.'],
            ['كيف تُعدَّل تكلفة الشراء وفق التضخم؟', 'تُضرب تكلفة الشراء في نسبة مؤشر أسعار المنتجين المحلي (Yİ-ÜFE) للشهر السابق للبيع إلى مؤشر الشهر السابق للشراء، بشرط أن تبلغ الزيادة 10% على الأقل.'],
            ['حصلت على الجنسية بهذا العقار. هل أبيع بعد 3 سنوات دون ضريبة؟', 'شرط الاحتفاظ 3 سنوات للجنسية وقاعدة السنوات الخمس للضريبة أمران منفصلان. يُسمح بالبيع بين السنة الثالثة والخامسة، لكن الربح المعدّل الذي يتجاوز الإعفاء يخضع للضريبة. استخدم الحاسبة لمقارنة البيع الآن بالانتظار حتى تاريخ السنوات الخمس.'],
            ['هل تتأثر رسوم الطابو بقاعدة السنوات الخمس؟', 'لا. رسوم الطابو (4% من السعر المصرّح به: 2% على البائع و2% على المشتري) رسوم معاملة تُدفع في كل بيع. ويمكن خصم حصة البائع كمصروف عندما يكون الربح خاضعاً للضريبة.'],
        ],
        'sources' => 'المصادر: البيان العام رقم 332 لإدارة الإيرادات (GİB) لجدول 2026 والإعفاء؛ مؤشر Yİ-ÜFE من معهد الإحصاء التركي (TÜİK، أساس 2003=100). آخر تحديث: {upd}.',
        'cta_h' => 'تفكر في البيع؟',
        'cta_p' => 'اعرف القيمة السوقية الحقيقية لعقارك قبل أن تقرر. تقييمنا المجاني يشمل أي مدينة في تركيا.',
        'cta_wa' => 'راسلنا عبر واتساب', 'wa_text' => 'مرحباً لاند إسطنبول، استخدمت حاسبة الضريبة وأرغب في استشارة حول بيع عقاري.',
        'js' => [
            'months' => ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
            'enter_all' => 'أدخل التاريخين والسعرين.', 'order' => 'يجب أن يكون تاريخ البيع بعد تاريخ الشراء.', 'no_ppi' => 'لا يتوفر مؤشر أسعار لهذين التاريخين.',
            'held' => 'مدة التملك: {y} سنة و{m} شهر', 'held0' => 'مدة التملك: {m} شهر', 'free' => 'معفى من {d}',
            'r_gift' => 'العقار الموروث أو الموهوب لا تُفرض ضريبة على ربحه.', 'r_5' => 'مملوك 5 سنوات أو أكثر: الربح معفى.',
            'r_nogain' => 'لا ربح خاضع للضريبة بعد تعديل التضخم وخصم التكاليف.', 'r_below' => 'الربح أقل من إعفاء عام {y} البالغ {x}.',
            'not_pub' => 'نسب عام {y} لم تُنشر بعد؛ استُخدمت أرقام عام {b}.', 'ppi_fb' => 'مؤشر Yİ-ÜFE لشهر {m} لم يُنشر بعد؛ استُخدم آخر شهر متاح.',
            'bd_buy' => 'سعر الشراء', 'bd_sell' => 'سعر البيع', 'bd_ppi' => 'Yİ-ÜFE من {a} إلى {b}', 'bd_na' => ' (أقل من 10%: لا يُطبق)',
            'bd_idx' => 'تكلفة الشراء المعدّلة', 'bd_deed' => 'رسوم الطابو على البائع (2%)', 'bd_other' => 'تكاليف بيع أخرى',
            'bd_net' => 'صافي الربح', 'bd_ex' => 'الإعفاء السنوي ({y})', 'bd_base' => 'الوعاء الخاضع للضريبة', 'bd_on' => 'ضريبة على {s} بنسبة {r}%', 'bd_tax' => 'الضريبة المقدّرة',
            'eff' => 'النسبة الفعلية {p}% من صافي ربحك',
            'save' => 'إذا بعت في <b>{d}</b> أو بعده{w} تصبح هذه الضريبة <b>صفراً</b>: توفير يقارب <b>{x}</b>.',
            'wait1' => '', 'waitN' => '',
            'no_tax' => 'لا ضريبة', 'no_due' => 'لا ضريبة مستحقة.',
            'sum_h' => 'تقدير ضريبة أرباح بيع العقار', 'sum_buy' => 'الشراء', 'sum_sell' => 'البيع', 'sum_tax' => 'الضريبة المقدّرة',
            'sum_deed' => 'رسوم الطابو على البائع', 'sum_free' => 'معفى من', 'sum_gift' => ' (ميراث/هبة)',
        ],
    ];
    $ru = [
        'locale' => 'ru_RU', 'date_locale' => 'ru-RU', 'num_locale' => 'ru-RU', 'lang_name' => 'Русский',
        'title' => 'Калькулятор налога с продажи недвижимости в Турции 2026 | Land Istanbul',
        'desc' => 'Бесплатный калькулятор 2026 года: налог на прирост капитала при продаже недвижимости в Турции. Официальный метод GİB: индексация по индексу цен производителей, льгота ₺150 000, налоговая шкала; все суммы в турецких лирах.',
        'og_title' => 'Калькулятор налога с продажи недвижимости в Турции 2026',
        'og_desc' => 'Продаёте недвижимость в Турции? За 30 секунд узнайте, нужно ли платить налог, сколько и с какой даты продажа освобождается от налога.',
        'app' => 'Калькулятор налога с продажи недвижимости в Турции',
        'nav' => ['Главная', 'Услуги', 'Бесплатная оценка', 'Налоговый калькулятор', 'Блог', 'Связаться'],
        'crumb_home' => 'Главная', 'crumb' => 'Налоговый калькулятор',
        'h1' => 'Калькулятор налога с продажи недвижимости в Турции 2026',
        'lead' => 'Продаёте квартиру, виллу или землю в Турции? За 30 секунд узнайте, нужно ли платить налог, сколько и с какой даты продажа освобождается от налога. Вводите цены в турецких лирах, как они указаны в тапу и договоре купли-продажи.',
        'badges' => ['Официальный метод GİB', 'Индекс Yİ-ÜFE: <b id="ppi-latest"></b>', 'Льгота 2026: <b>₺150 000</b>', 'Все суммы в турецких лирах'],
        'your_sale' => 'Ваша продажа', 'example' => 'Пример: замените цифры на свои', 'yours' => 'Ваши данные',
        'how' => 'Как вы получили объект?', 'bought' => 'Купил(а)', 'gift' => 'Наследство или дарение',
        'd1' => 'Дата покупки (по тапу)', 'd2' => 'Дата продажи', 'buy' => 'Цена покупки (₺)', 'sell' => 'Цена продажи (₺)',
        'fx_hint' => 'Платили в долларах или евро? Пересчитайте по курсу на ту дату (он указан в банковской справке об обмене валюты, DAB), а не по сегодняшнему курсу.',
        'more' => '+ Добавить вычитаемые расходы (необязательно)', 'exp' => 'Другие подтверждённые расходы на продажу (₺)',
        'exp_hint' => 'Комиссия агента, услуги нотариуса и юриста по сделке, улучшения по счетам. Сбор продавца за тапу (2%) учитывается автоматически.',
        'res_label' => 'Расчётный налог на прирост капитала', 'enter' => 'Введите свои данные.', 'rule5' => 'Правило 5 лет',
        'deed' => 'Сбор продавца за тапу (2%)', 'keep' => 'Остаётся вам после налога и сбора',
        'btn_val' => 'Бесплатная оценка', 'btn_send' => 'Отправить мне результат', 'btn_copy' => 'Скопировать', 'copied' => 'Скопировано',
        'lead_h' => 'Проверим этот расчёт',
        'lead_p' => 'Мы проверим ваши цифры, бесплатно оценим объект и подскажем, когда продавать выгоднее всего.',
        'ok' => 'Спасибо! Мы скоро свяжемся с вами.', 'err' => 'Произошла ошибка. Попробуйте ещё раз или напишите нам в WhatsApp.',
        'need' => 'Укажите имя и email или телефон.', 'sending' => 'Отправка…',
        'name' => 'Имя и фамилия', 'email' => 'Эл. почта', 'phone' => 'Телефон / WhatsApp', 'send' => 'Отправить',
        'privacy' => 'Ваши данные используются только для ответа на ваш запрос.',
        'show_calc' => 'Показать полный расчёт',
        'note' => 'Ориентировочный расчёт, не налоговая консультация. Окончательную сумму подтверждает налоговая инспекция или бухгалтер.',
        'how_h' => 'Как рассчитывается налог',
        'how_p' => 'Турция облагает налогом доход от продажи недвижимости, проданной в течение пяти лет после приобретения (Закон о подоходном налоге, повторная статья 80). Расчёт всегда ведётся в турецких лирах, а стоимость покупки индексируется с учётом инфляции:',
        'steps' => [
            ['Пересчёт в лиры на нужные даты', 'Цена покупки по курсу на дату покупки, цена продажи по курсу на дату продажи.'],
            ['Индексация стоимости покупки', 'Умножается на отношение индекса Yİ-ÜFE за месяц перед продажей к индексу за месяц перед покупкой, если рост составил 10% и более.'],
            ['Вычет расходов на продажу', 'Сбор продавца за тапу (2%) и другие подтверждённые расходы на сделку.'],
            ['Чистый доход', 'Цена продажи минус индексированная стоимость минус расходы. Ноль или меньше означает, что налога нет.'],
            ['Годовая льгота', '₺150 000 для продаж в 2026 году, один раз в календарный год на все доходы от недвижимости.'],
            ['Прогрессивный налог', 'Шкала налога на доходы, не являющиеся заработной платой, за год продажи: от 15% до 40%.'],
        ],
        'rates_h' => 'Ставки 2026 года', 'th_gain' => 'Облагаемый доход, 2026 (₺)', 'th_rate' => 'Ставка', 'upto' => 'До', 'above' => 'Свыше',
        'tariff_src' => 'Шкала налога на доходы, не являющиеся заработной платой, на 2026 год (Общее сообщение № 332). Доход от продажи недвижимости не является зарплатой, поэтому более широкая зарплатная ступень 27% к нему не применяется.',
        'th_year' => 'Год продажи', 'th_ex' => 'Годовая льгота',
        'rules' => [
            ['5 лет = без налога', 'Если продать через пять лет или позже после даты в тапу, доход не облагается налогом независимо от суммы.'],
            ['Наследство или дарение', 'Недвижимость, полученная безвозмездно (по наследству или в дар), этим налогом не облагается, даже если продана в течение пяти лет.'],
            ['Декларация в марте', 'Облагаемый доход декларируется в марте следующего года после продажи, а налог уплачивается двумя частями.'],
        ],
        'faq_h' => 'Частые вопросы продавцов',
        'faq' => [
            ['Платят ли иностранцы налог при продаже недвижимости в Турции?', 'Да, если объект продан в течение 5 лет после приобретения и доход с учётом индексации превышает годовую льготу (₺150 000 для продаж в 2026 году). Правила одинаковы для граждан Турции и иностранцев. Доход от объекта, которым владели 5 лет и дольше, а также от полученного по наследству или в дар, налогом не облагается.'],
            ['Какие ставки действуют в 2026 году?', 'Доход от продажи недвижимости не является заработной платой, поэтому применяется шкала 2026 года для таких доходов: 15% до ₺190 000, 20% до ₺400 000, 27% до ₺1 000 000, 35% до ₺5 300 000 и 40% свыше.'],
            ['Я платил(а) в долларах или евро. Что вводить?', 'Введите обе цены в турецких лирах. Цену покупки пересчитайте по курсу на дату покупки (лучше всего взять курс из банковской справки об обмене валюты, DAB), а цену продажи по курсу на дату продажи. Пересчёт обеих сумм по сегодняшнему курсу даёт неверный результат.'],
            ['Как индексируется цена покупки?', 'Стоимость покупки умножается на отношение индекса цен производителей (Yİ-ÜFE) за месяц перед продажей к индексу за месяц перед покупкой, если рост составил не менее 10%.'],
            ['Я получил(а) гражданство с этим объектом. Можно продать через 3 года без налога?', 'Трёхлетний запрет на продажу для гражданства и пятилетнее налоговое правило не связаны. Продавать на 3–5 году можно, но индексированный доход сверх льготы облагается налогом. Сравните в калькуляторе продажу сейчас и после пятилетней даты.'],
            ['Зависит ли сбор за тапу от правила 5 лет?', 'Нет. Сбор за тапу (4% от заявленной цены: 2% платит продавец и 2% покупатель) уплачивается при каждой сделке. Долю продавца можно вычесть как расход, если доход облагается налогом.'],
        ],
        'sources' => 'Источники: Общее сообщение № 332 Налогового управления Турции (GİB) — шкала и льгота на 2026 год; индекс Yİ-ÜFE Турецкого статистического института (TÜİK, 2003=100). Обновлено: {upd}.',
        'cta_h' => 'Думаете о продаже?',
        'cta_p' => 'Узнайте реальную рыночную стоимость объекта до принятия решения. Бесплатно оцениваем недвижимость в любом городе Турции.',
        'cta_wa' => 'Написать в WhatsApp', 'wa_text' => 'Здравствуйте, Land Istanbul! Я воспользовался(ась) налоговым калькулятором и хочу получить консультацию по продаже.',
        'js' => [
            'months' => ['январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь'],
            'enter_all' => 'Введите даты и обе цены.', 'order' => 'Дата продажи должна быть позже даты покупки.', 'no_ppi' => 'Нет индекса цен для этих дат.',
            'held' => 'Владение: {y} г. {m} мес.', 'held0' => 'Владение: {m} мес.', 'free' => 'Без налога с {d}',
            'r_gift' => 'Доход от унаследованной или подаренной недвижимости налогом не облагается.', 'r_5' => 'Владение 5 лет и более: доход освобождён от налога.',
            'r_nogain' => 'После индексации и вычета расходов облагаемого дохода нет.', 'r_below' => 'Доход ниже льготы {y} года ({x}).',
            'not_pub' => 'Ставки на {y} год ещё не опубликованы; использованы данные {b} года.', 'ppi_fb' => 'Индекс Yİ-ÜFE за {m} ещё не опубликован; использован последний доступный месяц.',
            'bd_buy' => 'Цена покупки', 'bd_sell' => 'Цена продажи', 'bd_ppi' => 'Yİ-ÜFE: {a} → {b}', 'bd_na' => ' (меньше 10%: не применяется)',
            'bd_idx' => 'Индексированная стоимость покупки', 'bd_deed' => 'Сбор продавца за тапу (2%)', 'bd_other' => 'Другие расходы на продажу',
            'bd_net' => 'Чистый доход', 'bd_ex' => 'Годовая льгота ({y})', 'bd_base' => 'Налоговая база', 'bd_on' => 'Налог с {s} по ставке {r}%', 'bd_tax' => 'Расчётный налог',
            'eff' => 'Эффективная ставка {p}% от чистого дохода',
            'save' => 'Если продать <b>{d}</b> или позже{w}, налог будет <b>нулевым</b>: экономия около <b>{x}</b>.',
            'wait1' => ' (через {n} мес.)', 'waitN' => ' (через {n} мес.)',
            'no_tax' => 'Налога нет', 'no_due' => 'Налог не начисляется.',
            'sum_h' => 'Расчёт налога с продажи недвижимости', 'sum_buy' => 'Покупка', 'sum_sell' => 'Продажа', 'sum_tax' => 'Расчётный налог',
            'sum_deed' => 'Сбор продавца за тапу', 'sum_free' => 'Без налога с', 'sum_gift' => ' (наследство/дарение)',
        ],
    ];
    $all = ['en' => $en, 'ar' => $ar, 'ru' => $ru];
    return $all[$lang] ?? $en;
}

function tc_num($n, $lang) {
    return $lang === 'ru' ? number_format($n, 0, ',', ' ') : number_format($n, 0, '.', ',');
}

function build_taxcalc_page_html($lang, array $data) {
    $t = tc_t($lang);
    $h = function ($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); };
    $url = tc_url($lang);
    $rtl = $lang === 'ar';
    $val = tc_loc('/free-property-valuation/', $lang);
    $blog = tc_loc('/blog/', $lang);
    $wa = 'https://wa.me/905468916349?text=' . rawurlencode($t['wa_text']);
    $sub = ['data' => ['yiufe' => $data['yiufe'], 'exemptions' => $data['exemptions'], 'brackets' => $data['brackets'], 'updated' => $data['updated']]];

    $faqSchema = [];
    foreach ($t['faq'] as $f) $faqSchema[] = ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]];
    $schema = ['@context' => 'https://schema.org', '@graph' => [
        ['@type' => 'WebApplication', 'name' => $t['app'], 'url' => $url, 'applicationCategory' => 'FinanceApplication', 'operatingSystem' => 'All',
         'isAccessibleForFree' => true, 'inLanguage' => $lang, 'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'TRY'],
         'publisher' => ['@type' => 'RealEstateAgent', 'name' => 'Land Istanbul', 'url' => 'https://landistanbul.com/', 'logo' => 'https://landistanbul.com/logo.png']],
        ['@type' => 'BreadcrumbList', 'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => $t['crumb_home'], 'item' => 'https://landistanbul.com/'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => $t['crumb'], 'item' => $url]]],
        ['@type' => 'FAQPage', 'mainEntity' => $faqSchema],
    ]];
    $J = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG;

    $o = '<!doctype html>' . "\n" . '<html lang="' . $lang . '"' . ($rtl ? ' dir="rtl"' : '') . '>' . "\n<head>\n";
    $o .= '<script async src="https://www.googletagmanager.com/gtag/js?id=G-168L11FS04"></script>' . "\n";
    $o .= "<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','G-168L11FS04');</script>\n";
    $o .= '<meta charset="UTF-8" />' . "\n" . '<meta name="viewport" content="width=device-width, initial-scale=1.0" />' . "\n";
    $o .= '<title>' . $h($t['title']) . "</title>\n";
    $o .= '<meta name="description" content="' . $h($t['desc']) . '" />' . "\n";
    $o .= '<link rel="canonical" href="' . $url . '" />' . "\n";
    foreach (['en', 'ar', 'ru'] as $l) $o .= '<link rel="alternate" hreflang="' . $l . '" href="' . tc_url($l) . '" />' . "\n";
    $o .= '<link rel="alternate" hreflang="x-default" href="' . tc_url('en') . '" />' . "\n";
    $o .= '<meta name="robots" content="index, follow, max-image-preview:large" />' . "\n";
    $o .= '<link rel="icon" href="/favicon.ico" sizes="any"><link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png"><link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">' . "\n";
    $o .= '<meta property="og:type" content="website" /><meta property="og:site_name" content="Land Istanbul" />' . "\n";
    $o .= '<meta property="og:title" content="' . $h($t['og_title']) . '" /><meta property="og:description" content="' . $h($t['og_desc']) . '" />' . "\n";
    $o .= '<meta property="og:url" content="' . $url . '" /><meta property="og:image" content="https://landistanbul.com/og-image.png" /><meta property="og:locale" content="' . $t['locale'] . '" />' . "\n";
    $o .= '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    $o .= '<script type="application/ld+json">' . json_encode($schema, $J) . "</script>\n";
    $o .= '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    $o .= '<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;500;700;900' . ($rtl ? '&family=Cairo:wght@400;600;700;900' : '') . '&display=swap" rel="stylesheet">' . "\n";
    $o .= '<link rel="stylesheet" href="' . tc_asset('site-boost.css') . '">' . "\n<style>" . tc_css() . "</style>\n</head>\n<body>\n";

    // navigation
    $links = [['/', $t['nav'][0], ''], ['/#services', $t['nav'][1], ''], [$val, $t['nav'][2], 'nav-val'], [tc_path($lang), $t['nav'][3], 'active'], [$blog, $t['nav'][4], ''], ['/#contact', $t['nav'][5], 'nav-btn']];
    $o .= '<div id="mobile-menu">';
    foreach ($links as $l) $o .= '<a href="' . $h($l[0]) . '">' . $h($l[1]) . '</a>';
    $o .= "</div>\n<nav class=\"top\"><a class=\"logo\" href=\"/\" aria-label=\"Land Istanbul by Math Investment\">" . tc_logo() . "</a><div class=\"nav-links\">";
    foreach ($links as $l) $o .= '<a href="' . $h($l[0]) . '"' . ($l[2] ? ' class="' . $l[2] . '"' : '') . '>' . $h($l[1]) . '</a>';
    $o .= "</div><button class=\"menu-toggle\" onclick=\"document.getElementById('mobile-menu').classList.toggle('open')\" aria-label=\"Menu\"><span></span><span></span><span></span></button></nav>\n";

    // hero
    $o .= '<header class="hero"><div class="wrap"><div class="top-row"><div class="crumbs"><a href="/">' . $h($t['crumb_home']) . '</a> / ' . $h($t['crumb']) . '</div><div class="langs">';
    foreach (['en', 'ar', 'ru'] as $l) {
        $name = tc_t($l)['lang_name'];
        $o .= $l === $lang ? '<span>' . $h($name) . '</span>' : '<a href="' . tc_path($l) . '" hreflang="' . $l . '">' . $h($name) . '</a>';
    }
    $o .= '</div></div><h1>' . $h($t['h1']) . '</h1><p class="lead">' . $h($t['lead']) . '</p><div class="badges">';
    foreach ($t['badges'] as $b) $o .= '<span class="badge">' . $b . '</span>';
    $o .= "</div></div></header>\n";

    // calculator
    $o .= '<section class="calc" id="calculator"><div class="wrap calc-grid"><div class="panel">';
    $o .= '<div class="panel-h"><h2>' . $h($t['your_sale']) . '</h2><small id="example-flag">' . $h($t['example']) . '</small></div><div class="form">';
    $o .= '<div class="fgroup"><span class="lbl">' . $h($t['how']) . '</span><div class="seg" role="group"><button type="button" class="on" data-acq="buy">' . $h($t['bought']) . '</button><button type="button" data-acq="gift">' . $h($t['gift']) . '</button></div></div>';
    $o .= '<div class="row2"><div class="fgroup"><label for="d1">' . $h($t['d1']) . '</label><input type="date" id="d1"></div><div class="fgroup"><label for="d2">' . $h($t['d2']) . '</label><input type="date" id="d2"></div></div>';
    $o .= '<div class="fgroup"><label for="buy">' . $h($t['buy']) . '</label><div class="money"><span>₺</span><input id="buy" dir="ltr" inputmode="numeric" autocomplete="off"></div></div>';
    $o .= '<div class="fgroup"><label for="sell">' . $h($t['sell']) . '</label><div class="money"><span>₺</span><input id="sell" dir="ltr" inputmode="numeric" autocomplete="off"></div><div class="hint">' . $h($t['fx_hint']) . '</div></div>';
    $o .= '<details class="more"><summary>' . $h($t['more']) . '</summary><div class="fgroup"><label for="exp">' . $h($t['exp']) . '</label><div class="money"><span>₺</span><input id="exp" dir="ltr" inputmode="numeric" autocomplete="off" value="0"></div><div class="hint">' . $h($t['exp_hint']) . '</div></div></details>';
    $o .= '</div></div>';

    $o .= '<div class="panel result" aria-live="polite"><div class="res-top"><div class="res-label">' . $h($t['res_label']) . '</div><div class="res-big" id="res-big">—</div><div class="res-sub" id="res-sub">' . $h($t['enter']) . '</div></div>';
    $o .= '<div class="hold"><div class="res-label">' . $h($t['rule5']) . '</div><div class="bar" id="bar"><i id="bar-fill" style="width:0"></i></div><div class="bar-legend"><span id="held">—</span><span id="free-date">—</span></div><div class="save" id="save" hidden></div></div>';
    $o .= '<div class="net"><div><span>' . $h($t['deed']) . '</span><strong id="deed">—</strong></div><div><span>' . $h($t['keep']) . '</span><strong id="keep">—</strong></div></div>';
    $o .= '<div class="res-actions"><a class="btn btn-red" href="' . $val . '" data-track="calc_valuation">' . $h($t['btn_val']) . '</a><button class="btn btn-line" type="button" id="send-btn">' . $h($t['btn_send']) . '</button><button class="btn btn-line" type="button" id="copy-btn">' . $h($t['btn_copy']) . '</button></div>';
    $o .= '<div class="lead-box" id="lead-box"><h3>' . $h($t['lead_h']) . '</h3><p>' . $h($t['lead_p']) . '</p>';
    $o .= '<form class="li-lead-form" method="post" action="/mail.php" novalidate data-ok="' . $h($t['ok']) . '" data-err="' . $h($t['err']) . '" data-need="' . $h($t['need']) . '" data-sending="' . $h($t['sending']) . '">';
    $o .= '<input type="hidden" name="source" value="' . $url . '"><input type="hidden" name="lang" value="' . $lang . '"><input type="hidden" name="interest" value="Selling my property in Turkey"><input type="hidden" name="p_calculation" id="p-calc" value="">';
    $o .= '<div class="li-hp" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>';
    $o .= '<input type="text" name="name" placeholder="' . $h($t['name']) . '" aria-label="' . $h($t['name']) . '" autocomplete="name">';
    $o .= '<div class="row2"><input type="email" name="email" dir="ltr" placeholder="' . $h($t['email']) . '" aria-label="' . $h($t['email']) . '" autocomplete="email"><input type="tel" name="phone" dir="ltr" placeholder="' . $h($t['phone']) . '" aria-label="' . $h($t['phone']) . '" autocomplete="tel"></div>';
    $o .= '<button type="submit" class="li-submit">' . $h($t['send']) . '</button><p class="li-status" role="status"></p><p class="li-privacy">' . $h($t['privacy']) . '</p></form></div>';
    $o .= '<details class="breakdown"><summary>' . $h($t['show_calc']) . '</summary><div id="bd"></div></details><p class="note" id="note">' . $h($t['note']) . '</p></div>';
    $o .= "</div></section>\n";

    // how it works
    $o .= '<section class="band"><div class="wrap"><h2>' . $h($t['how_h']) . '</h2><p>' . $h($t['how_p']) . '</p><ol class="steps">';
    foreach ($t['steps'] as $s) $o .= '<li><b>' . $h($s[0]) . '</b>' . $h($s[1]) . '</li>';
    $o .= "</ol></div></section>\n";

    // rates
    $br = $data['brackets']['2026'];
    $o .= '<section class="band alt"><div class="wrap"><h2>' . $h($t['rates_h']) . '</h2><div class="tables"><div><table><thead><tr><th>' . $h($t['th_gain']) . '</th><th>' . $h($t['th_rate']) . '</th></tr></thead><tbody>';
    $lower = 0;
    foreach ($br as $i => $b) {
        if ($i === 0) $label = $t['upto'] . ' ' . tc_num($b[0], $lang);
        elseif ($b[0] === null) $label = $t['above'] . ' ' . tc_num($lower, $lang);
        else $label = tc_num($lower + 1, $lang) . ' – ' . tc_num($b[0], $lang);
        $o .= '<tr><td><bdi>' . $h($label) . '</bdi></td><td class="n">' . round($b[1] * 100) . '%</td></tr>';
        if ($b[0] !== null) $lower = $b[0];
    }
    $o .= '</tbody></table><p class="src">' . $h($t['tariff_src']) . '</p></div><div><table><thead><tr><th>' . $h($t['th_year']) . '</th><th>' . $h($t['th_ex']) . '</th></tr></thead><tbody>';
    $years = array_keys($data['exemptions']);
    rsort($years);
    foreach (array_slice($years, 0, 5) as $y) $o .= '<tr><td>' . $y . '</td><td class="n" dir="ltr">₺' . tc_num($data['exemptions'][$y], $lang) . '</td></tr>';
    $o .= '</tbody></table></div></div><div class="rules">';
    foreach ($t['rules'] as $r) $o .= '<div class="rule"><h3>' . $h($r[0]) . '</h3><p>' . $h($r[1]) . '</p></div>';
    $o .= "</div></div></section>\n";

    // faq
    $o .= '<section class="band faq"><div class="wrap"><h2>' . $h($t['faq_h']) . '</h2>';
    foreach ($t['faq'] as $f) $o .= '<details><summary>' . $h($f[0]) . '</summary><p>' . $h($f[1]) . '</p></details>';
    $o .= '<p class="src">' . str_replace('{upd}', '<span id="upd"></span>', $h($t['sources'])) . "</p></div></section>\n";

    // cta
    $o .= '<section class="cta"><h2>' . $h($t['cta_h']) . '</h2><p>' . $h($t['cta_p']) . '</p><div class="btns"><a class="btn btn-red" href="' . $val . '">' . $h($t['btn_val']) . '</a><a class="btn btn-line btn-ghost" href="' . $h($wa) . '" target="_blank" rel="noopener" data-track="whatsapp">' . $h($t['cta_wa']) . "</a></div></section>\n";
    $o .= '<footer><a class="logo" href="/" aria-label="Land Istanbul by Math Investment">' . tc_logo() . '</a>' . tc_footer_line() . '</footer>' . "\n";

    $cfg = $sub + ['t' => $t['js'], 'dateLocale' => $t['date_locale'], 'numLocale' => $t['num_locale'], 'yours' => $t['yours'], 'copy' => $t['btn_copy'], 'copied' => $t['copied']];
    $o .= '<script>var TC=' . json_encode($cfg, $J) . ";</script>\n<script>" . tc_js() . "</script>\n";
    $o .= '<script src="' . tc_asset('blog-lead.js') . '" defer></script>' . "\n" . '<script src="' . tc_asset('site-boost.js') . '" defer></script>' . "\n</body>\n</html>\n";
    return $o;
}

function write_taxcalc_pages($site, array $data) {
    $n = 0;
    foreach (['en', 'ar', 'ru'] as $lang) {
        $dir = $site . '/tax-calculator' . ($lang === 'en' ? '' : '/' . $lang);
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $file = $dir . '/index.html';
        $html = build_taxcalc_page_html($lang, $data);
        if (!file_exists($file) || md5_file($file) !== md5($html)) {
            $tmp = $file . '.tmp';
            file_put_contents($tmp, $html);
            rename($tmp, $file);
            $n++;
        }
    }
    return $n;
}

function tc_css() {
    return <<<'CSS'
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--first:#fffdef;--second:#f1f1f1;--third:#e70000;--fourth:#c50000;--ink:#171717;--muted:#666;--line:#e6e1d6;--ok:#11734b}
html{scroll-behavior:smooth;scroll-padding-top:90px}
body{font-family:'Roboto Condensed',system-ui,sans-serif;background:var(--second);color:var(--ink);overflow-x:hidden;font-size:16px;line-height:1.55}
a{color:inherit}
nav.top{position:fixed;top:0;width:100%;z-index:100;background:rgba(241,241,241,.9);backdrop-filter:blur(12px);border-bottom:1px solid #e5e5e5;padding:16px 40px;display:flex;justify-content:space-between;align-items:center}
.logo{font-size:1.5rem;font-weight:900;letter-spacing:-.05em;color:var(--fourth);text-decoration:none}
.nav-links{display:flex;gap:26px;align-items:center}
.nav-links a{font-size:.78rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;text-decoration:none;color:var(--ink)}
.nav-links a:hover,.nav-links a.active{color:var(--third)}
.nav-btn{background:var(--third);color:#fff!important;padding:8px 22px}
.menu-toggle{display:none;background:none;border:none;cursor:pointer}
.menu-toggle span{display:block;width:26px;height:2px;background:var(--ink);margin:5px 0}
#mobile-menu{display:none;position:fixed;inset:0;z-index:90;background:var(--first);flex-direction:column;align-items:center;justify-content:center;gap:28px}
#mobile-menu.open{display:flex}
#mobile-menu a{font-size:1.6rem;font-weight:900;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;color:var(--ink)}
@media(max-width:1020px){nav.top{padding:16px 20px}.nav-links{display:none}.menu-toggle{display:block}}
.hero{background:var(--first);padding:112px 40px 36px;border-bottom:1px solid var(--line)}
.wrap{max-width:1180px;margin:0 auto}
.top-row{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:18px}
.crumbs{font-size:.75rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#888}
.crumbs a{text-decoration:none;color:#888}.crumbs a:hover{color:var(--third)}
.langs{display:flex;gap:6px}
.langs a,.langs span{font-size:.85rem;font-weight:700;padding:4px 10px;border:1.5px solid var(--ink);text-decoration:none}
.langs span{background:var(--ink);color:#fff}
.langs a:hover{background:var(--third);border-color:var(--third);color:#fff}
.hero h1{font-size:clamp(2rem,4.4vw,3.6rem);font-weight:900;text-transform:uppercase;letter-spacing:-.025em;line-height:1;max-width:980px}
.hero p.lead{font-size:1.12rem;color:#444;max-width:780px;margin-top:16px}
.badges{display:flex;flex-wrap:wrap;gap:8px;margin-top:18px}
.badge{background:#fff;border:1px solid var(--line);padding:6px 12px;font-size:.82rem;font-weight:700}
.badge b{color:var(--third)}
.calc{padding:28px 40px 56px;background:var(--first)}
.calc-grid{display:grid;grid-template-columns:minmax(0,1.05fr) minmax(0,1fr);gap:24px;align-items:start}
.panel{background:#fff;border:1px solid var(--line);box-shadow:0 10px 30px rgba(0,0,0,.05)}
.panel-h{background:var(--ink);color:#fff;padding:14px 22px;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap}
.panel-h h2{font-size:1.05rem;font-weight:900;text-transform:uppercase;letter-spacing:.04em}
.panel-h small{color:#bbb;font-size:.8rem}
.form{padding:20px 22px 24px}
.fgroup{margin-bottom:16px}
.fgroup>label,.lbl{display:block;font-size:.78rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#555;margin-bottom:6px}
.seg{display:grid;grid-template-columns:1fr 1fr;border:1.5px solid var(--ink)}
.seg button{background:#fff;border:0;padding:11px 8px;font:inherit;font-weight:700;cursor:pointer;color:var(--ink)}
.seg button+button{border-inline-start:1.5px solid var(--ink)}
.seg button.on{background:var(--ink);color:#fff}
.row2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
input{font:inherit;font-size:16px;color:var(--ink);background:#fbfaf6;border:1.5px solid var(--line);padding:11px 12px;width:100%;outline:none;border-radius:0}
input:focus{border-color:var(--fourth);box-shadow:0 0 0 3px rgba(197,0,0,.12)}
.money{display:grid;grid-template-columns:48px minmax(0,1fr)}
.money span{display:flex;align-items:center;justify-content:center;background:#f3f0e8;border:1.5px solid var(--line);border-inline-end:0;font-weight:900;font-size:1.15rem;color:var(--fourth)}
.money input{font-size:18px;font-weight:700}
.hint{font-size:.82rem;color:#777;margin-top:6px}
details.more{margin-top:4px}
details.more summary{cursor:pointer;font-weight:700;font-size:.9rem;color:var(--fourth)}
details.more[open] summary{margin-bottom:10px}
.result{position:sticky;top:86px}
.res-top{padding:22px;border-bottom:1px solid var(--line)}
.res-label{font-size:.78rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#777}
.res-big{font-size:clamp(2.2rem,4.4vw,3.2rem);font-weight:900;line-height:1.05;margin-top:4px;color:var(--fourth);white-space:nowrap}
.res-big.zero{color:var(--ok)}
.res-sub{margin-top:6px;color:#444;font-size:1rem}
.hold{padding:18px 22px;border-bottom:1px solid var(--line)}
.bar{height:12px;background:#eee;position:relative;margin:10px 0 6px}
.bar i{position:absolute;inset-inline-start:0;top:0;bottom:0;background:var(--third);display:block}
.bar.done i{background:var(--ok)}
.bar-legend{display:flex;justify-content:space-between;gap:10px;font-size:.8rem;color:#777}
.save{margin-top:10px;background:#eaf7f0;border-inline-start:4px solid var(--ok);padding:10px 12px;font-size:.95rem}
.save b{color:var(--ok)}
.net{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--line);border-bottom:1px solid var(--line)}
.net div{background:#fff;padding:14px 22px}
.net span{display:block;font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#777}
.net strong{font-size:1.25rem;white-space:nowrap}
.res-actions{padding:16px 22px;display:flex;gap:10px;flex-wrap:wrap}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:44px;padding:11px 18px;font:inherit;font-weight:700;font-size:.85rem;letter-spacing:.08em;text-transform:uppercase;text-decoration:none;border:0;cursor:pointer}
.btn-red{background:var(--third);color:#fff}.btn-red:hover{background:var(--fourth)}
.btn-line{background:#fff;color:var(--ink);border:1.5px solid var(--ink)}
.btn-ghost{background:transparent;color:#fff;border-color:#fff}
.breakdown{padding:0 22px 18px}
.breakdown summary{cursor:pointer;font-weight:700;padding:12px 0;color:var(--ink)}
.bd-row{display:flex;justify-content:space-between;gap:12px;padding:8px 0;border-bottom:1px solid #f0ede5;font-size:.95rem}
.bd-row span:first-child{color:#555}
.bd-row span:last-child{font-weight:700;text-align:end;white-space:nowrap;direction:ltr;unicode-bidi:isolate}
.bd-row.total span{color:var(--fourth)!important;font-size:1.05rem}
.note{font-size:.82rem;color:#777;padding:0 22px 18px}
.lead-box{background:var(--fourth);color:#fff;padding:22px;display:none}
.lead-box.show{display:block}
.lead-box h3{font-size:1.3rem;font-weight:900;text-transform:uppercase;line-height:1.1}
.lead-box p{color:rgba(255,255,255,.85);margin:6px 0 14px;font-size:.98rem}
.lead-box input{background:#fff;border:0;margin-bottom:10px}
.lead-box .row2{gap:10px}
.lead-box .li-submit{background:var(--ink);color:#fff;border:0;min-height:46px;padding:12px 20px;font:inherit;font-weight:700;letter-spacing:.1em;text-transform:uppercase;cursor:pointer;width:100%}
.lead-box .li-status{margin-top:10px;font-weight:700}
.lead-box .li-status.is-ok{background:#11734b;padding:10px}
.lead-box .li-status.is-error{background:#222;padding:10px}
.lead-box .li-privacy{font-size:.78rem;color:rgba(255,255,255,.75);margin-top:8px}
.li-hp{position:absolute!important;width:1px!important;height:1px!important;overflow:hidden!important;clip:rect(0 0 0 0);opacity:0}
.band{padding:clamp(40px,5vw,72px) 40px;background:#fff;border-top:1px solid #ececec}
.band.alt{background:var(--second)}
.band h2{font-size:clamp(1.6rem,3vw,2.4rem);font-weight:900;text-transform:uppercase;letter-spacing:-.02em;line-height:1.05;margin-bottom:14px}
.band p{color:#444;max-width:820px;margin-bottom:12px}
.steps{list-style:none;counter-reset:s;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;margin-top:18px}
.steps li{counter-increment:s;background:var(--first);border-inline-start:4px solid var(--third);padding-block:14px;padding-inline:56px 16px;position:relative}
.steps li::before{content:counter(s);position:absolute;inset-inline-start:14px;top:14px;width:28px;height:28px;background:var(--third);color:#fff;font-weight:900;display:flex;align-items:center;justify-content:center}
.steps b{display:block}
.tables{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:24px;margin-top:10px}
table{width:100%;border-collapse:collapse;background:#fff;font-size:.98rem}
th,td{padding:11px 14px;border-bottom:1px solid #eee;text-align:start}
th{background:var(--ink);color:#fff;font-size:.78rem;letter-spacing:.1em;text-transform:uppercase}
td.n{text-align:end;font-weight:700;white-space:nowrap}
.rules{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;margin-top:16px}
.rule{background:#fff;padding:18px;border-top:4px solid var(--third)}
.rule h3{font-size:1.1rem;font-weight:900;text-transform:uppercase;margin-bottom:6px}
.rule p{font-size:.95rem;margin:0}
.faq details{background:#fff;border-inline-start:4px solid var(--third);margin-bottom:10px}
.faq summary{cursor:pointer;padding:15px 18px;font-weight:700;font-size:1.02rem}
.faq details p{padding:0 18px 16px;margin:0}
.cta{background:var(--ink);color:#fff;text-align:center;padding:64px 24px}
.cta h2{font-size:clamp(1.7rem,3.4vw,2.6rem);font-weight:900;text-transform:uppercase;line-height:1.05}
.cta p{color:#bbb;max-width:640px;margin:12px auto 24px}
.cta .btns{display:flex;gap:12px;justify-content:center;flex-wrap:wrap}
footer{background:#0a0a0a;color:#fff;padding:40px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px}
footer p{color:#777;font-size:.85rem}
.src{font-size:.85rem;color:#777;margin-top:14px}
[dir=rtl] body,[dir=rtl] input,[dir=rtl] button{font-family:'Cairo','Roboto Condensed',system-ui,sans-serif}
[dir=rtl] h1,[dir=rtl] h2,[dir=rtl] h3,[dir=rtl] .lbl,[dir=rtl] .fgroup>label,[dir=rtl] .res-label,[dir=rtl] .net span,[dir=rtl] .btn,[dir=rtl] th,[dir=rtl] .crumbs,[dir=rtl] .nav-links a,[dir=rtl] #mobile-menu a{letter-spacing:0;text-transform:none}
[dir=rtl] .hero h1{line-height:1.25}
[dir=rtl] .band h2,[dir=rtl] .cta h2{line-height:1.3}
@media(max-width:980px){.calc-grid{grid-template-columns:minmax(0,1fr)}.result{position:static}.rules{grid-template-columns:minmax(0,1fr)}}
@media(max-width:700px){.hero{padding:96px 18px 26px}.calc{padding:18px 12px 40px}.band{padding:40px 18px}.row2,.steps,.tables{grid-template-columns:minmax(0,1fr)}.net{grid-template-columns:1fr}footer{flex-direction:column;text-align:center}}
CSS;
}

function tc_js() {
    return <<<'JS'
(function(){
  var $ = function(id){ return document.getElementById(id); };
  var D = TC.data, T = TC.t;
  function fmt0(n){ return Math.round(n).toLocaleString(TC.numLocale); }
  function money(v){ return '₺' + fmt0(v); }
  function tr(s, o){ return s.replace(/\{(\w+)\}/g, function(m, k){ return o[k] !== undefined ? o[k] : m; }); }
  function parseAmt(s){ var n = parseFloat(String(s || '').replace(/[^\d]/g, '')); return isNaN(n) ? 0 : n; }
  function ym(d){ return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0'); }
  function prevYm(d){ return ym(new Date(d.getFullYear(), d.getMonth() - 1, 1)); }
  function monthName(k){ var p = k.split('-'); return T.months[+p[1] - 1] + ' ' + p[0]; }
  function fmtDate(d){ try { return d.toLocaleDateString(TC.dateLocale, { day: 'numeric', month: 'long', year: 'numeric' }); } catch (e) { return d.toISOString().slice(0, 10); } }
  function bdi(s){ return '<bdi>' + s + '</bdi>'; }
  var acq = 'buy';
  var keys = Object.keys(D.yiufe).sort();
  $('ppi-latest').textContent = monthName(keys[keys.length - 1]);
  $('upd').textContent = monthName(D.updated.slice(0, 7));

  function ppi(k){
    if (D.yiufe[k] !== undefined) return { v: D.yiufe[k], k: k, fb: false };
    var p = k.split('-').map(Number), y = p[0], m = p[1];
    for (var i = 0; i < 24; i++) { m--; if (m < 1) { m = 12; y--; } var kk = y + '-' + String(m).padStart(2, '0'); if (D.yiufe[kk] !== undefined) return { v: D.yiufe[kk], k: kk, fb: true, want: k }; }
    return null;
  }
  function progressive(base, br){
    var tax = 0, lower = 0, parts = [];
    for (var i = 0; i < br.length; i++) {
      var top = br[i][0] === null ? Infinity : br[i][0], rate = br[i][1];
      if (base <= lower) break;
      var slice = Math.min(base, top) - lower;
      if (slice > 0) { tax += slice * rate; parts.push([slice, rate]); }
      lower = top;
    }
    return { tax: tax, parts: parts };
  }
  function addYears(d, n){ var x = new Date(d); x.setFullYear(x.getFullYear() + n); return x; }

  var lastSummary = '';
  function reset(msg){ var big = $('res-big'); big.textContent = '—'; big.className = 'res-big'; $('res-sub').textContent = msg; }
  function calc(){
    var d1 = new Date($('d1').value), d2 = new Date($('d2').value);
    var buy = parseAmt($('buy').value), sell = parseAmt($('sell').value), exp = parseAmt($('exp').value);
    var big = $('res-big'), sub = $('res-sub'), save = $('save');
    save.hidden = true;
    if (isNaN(d1) || isNaN(d2) || !buy || !sell) return reset(T.enter_all);
    if (d2 <= d1) return reset(T.order);

    var held = (d2 - d1) / (365.2425 * 864e5), freeDate = addYears(d1, 5);
    $('bar-fill').style.width = Math.min(100, held / 5 * 100) + '%';
    $('bar').classList.toggle('done', d2 >= freeDate);
    var yrs = Math.floor(held), mos = Math.floor((held - yrs) * 12);
    $('held').textContent = tr(yrs ? T.held : T.held0, { y: yrs, m: mos });
    $('free-date').textContent = tr(T.free, { d: fmtDate(freeDate) });

    var deed = sell * 0.02;
    $('deed').textContent = money(deed);
    var rows = [];
    function row(a, b, cls){ rows.push('<div class="bd-row' + (cls ? ' ' + cls : '') + '"><span>' + a + '</span><span>' + b + '</span></div>'); }
    row(T.bd_buy, money(buy));
    row(T.bd_sell, money(sell));

    var tax = 0, reason = '', net = 0, base = 0, effective = 0, notes = [];
    var saleYear = d2.getFullYear();
    if (acq === 'gift') reason = T.r_gift;
    else if (d2 >= freeDate) reason = T.r_5;
    else {
      var pb = ppi(prevYm(d1)), ps = ppi(prevYm(d2));
      if (!pb || !ps) return reset(T.no_ppi);
      var ratio = ps.v / pb.v, apply = ratio - 1 >= 0.10;
      var adj = apply ? buy * ratio : buy;
      net = sell - adj - deed - exp;
      var exYears = Object.keys(D.exemptions).map(Number), brYears = Object.keys(D.brackets).map(Number);
      var exY = D.exemptions[saleYear] ? saleYear : Math.max.apply(null, exYears);
      var brY = D.brackets[saleYear] ? saleYear : Math.max.apply(null, brYears);
      if (exY !== saleYear || brY !== saleYear) notes.push(tr(T.not_pub, { y: saleYear, b: brY }));
      var ex = D.exemptions[exY];
      base = Math.max(0, net - ex);
      var p = progressive(base, D.brackets[brY]);
      tax = p.tax;
      effective = net > 0 ? tax / net * 100 : 0;
      row(tr(T.bd_ppi, { a: monthName(pb.k), b: monthName(ps.k) }), ratio.toFixed(4) + (apply ? '' : T.bd_na));
      row(T.bd_idx, money(adj));
      row(T.bd_deed, money(deed));
      if (exp) row(T.bd_other, money(exp));
      row(T.bd_net, money(Math.max(0, net)));
      row(tr(T.bd_ex, { y: exY }), '−' + money(ex));
      row(T.bd_base, money(base));
      p.parts.forEach(function(x){ row(tr(T.bd_on, { s: bdi(money(x[0])), r: Math.round(x[1] * 100) }), money(x[0] * x[1])); });
      if (pb.fb || ps.fb) notes.push(tr(T.ppi_fb, { m: [pb, ps].filter(function(x){ return x.fb; }).map(function(x){ return monthName(x.want); }).join(', ') }));
      if (net <= 0) reason = T.r_nogain;
      else if (base <= 0) reason = tr(T.r_below, { y: exY, x: money(ex) });
    }
    row(T.bd_tax, money(tax), 'total');
    $('bd').innerHTML = rows.join('');

    $('keep').textContent = money(sell - tax - deed - exp);
    if (tax > 0) {
      big.className = 'res-big';
      big.textContent = money(tax);
      sub.textContent = tr(T.eff, { p: effective.toLocaleString(TC.numLocale, { minimumFractionDigits: 1, maximumFractionDigits: 1 }) });
      if (freeDate > d2) {
        var months = Math.max(1, Math.round((freeDate - d2) / (30.44 * 864e5)));
        save.hidden = false;
        save.innerHTML = tr(T.save, { d: fmtDate(freeDate), w: tr(months > 1 ? T.waitN : T.wait1, { n: months }), x: bdi(money(tax)) });
      }
    } else {
      big.className = 'res-big zero';
      big.textContent = T.no_tax;
      sub.textContent = reason || T.no_due;
    }
    $('note').textContent = (notes.length ? notes.join(' ') + ' ' : '') + $('note').dataset.base;

    lastSummary = T.sum_h + ' (' + location.href.split('#')[0] + ')\n' +
      T.sum_buy + ': ' + $('d1').value + ', ' + money(buy) + (acq === 'gift' ? T.sum_gift : '') + '\n' +
      T.sum_sell + ': ' + $('d2').value + ', ' + money(sell) + '\n' +
      T.sum_tax + ': ' + money(tax) + (reason && !tax ? ' (' + reason + ')' : '') + '\n' +
      T.sum_deed + ': ' + money(deed) + '\n' + T.sum_free + ': ' + fmtDate(freeDate);
    $('p-calc').value = lastSummary;
  }

  $('note').dataset.base = $('note').textContent;
  $('d2').value = new Date().toISOString().slice(0, 10);
  $('d1').value = '2023-03-15';
  $('buy').value = fmt0(4750000); $('sell').value = fmt0(16000000);
  function touched(){ $('example-flag').textContent = TC.yours; }
  document.querySelectorAll('.seg button').forEach(function(b){ b.addEventListener('click', function(){
    document.querySelectorAll('.seg button').forEach(function(x){ x.classList.toggle('on', x === b); });
    acq = b.dataset.acq; calc();
  }); });
  ['d1', 'd2'].forEach(function(id){ $(id).addEventListener('change', function(){ calc(); touched(); }); });
  ['buy', 'sell', 'exp'].forEach(function(id){
    $(id).addEventListener('input', function(){ calc(); touched(); });
    $(id).addEventListener('blur', function(){ var n = parseAmt($(id).value); $(id).value = n ? fmt0(n) : (id === 'exp' ? '0' : ''); });
  });
  $('send-btn').addEventListener('click', function(){ calc(); $('lead-box').classList.add('show'); $('lead-box').scrollIntoView({ behavior: 'smooth', block: 'center' }); try { gtag('event', 'form_start', { form: 'tax_calculator' }); } catch (e) {} });
  $('copy-btn').addEventListener('click', function(){
    calc();
    try { navigator.clipboard.writeText(lastSummary).then(function(){ $('copy-btn').textContent = TC.copied; setTimeout(function(){ $('copy-btn').textContent = TC.copy; }, 2000); }); } catch (e) {}
  });
  calc();
})();
JS;
}
