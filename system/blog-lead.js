/* Land Istanbul — lead forms (blog, valuation, tax calculator): send to /mail.php, multi-step valuation, GA4 events. */
(function () {
  function track(name, params) {
    try { if (typeof gtag === 'function') gtag('event', name, params || {}); } catch (e) {}
  }

  // Multi-step forms (free valuation)
  document.querySelectorAll('.lv-form').forEach(function (form) {
    var steps = form.querySelectorAll('.lv-step');
    var bullets = form.querySelectorAll('.lv-progress li');
    var current = 0;
    function show(i) {
      steps.forEach(function (s, k) { s.hidden = k !== i; });
      bullets.forEach(function (b, k) { b.classList.toggle('on', k <= i); });
      current = i;
      var first = steps[i].querySelector('input,select,textarea');
      if (first && window.innerWidth > 700) { try { first.focus({ preventScroll: true }); } catch (e) {} }
    }
    function valid(i) {
      var ok = true;
      steps[i].querySelectorAll('[data-req]').forEach(function (el) {
        var bad = !String(el.value || '').trim();
        el.classList.toggle('lv-bad', bad);
        if (bad) ok = false;
      });
      var st = form.querySelector('.li-status');
      if (!ok && st) { st.textContent = form.dataset.required || ''; st.className = 'li-status is-error'; }
      else if (st && st.classList.contains('is-error')) { st.textContent = ''; st.className = 'li-status'; }
      return ok;
    }
    form.querySelectorAll('.lv-next').forEach(function (b) {
      b.addEventListener('click', function () {
        if (!valid(current)) return;
        track('form_step', { form: 'valuation', step: current + 2 });
        show(Math.min(current + 1, steps.length - 1));
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    });
    form.querySelectorAll('.lv-back').forEach(function (b) {
      b.addEventListener('click', function () { show(Math.max(current - 1, 0)); });
    });
    form.addEventListener('input', function (e) { if (e.target.classList) e.target.classList.remove('lv-bad'); });
    form.addEventListener('li:sent', function () {
      steps.forEach(function (s) { s.hidden = true; });
      var prog = form.querySelector('.lv-progress'); if (prog) prog.hidden = true;
      var done = document.createElement('div');
      done.className = 'lv-done';
      done.textContent = form.dataset.ok;
      form.appendChild(done);
    });
    show(0);
  });

  document.querySelectorAll('.li-lead-form').forEach(function (form) {
    var btn = form.querySelector('.li-submit');
    var status = form.querySelector('.li-status');
    var label = btn ? btn.textContent : '';
    var started = false;
    var formType = form.classList.contains('lv-form') ? 'valuation' : (form.closest('#lead-box') ? 'tax_calculator' : 'blog_lead');

    form.addEventListener('focusin', function () {
      if (!started) { started = true; track('form_start', { form: formType, page: location.pathname }); }
    });

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var fd = new FormData(form);
      var name = (fd.get('name') || '').toString().trim();
      var email = (fd.get('email') || '').toString().trim();
      var phone = (fd.get('phone') || '').toString().replace(/[^0-9+]/g, '');
      if (!name || (!email && phone.length < 6)) {
        status.textContent = form.dataset.need;
        status.className = 'li-status is-error';
        return;
      }
      btn.disabled = true;
      btn.textContent = form.dataset.sending;
      status.textContent = '';
      status.className = 'li-status';

      fetch('/mail.php', { method: 'POST', body: fd })
        .then(function (r) { return r.json().catch(function () { return { success: false }; }); })
        .then(function (json) {
          if (json && json.success) {
            status.textContent = form.dataset.ok;
            status.className = 'li-status is-ok';
            track('generate_lead', {
              form: formType,
              interest: fd.get('interest') || '',
              language: fd.get('lang') || '',
              page: location.pathname
            });
            form.dispatchEvent(new CustomEvent('li:sent'));
            form.reset();
            btn.textContent = label;
          } else {
            throw new Error('send failed');
          }
        })
        .catch(function () {
          status.textContent = form.dataset.err;
          status.className = 'li-status is-error';
          btn.disabled = false;
          btn.textContent = label;
        });
    });
  });

  document.querySelectorAll('[data-track="whatsapp"]').forEach(function (a) {
    a.addEventListener('click', function () {
      track('generate_lead', { form: 'whatsapp', page: location.pathname });
    });
  });

  document.querySelectorAll('.li-inline-cta a[href="#get-offer"]').forEach(function (a) {
    a.addEventListener('click', function () { track('select_content', { content_type: 'inline_cta', page: location.pathname }); });
  });
})();
