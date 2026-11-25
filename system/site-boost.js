/* Land Istanbul — site-wide promotion of the free valuation, citizenship check and tax calculator (v2). */
(function () {
  var lang = (document.documentElement.getAttribute('lang') || 'en').slice(0, 2);
  var T = {
    en: { nav: 'Free Valuation', fab: 'Free valuation', k1: 'Free · any city in Turkey', h1: 'What is your property worth?', p1: 'Get a realistic price range from a local expert, usually within 24 hours. No obligation.', b1: 'Get my free valuation', k2: 'Free tool · 2026 rates', h2: 'Selling? Check your tax first', p2: 'See in 30 seconds whether you owe capital gains tax, how much, and when your sale becomes tax-free.', b2: 'Calculate my tax', k3: 'Free check · 60 seconds', h3: 'Do you qualify for citizenship?', p3: 'Answer 4 questions and see which route fits your budget: citizenship ($400k), residence permit ($200k) or the new $150k investor permit.', b3: 'Check my eligibility', sh: 'Thinking of selling?', sp: 'Find out what your property in Turkey is worth. Free valuation, usually within 24 hours.', sb: 'Get my valuation', close: 'Close' },
    ar: { nav: 'تقييم مجاني', fab: 'تقييم مجاني', k1: 'مجاني · أي مدينة في تركيا', h1: 'كم يساوي عقارك؟', p1: 'احصل على نطاق سعر واقعي من خبير محلي خلال 24 ساعة عادةً، دون أي التزام.', b1: 'احصل على تقييمك المجاني', k2: 'أداة مجانية · أسعار 2026', h2: 'تبيع؟ احسب الضريبة أولاً', p2: 'اعرف خلال 30 ثانية هل عليك ضريبة على أرباح العقار وكم تبلغ ومتى يصبح البيع معفى.', b2: 'احسب الضريبة', k3: 'اختبار مجاني · 60 ثانية', h3: 'هل أنت مؤهل للجنسية؟', p3: 'أجب عن 4 أسئلة واعرف المسار المناسب لميزانيتك: الجنسية (400 ألف دولار)، أو الإقامة (200 ألف)، أو إقامة المستثمر الجديدة (150 ألف).', b3: 'اختبر أهليتك', sh: 'تفكر في البيع؟', sp: 'اعرف كم يساوي عقارك في تركيا. تقييم مجاني خلال 24 ساعة عادةً.', sb: 'احصل على التقييم', close: 'إغلاق' },
    ru: { nav: 'Бесплатная оценка', fab: 'Бесплатная оценка', k1: 'Бесплатно · любой город Турции', h1: 'Сколько стоит ваша недвижимость?', p1: 'Реалистичный диапазон цены от местного эксперта, обычно за 24 часа. Без обязательств.', b1: 'Получить бесплатную оценку', k2: 'Бесплатный инструмент · ставки 2026', h2: 'Продаёте? Сначала проверьте налог', p2: 'За 30 секунд узнайте, нужно ли платить налог на прирост капитала, сколько и когда продажа станет безналоговой.', b2: 'Рассчитать налог', k3: 'Бесплатно · 60 секунд', h3: 'Подходите ли вы для гражданства?', p3: 'Ответьте на 4 вопроса и узнайте, какой путь подходит вашему бюджету: гражданство ($400k), ВНЖ ($200k) или новый ВНЖ инвестора ($150k).', b3: 'Проверить', sh: 'Думаете о продаже?', sp: 'Узнайте, сколько стоит ваша недвижимость в Турции. Бесплатная оценка, обычно за 24 часа.', sb: 'Получить оценку', close: 'Закрыть' }
  };
  var t = T[lang] || T.en;
  var sfx = (lang === 'ar' || lang === 'ru') ? lang + '/' : '';
  var valUrl = '/free-property-valuation/' + sfx, taxUrl = '/tax-calculator/' + sfx, eligUrl = '/turkish-citizenship-eligibility/' + sfx;
  var path = location.pathname;
  var onValuation = path.indexOf('/free-property-valuation') === 0 || path.indexOf('/turkish-citizenship-eligibility') === 0;
  var isHome = path === '/' || path === '/index.html';

  function track(name, params) { try { if (typeof gtag === 'function') gtag('event', name, params || {}); } catch (e) {} }
  function store(k, v) { try { if (v === undefined) return localStorage.getItem(k); localStorage.setItem(k, v); } catch (e) { return null; } }

  // 1. Navigation link (pages that do not have it already)
  if (!document.querySelector('a[href^="/free-property-valuation"]')) {
    var links = document.querySelector('nav .nav-links');
    if (links) {
      var a = document.createElement('a');
      a.href = valUrl; a.className = 'lb-nav-val'; a.textContent = t.nav;
      var btn = links.querySelector('.nav-btn');
      links.insertBefore(a, btn || null);
    }
    var mm = document.getElementById('mobile-menu');
    if (mm) {
      var m = document.createElement('a');
      m.href = valUrl; m.textContent = t.nav;
      var last = mm.querySelector('a[href*="contact"]');
      mm.insertBefore(m, last || null);
      m.addEventListener('click', function () { mm.classList.remove('open'); });
    }
  }

  // 2. Floating button
  if (document.querySelector('.li-sticky')) document.body.classList.add('lb-has-sticky');
  if (!onValuation) {
    var fab = document.createElement('a');
    fab.className = 'lb-fab'; fab.href = valUrl;
    fab.innerHTML = '<span class="lb-pulse"></span><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="M3 11.5 12 4l9 7.5"/><path d="M5.5 10v10h13V10"/><path d="M10 20v-5h4v5"/></svg><span></span>';
    fab.lastChild.textContent = t.fab;
    fab.addEventListener('click', function () { track('select_promotion', { promotion_name: 'valuation_fab', page: path }); });
    document.body.appendChild(fab);
  }

  // 3. Homepage band with both tools
  if (isHome && !document.querySelector('.lb-band')) {
    var band = document.createElement('section');
    band.className = 'lb-band';
    band.innerHTML = '<div class="lb-band-in">' +
      '<a class="lb-tile lb-red" href="' + valUrl + '" data-p="home_band_valuation"><span class="lb-kicker"></span><h3></h3><p></p><span class="lb-go"></span></a>' +
      '<a class="lb-tile" href="' + eligUrl + '" data-p="home_band_eligibility"><span class="lb-kicker"></span><h3></h3><p></p><span class="lb-go"></span></a>' +
      '<a class="lb-tile" href="' + taxUrl + '" data-p="home_band_tax"><span class="lb-kicker"></span><h3></h3><p></p><span class="lb-go"></span></a></div>';
    var tiles = band.querySelectorAll('.lb-tile');
    [[t.k1, t.h1, t.p1, t.b1 + ' →'], [t.k3, t.h3, t.p3, t.b3 + ' →'], [t.k2, t.h2, t.p2, t.b2 + ' →']].forEach(function (c, i) {
      tiles[i].querySelector('.lb-kicker').textContent = c[0];
      tiles[i].querySelector('h3').textContent = c[1];
      tiles[i].querySelector('p').textContent = c[2];
      tiles[i].querySelector('.lb-go').textContent = c[3];
      tiles[i].addEventListener('click', function () { track('select_promotion', { promotion_name: tiles[i].dataset.p }); });
    });
    var anchor = document.getElementById('about') || document.getElementById('services');
    var home = document.getElementById('home');
    if (anchor && anchor.parentNode) anchor.parentNode.insertBefore(band, anchor);
    else if (home && home.parentNode) home.parentNode.insertBefore(band, home.nextSibling);
    // International buyers strip under the band
    var intl = document.createElement('section');
    intl.className = 'lb-intl';
    var cs = [['pakistan', 'PK', 'Pakistan'], ['saudi-arabia', 'SA', 'Saudi Arabia'], ['uae', 'AE', 'UAE'], ['qatar', 'QA', 'Qatar'], ['kuwait', 'KW', 'Kuwait'], ['iraq', 'IQ', 'Iraq'], ['germany', 'DE', 'Germany'], ['united-kingdom', 'GB', 'United Kingdom']];
    intl.innerHTML = '<div class="lb-intl-in"><div class="lb-intl-h"><span>International buyers</span><b>Buying from abroad? Read the guide for your country</b></div><div class="lb-intl-list">' +
      cs.map(function (c) { return '<a href="/buy-property-in-turkey/' + c[0] + '/" data-c="' + c[0] + '"><i>' + c[1] + '</i>' + c[2] + '</a>'; }).join('') +
      '<a class="lb-intl-all" href="/buy-property-in-turkey/">All countries →</a></div></div>';
    intl.querySelectorAll('a').forEach(function (a) { a.addEventListener('click', function () { track('select_promotion', { promotion_name: 'home_country_' + (a.dataset.c || 'all') }); }); });
    band.parentNode && band.parentNode.insertBefore(intl, band.nextSibling);
  }

  // 4. Slide-in card (desktop, homepage and blog), once a week at most
  var last = parseInt(store('lb_slide') || '0', 10);
  var weekAgo = Date.now() - 7 * 864e5;
  if (!onValuation && path.indexOf('/tax-calculator') !== 0 && last < weekAgo && window.innerWidth > 900) {
    var shown = false;
    var card = document.createElement('div');
    card.className = 'lb-slide'; card.setAttribute('role', 'dialog'); card.setAttribute('aria-label', t.sh);
    card.innerHTML = '<button class="lb-x" type="button">×</button><h4></h4><p></p><a class="lb-go"></a>';
    card.querySelector('h4').textContent = t.sh;
    card.querySelector('p').textContent = t.sp;
    var go = card.querySelector('a'); go.href = valUrl; go.textContent = t.sb + ' →';
    card.querySelector('.lb-x').setAttribute('aria-label', t.close);
    document.body.appendChild(card);
    var open = function () {
      if (shown) return; shown = true; card.classList.add('on'); store('lb_slide', String(Date.now()));
      track('view_promotion', { promotion_name: 'valuation_slide', page: path });
    };
    card.querySelector('.lb-x').addEventListener('click', function () { card.classList.remove('on'); });
    go.addEventListener('click', function () { track('select_promotion', { promotion_name: 'valuation_slide', page: path }); });
    window.addEventListener('scroll', function () {
      var h = document.documentElement;
      if ((h.scrollTop + window.innerHeight) / h.scrollHeight > 0.45) open();
    }, { passive: true });
    setTimeout(open, 35000);
  }

  // 5. Hide placeholder social links that go nowhere

  /* Licence and tax ID: strip on the homepage, one line under every lead form. */
  var TRUST = {
    en: ['Licensed real estate broker', 'Real estate trade licence (Taşınmaz Ticareti Yetki Belgesi) No. 3408945, Turkish Ministry of Trade', 'Registered company', 'Math Investment (Mat Yatırım) · Tax ID 0850564655', 'Office in Istanbul', 'Licensed broker · Licence No. 3408945 · Tax ID 0850564655'],
    ar: ['وسيط عقاري مرخّص', 'رخصة تجارة العقارات (Taşınmaz Ticareti Yetki Belgesi) رقم 3408945، وزارة التجارة التركية', 'شركة مسجّلة', 'Math Investment (Mat Yatırım) · الرقم الضريبي 0850564655', 'مكتبنا في إسطنبول', 'وسيط مرخّص · رخصة رقم 3408945 · الرقم الضريبي 0850564655'],
    ru: ['Лицензированный агент по недвижимости', 'Лицензия на торговлю недвижимостью (Taşınmaz Ticareti Yetki Belgesi) № 3408945, Министерство торговли Турции', 'Зарегистрированная компания', 'Math Investment (Mat Yatırım) · налоговый номер 0850564655', 'Офис в Стамбуле', 'Лицензированный агент · Лицензия № 3408945 · Налоговый номер 0850564655']
  };
  var tr = TRUST[lang] || TRUST.en;
  var SHIELD = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6z"/><path d="M9 12l2 2 4-4"/></svg>';
  if (isHome && !document.querySelector('.li-trust')) {
    var ts = document.createElement('section');
    ts.className = 'li-trust li-trust-home';
    ts.innerHTML = '<div class="li-trust-in">' +
      '<div class="li-trust-item"><i>' + SHIELD + '</i><div><b>' + tr[0] + '</b><span>' + tr[1] + '</span></div></div>' +
      '<div class="li-trust-item"><i><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 3h7l5 5v13H7z"/><path d="M14 3v5h5"/><path d="M10 13h6M10 17h6"/></svg></i><div><b>' + tr[2] + '</b><span>' + tr[3] + '</span></div></div>' +
      '<div class="li-trust-item"><i><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-7-6.2-7-12a7 7 0 0 1 14 0c0 5.8-7 12-7 12z"/><circle cx="12" cy="9" r="2.5"/></svg></i><div><b>' + tr[4] + '</b><span><a href="https://www.google.com/maps/place//data=!4m2!3m1!1s0x14caa181dce03687:0xc7290e74b462666c" target="_blank" rel="noopener">Kavaklı, Olimpiyat Cd. No:58, 34520 Beylikdüzü / İstanbul</a></span></div></div></div>';
    var hero = document.getElementById('home');
    var bandEl = document.querySelector('.lb-band');
    if (bandEl && bandEl.parentNode) bandEl.parentNode.insertBefore(ts, bandEl);
    else if (hero && hero.parentNode) hero.parentNode.insertBefore(ts, hero.nextSibling);
  }
  document.querySelectorAll('.li-lead-form, #hero-form, #contact-form').forEach(function (f) {
    if (f.querySelector('.li-trust-mini')) return;
    var m = document.createElement('p');
    m.className = 'li-trust-mini';
    m.innerHTML = SHIELD + '<span>' + tr[5] + '</span>';
    f.appendChild(m);
  });

  document.querySelectorAll('.social-links a[href="#"]').forEach(function (a) { a.style.display = 'none'; });

  /* WhatsApp: floating button on every page (mobile pages with the sticky bar already have one). */
  var WA = { en: ['WhatsApp us', 'Hello Land Istanbul, I would like some information.'], ar: ['راسلنا على واتساب', 'مرحباً Land Istanbul، أرغب في الحصول على معلومات.'], ru: ['Напишите в WhatsApp', 'Здравствуйте, Land Istanbul! Хотел(а) бы получить информацию.'] };
  var wt = WA[lang] || WA.en;
  if (!document.querySelector('.li-wa-fab')) {
    var wa = document.createElement('a');
    wa.className = 'li-wa-fab'; wa.target = '_blank'; wa.rel = 'noopener'; wa.setAttribute('data-track', 'whatsapp');
    wa.href = 'https://wa.me/905468916349?text=' + encodeURIComponent(wt[1] + ' (' + location.pathname + ')');
    wa.setAttribute('aria-label', wt[0]); wa.title = wt[0];
    wa.innerHTML = '<svg width="30" height="30" viewBox="0 0 32 32" aria-hidden="true"><path fill="#fff" d="M16 3C8.8 3 3 8.7 3 15.8c0 2.5.7 4.9 2 7L3 29l6.4-2c2 1.1 4.3 1.7 6.6 1.7 7.2 0 13-5.7 13-12.8S23.2 3 16 3zm0 23.4c-2.1 0-4.1-.6-5.9-1.7l-.4-.3-3.8 1.2 1.2-3.7-.3-.4c-1.2-1.8-1.8-3.8-1.8-5.9C5 9.9 9.9 5.1 16 5.1s11 4.8 11 10.7-4.9 10.6-11 10.6zm6-7.9c-.3-.2-2-1-2.3-1.1-.3-.1-.5-.2-.8.2-.2.3-.9 1.1-1.1 1.3-.2.2-.4.2-.7.1-.3-.2-1.4-.5-2.7-1.7-1-.9-1.7-2-1.9-2.3-.2-.3 0-.5.1-.7l.5-.6c.2-.2.2-.4.3-.6.1-.2 0-.4 0-.6l-1.1-2.6c-.3-.7-.6-.6-.8-.6h-.7c-.2 0-.6.1-.9.4-.3.3-1.2 1.2-1.2 2.9s1.2 3.3 1.4 3.6c.2.2 2.4 3.6 5.8 5 .8.3 1.4.5 1.9.7.8.3 1.5.2 2.1.1.6-.1 2-.8 2.2-1.6.3-.8.3-1.4.2-1.6-.1-.1-.3-.2-.6-.4z"/></svg>';
    wa.addEventListener('click', function () { track('contact_whatsapp', { page: path, placement: 'fab' }); });
    document.body.appendChild(wa);
  }
})();
