/* Land Istanbul — site-wide promotion of the free valuation and the tax calculator (v1). */
(function () {
  var lang = (document.documentElement.getAttribute('lang') || 'en').slice(0, 2);
  var T = {
    en: { nav: 'Free Valuation', fab: 'Free valuation', k1: 'Free · any city in Turkey', h1: 'What is your property worth?', p1: 'Get a realistic price range from a local expert, usually within 24 hours. No obligation.', b1: 'Get my free valuation', k2: 'Free tool · 2026 rates', h2: 'Selling? Check your tax first', p2: 'See in 30 seconds whether you owe capital gains tax, how much, and when your sale becomes tax-free.', b2: 'Calculate my tax', sh: 'Thinking of selling?', sp: 'Find out what your property in Turkey is worth. Free valuation, usually within 24 hours.', sb: 'Get my valuation', close: 'Close' },
    ar: { nav: 'تقييم مجاني', fab: 'تقييم مجاني', k1: 'مجاني · أي مدينة في تركيا', h1: 'كم يساوي عقارك؟', p1: 'احصل على نطاق سعر واقعي من خبير محلي خلال 24 ساعة عادةً، دون أي التزام.', b1: 'احصل على تقييمك المجاني', k2: 'أداة مجانية · أسعار 2026', h2: 'تبيع؟ احسب الضريبة أولاً', p2: 'اعرف خلال 30 ثانية هل عليك ضريبة على أرباح العقار وكم تبلغ ومتى يصبح البيع معفى.', b2: 'احسب الضريبة', sh: 'تفكر في البيع؟', sp: 'اعرف كم يساوي عقارك في تركيا. تقييم مجاني خلال 24 ساعة عادةً.', sb: 'احصل على التقييم', close: 'إغلاق' },
    ru: { nav: 'Бесплатная оценка', fab: 'Бесплатная оценка', k1: 'Бесплатно · любой город Турции', h1: 'Сколько стоит ваша недвижимость?', p1: 'Реалистичный диапазон цены от местного эксперта, обычно за 24 часа. Без обязательств.', b1: 'Получить бесплатную оценку', k2: 'Бесплатный инструмент · ставки 2026', h2: 'Продаёте? Сначала проверьте налог', p2: 'За 30 секунд узнайте, нужно ли платить налог на прирост капитала, сколько и когда продажа станет безналоговой.', b2: 'Рассчитать налог', sh: 'Думаете о продаже?', sp: 'Узнайте, сколько стоит ваша недвижимость в Турции. Бесплатная оценка, обычно за 24 часа.', sb: 'Получить оценку', close: 'Закрыть' }
  };
  var t = T[lang] || T.en;
  var valUrl = '/free-property-valuation/' + (lang === 'ar' || lang === 'ru' ? lang + '/' : '');
  var path = location.pathname;
  var onValuation = path.indexOf('/free-property-valuation') === 0;
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
      '<a class="lb-tile" href="/tax-calculator/" data-p="home_band_tax"><span class="lb-kicker"></span><h3></h3><p></p><span class="lb-go"></span></a></div>';
    var tiles = band.querySelectorAll('.lb-tile');
    [[t.k1, t.h1, t.p1, t.b1 + ' →'], [t.k2, t.h2, t.p2, t.b2 + ' →']].forEach(function (c, i) {
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
  document.querySelectorAll('.social-links a[href="#"]').forEach(function (a) { a.style.display = 'none'; });
})();
