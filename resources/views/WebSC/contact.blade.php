@extends('WebSC.layouts.main')

@php
  $cookie = json_decode(Cookie::get('contact'));
@endphp

@section('content')
  {{-- <!-- START STATUS FEED --> --}}
  <section class="articles">
    <div class="column is-10 is-offset-1">
      {{-- <!-- START ARTICLE --> --}}
      <div class="card article">
        <div class="card-content">
          <div class="media">
            <div class="media-content has-text-centered" style="margin-top:2rem;overflow:unset;">
              <p class="title article-title">
                Hubungi Kami
              </p>
            </div>
          </div>
          <div class="content article-body">
            <form id="form-contact" method="post" action="{{ route('web.action.contact') }}">
              @if (session('success'))
                <div class="notification is-success has-text-left">
                  {{ session('success') }}
                </div>
              @endif
              @if (count($errors) > 0)
                <div class="notification is-danger has-text-left">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              
              <div class="field is-horizontal">
                <div class="field-label is-normal">
                  <label class="label">Pengirim</label>
                </div>
                <div class="field-body">
                  <div class="field">
                    <div class="control is-expanded has-icons-left">
                      <input class="input" type="text" name="name" placeholder="Nama lengkap.." value="{{ $cookie->name ?? old('name') }}">
                      <span class="icon is-small is-left">
                        <i class="fad fa-user"></i>
                      </span>
                    </div>
                  </div>
                  <div class="field">
                    <div class="control is-expanded has-icons-left has-icons-right">
                      <input class="input" type="email" name="email" placeholder="Alamat surel.." value="{{ $cookie->email ?? old('email') }}">
                      <span class="icon is-small is-left">
                        <i class="fad fa-envelope"></i>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              
              {{-- <div class="field is-horizontal">
                <div class="field-label"></div>
                <div class="field-body">
                  <div class="field">
                    <div class="control is-expanded has-icons-left has-icons-right">
                      <input class="input" type="text" name="phone" placeholder="Nomor telepon.." value="{{ $cookie->phone ?? old('phone') }}">
                      <span class="icon is-small is-left">
                        <i class="fad fa-phone"></i>
                      </span>
                    </div>
                  </div>
                </div>
              </div> --}}
              
              <div class="field is-horizontal">
                <div class="field-label is-normal">
                  <label class="label">Tentang</label>
                </div>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                      <input class="input" type="text" name="subject" placeholder="Tentang pesan.." value="{{ $cookie->subject ?? old('subject') }}">
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="field is-horizontal">
                <div class="field-label is-normal">
                  <label class="label">Pesan</label>
                </div>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                      <textarea class="textarea" name="message" placeholder="Isi pesan.."></textarea>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="field is-horizontal">
                <div class="field-label">
                  <!-- Left empty for spacing -->
                </div>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                      <button class="button is-primary">
                        Kirim
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              @csrf
              <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}" data-callback="onSubmit" data-size="invisible">
            </form>
          </div>
        </div>
      </div>
      {{-- <!-- END ARTICLE --> --}}
    </div>
  </section>
  {{-- <!-- END STATUS FEED --> --}}
@endsection

@push('scripts')
  <script>
    let formCaptcha = document.getElementById('form-contact');
    formCaptcha.addEventListener('submit', function(e) {
      e.preventDefault();
      let validName = checkName();
      let validEmail = checkEmail();
      /* let validPhone = checkPhone(); */
      let validSubject = checkSubject();
      let validMessage = checkMessage();
      if (!validName || !validEmail /* || !validPhone */ || !validSubject || !validMessage) {
        e.preventDefault();
      } else {
        grecaptcha.execute();
      }
    });

    function checkName(el = null) {
      el = el ? el : document.querySelectorAll('input[name=name]')[0];
      let val = el.value;

      let valid = (val != "");
      addValidClass(valid, el);

      return valid;
    }

    function checkEmail(el = null) {
      el = el ? el : document.querySelectorAll('input[name=email]')[0];
      let val = el.value;

      let valid = validateEmail(val);
      addValidClass(valid, el);

      return valid;
    }

    function checkPhone(el = null) {
      el = el ? el : document.querySelectorAll('input[name=phone]')[0];
      let val = el.value;

      let valid = (val != "");
      addValidClass(valid, el);

      return valid;
    }

    function checkSubject(el = null) {
      el = el ? el : document.querySelectorAll('input[name=subject]')[0];
      let val = el.value;

      let valid = (val != "");
      addValidClass(valid, el);

      return valid;
    }

    function checkMessage(el = null) {
      el = el ? el : document.querySelectorAll('textarea[name=message]')[0];
      let val = el.value;

      let valid = (val != "");
      addValidClass(valid, el);

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
    }
  </script>
  @include('google.recaptcha')
@endpush