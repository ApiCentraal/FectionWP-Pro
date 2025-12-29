(function () {
  function qs(sel) {
    return document.querySelector(sel);
  }

  function encodeWhatsAppText(text) {
    return encodeURIComponent(text);
  }

  function show(el) {
    if (!el) return;
    el.classList.remove('d-none');
  }

  function hide(el) {
    if (!el) return;
    el.classList.add('d-none');
  }

  document.addEventListener('DOMContentLoaded', function () {
    var form = qs('#tffp-whatsapp-form');
    if (!form) return;

    var success = qs('#tffp-whatsapp-success');
    var error = qs('#tffp-whatsapp-error');

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      hide(success);
      hide(error);

      var number = form.getAttribute('data-whatsapp-number') || '31612345678';
      number = String(number).replace(/\D+/g, '') || '31612345678';

      var name = (qs('#tffp-contact-name') || {}).value || '';
      var email = (qs('#tffp-contact-email') || {}).value || '';
      var phone = (qs('#tffp-contact-phone') || {}).value || '';
      var message = (qs('#tffp-contact-message') || {}).value || '';

      name = name.trim();
      email = email.trim();
      phone = phone.trim();
      message = message.trim();

      if (!name || !email || !message) {
        if (error) {
          error.textContent = 'Vul alle verplichte velden in.';
          show(error);
        }
        return;
      }

      var text = 'Hallo! Mijn naam is ' + name + '.\n\n' + message + '\n\nEmail: ' + email;
      if (phone) {
        text += '\nTelefoon: ' + phone;
      }

      var url = 'https://wa.me/' + number + '?text=' + encodeWhatsAppText(text);
      window.open(url, '_blank', 'noopener');

      show(success);

      // Reset only the message part to allow quick follow-up edits
      form.reset();
    });
  });
})();
