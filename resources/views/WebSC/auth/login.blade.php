@extends('WebSC.auth.layouts.main')

@section('content')
  <section class="hero">
    <div class="hero-body">
      <div class="container has-text-centered">
        <div class="column is-4 is-offset-4">
          <div class="box">
            <figure class="avatar">
              <a href="{{ url('/') }}">
                <img src="{{ getImageLogo() }}" width="100">
              </a>
            </figure>
            <p class="subtitle has-text-grey has-text-left">Masuk/daftar menggunakan:</p>
            <div class="field">
              <div class="control">
                <a id="by-google" class="button is-fullwidth is-large is-google" href="{{ route('web.login.driver', ['driver' => 'google']) }}">
                  <span class="icon">
                    <i class="fab fa-google"></i>
                  </span>
                  <span>Google</span>
                </a>
              </div>
            </div>
            <div class="field">
              <div class="control">
                <a id="by-facebook" class="button is-fullwidth is-large is-facebook" href="{{ route('web.login.driver', ['driver' => 'facebook']) }}">
                  <span class="icon">
                    <i class="fab fa-facebook-f"></i>
                  </span>
                  <span>Facebook</span>
                </a>
              </div>
            </div>
            {{-- <div class="field">
              <div class="control has-icons-right">
                <button class="button is-fullwidth is-large is-facebook" type="text" placeholder="Text input">Facebook</button>
                <span class="icon is-small is-right">
                  <i class="fab fa-facebook-f"></i>
                </span>
              </div>
            </div> --}}
            {{-- <div class="is-divider" data-content="ATAU"></div>
            <div class="field has-addons">
              <div class="control" style="width:100%;">
                <form action="{{ route('web.login.email.callback') }}" method="POST">
                  {!! csrf_field() !!}
                  <input id="by-email" class="input" name="email" type="text" placeholder="Alamat email">
                </form>
              </div>
              <div class="control">
                <a class="button is-static tooltip is-tooltip-multiline" data-tooltip="Masukkan alamat email anda lalu tekan tombol enter. Kami tidak menggunakan kata sandi melainkan kami akan mengirimkan tautan ajaib ke email anda untuk akses masuk.">
                  <i class="fa fa-question-circle"></i>
                </a>
              </div>
            </div>  --}}
            <div class="is-divider" data-content="ATAU"></div>
            <div class="field for-switch">
              <label for="switch">Masuk&nbsp;&nbsp;</label>
              <input id="switch" type="checkbox" name="switch" class="switch is-rounded">
              <label for="switch">Daftar</label>
            </div>
            <form id="form-login" method="post" action="{{ route('web.login.post') }}">
              @if (old('form') == 'login')
                @if (isset($errors) && ($errors->has('name') || $errors->has('email')))
                  <div class="notification is-warning has-text-left">
                    <b>Akses masuk gagal!</b><br>
                    {{ $errors->first() }}
                  </div>
                @endif
              @endif
              @if (session('already_verified'))
                <div class="notification is-success has-text-left">
                  <b>Pengguna sudah aktif!</b><br>
                  Silakan masuk menggunakan alamat email dan sandi Anda.
                </div>
              @elseif (session('verified'))
              <div class="notification is-success has-text-left">
                <b>Verifikasi berhasil!</b><br>
                Silakan masuk menggunakan alamat email dan sandi Anda.
              </div>
            @elseif (session('verified') === false)
                <div class="notification is-warning has-text-left">
                  <b>Pengguna belum diverifikasi!</b><br>
                  Harap lakukan verifikasi terlebih dahulu. Silakan cek email Anda untuk verifikasi.
                </div>
              @elseif (session('oauths'))
                <div class="notification is-warning has-text-left">
                  <b>Akses masuk gagal!</b><br>
                  @php
                    $oauths = session('oauths');
                    $last = array_pop($oauths);
                    $string = count($oauths) ? implode(", ", $oauths) . " & " . $last : $last;
                  @endphp
                  Akun terdaftar menggunakan {!! '<i>' . $string . '</i>.' !!}
                  Silakan masuk menggunakan {!! count(session('oauths')) == 1 ? 'tombol <b>' . ucfirst(session('oauths')[0]) . '</b>' : 'salah satu tombol akses'!!} 
                  di atas.
                </div>
              @elseif (session('password_changed'))
                <div class="notification is-success has-text-left">
                  <b>Ubah sandi berhasil!</b><br>
                  Silakan masuk menggunakan alamat email dan sandi Anda yang baru.
                </div>
              @endif
              <div class="field">
                <input class="input" name="name" placeholder="Alamat email/nama profil.." required value="{{ old('name') }}" {{ !old('name') ? 'autofocus' : '' }}>
              </div>
              <div class="field">
                <input class="input" type="password" name="password" placeholder="Sandi.." required>
              </div>
              <div class="level is-mobile">
                @csrf
                <input type="hidden" name="form" value="login">
                <input type="hidden" name="next" value="{{ URL::previous() != route('web.login') ? URL::previous() : url('/') }}">
                <div class="level-left">
                  <button type="submit" class="button is-danger">Masuk</button>
                </div>
                <div class="level-right">
                  <a class="has-text-danger" href="{{ route('web.forgot.password') }}">Lupa sandi?</a>
                </div>
              </div>
            </form>
            <form id="form-register" method="post" action="{{ route('web.register.post') }}" style="display:none;">
              @if (old('form') == 'register')
                @if (count($errors))
                  <div class="notification is-warning has-text-left">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
              @endif
              <div class="field">
                <input class="input" name="fullname" placeholder="Nama lengkap.." required maxlength="100" autofocus>
              </div>
              <div class="field">
                <input class="input" name="email" placeholder="Alamat email.." required maxlength="100">
              </div>
              <div class="field">
                <input class="input" type="password" name="password" placeholder="Sandi.." required minlength="6">
              </div>
              <div class="field">
                <input class="input" type="password" name="password_confirmation" placeholder="Ulangi sandi.." required minlength="6">
              </div>
              <div class="level is-mobile">
                @csrf
                <input type="hidden" name="form" value="register">
                <div class="level-left">
                  <button type="submit" class="button is-primary">Daftar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('styles')
  {!! _site_css('themes/WebSC/css/login.css') !!}
  <style>
    .for-switch label {
      cursor: pointer;
    }
    .switch[type=checkbox]+label::before, .switch[type=checkbox]+label:before {
      background: #ed4568;
    }
  </style>
@endsection

@section('scripts')
  <script>
    $(document).ready(function() {
      @if (old('form') == 'register')
        $('#switch').prop('checked', true);
      @endif

      $('#switch').on('change', function() {
        checkPropSwitch();
      });

      checkPropSwitch();
    });

    function checkPropSwitch() {
      let is_register = $('#switch').prop('checked');
      if (is_register) {
        $('#form-login').hide();
        $('#form-register').show();
        $('input[name=fullname]').focus();
      } else {
        $('#form-login').show();
        $('#form-register').hide();
        $('input[name=name]').focus();
      }
    }
  </script>
@endsection