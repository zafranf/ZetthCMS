<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
  function onSubmit(token) {
    document.getElementById("form-contact").submit();
  }/* 

  let formContact = document.getElementById('form-contact');
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
  });

  function checkName(el = null) {
      el = el ? el : document.querySelectorAll('input[name=name]')[0];
      let val = el.value;

      let valid = (val != "");
      addValidClass(valid, el)

      return valid;
  }

  function checkEmail(el = null) {
    el = el ? el : document.querySelectorAll('input[name=email]')[0];
    let val = el.value;

    let valid = validateEmail(val);
    addValidClass(valid, el)

    return valid;
  }

  function checkPhone(el = null) {
    el = el ? el : document.querySelectorAll('input[name=phone]')[0];
    let val = el.value;

    let valid = (val != "");
    addValidClass(valid, el)

    return valid;
  }

  function checkSubject(el = null) {
    el = el ? el : document.querySelectorAll('input[name=subject]')[0];
    let val = el.value;

    let valid = (val != "");
    addValidClass(valid, el)

    return valid;
  }

  function checkMessage(el = null) {
    el = el ? el : document.querySelectorAll('textarea[name=message]')[0];
    let val = el.value;

    let valid = (val != "");
    addValidClass(valid, el)

    return valid;
  }

  function validateEmail(email) {
    let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    return re.test(String(email).toLowerCase());
  }

  function addValidClass(valid, el) {
    if (!valid) {
      el.classList.add('is-danger');
    } else {
      el.classList.remove('is-danger');
    }
  } */
</script>