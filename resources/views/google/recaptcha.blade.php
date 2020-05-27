<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
  function onSubmit(token) {
    formCaptcha.submit();
  }

  {{-- /* let formContact = document.getElementById('form-contact');
  formContact.addEventListener('submit', function(e) {
    e.preventDefault();
    let validName = checkName();
    let validEmail = checkEmail();
    let validPhone = checkPhone();
    let validSubject = checkSubject();
    let validMessage = checkMessage();
    if (!validName || !validEmail || !validMessage) {
      e.preventDefault();
    } else {
      grecaptcha.execute();
    }
  }); */ --}}
</script>