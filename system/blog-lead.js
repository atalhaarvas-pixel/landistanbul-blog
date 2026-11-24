/* Land Istanbul — blog lead forms (sends to /mail.php, tracks GA4 events). */
(function () {
  function track(name, params) {
    try { if (typeof gtag === 'function') gtag('event', name, params || {}); } catch (e) {}
  }

  document.querySelectorAll('.li-lead-form').forEach(function (form) {
    var btn = form.querySelector('.li-submit');
    var status = form.querySelector('.li-status');
    var label = btn ? btn.textContent : '';
    var started = false;

    form.addEventListener('focusin', function () {
      if (!started) { started = true; track('form_start', { form: 'blog_lead', page: location.pathname }); }
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
              form: 'blog_lead',
              interest: fd.get('interest') || '',
              language: fd.get('lang') || '',
              page: location.pathname
            });
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
