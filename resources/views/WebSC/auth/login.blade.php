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
            <div id="default-login">
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
              <div class="field">
                <div class="control">
                  <a id="by-facebook" class="button is-fullwidth is-large" onclick="openMagicLink()">
                    <span class="icon">
                      <i class="fal fa-envelope"></i>
                    </span>
                    <span>Tautan Pintas</span>
                  </a>
                </div>
              </div>
              <div class="is-divider" data-content="ATAU GUNAKAN SANDI"></div>
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
                    Silakan masuk menggunakan alamat surel dan sandi Anda.
                  </div>
                @elseif (session('verified'))
                  <div class="notification is-success has-text-left">
                    <b>Verifikasi berhasil!</b><br>
                    Silakan masuk menggunakan alamat surel dan sandi Anda.
                  </div>
                @elseif (session('verified') === false)
                  <div class="notification is-warning has-text-left">
                    <b>Pengguna belum diverifikasi!</b><br>
                    Harap lakukan verifikasi terlebih dahulu. Silakan cek surel Anda untuk verifikasi.
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
                    Silakan masuk menggunakan alamat surel dan sandi Anda yang baru.
                  </div>
                @elseif (session('password_changed') === false)
                  <div class="notification is-warning has-text-left">
                    <b>Gagal ubah sandi!</b><br>
                    Terdapat kesalahan data ubah sandi. Silakan dicoba lagi.
                  </div>
                @endif
                <div class="field">
                  <input class="input" name="name" placeholder="Nama atau surel.." required value="{{ old('name') }}" {{ !old('name') ? 'autofocus' : '' }}>
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

              <form id="form-register" class="is-hidden" method="post" action="{{ route('web.register.post') }}">
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
            
            <div id="magiclink-login" class="is-hidden">
              <form id="form-magiclink" method="get" action="{{ route('web.login.driver', ['driver' => 'magiclink']) }}">
                @if (session('magiclink') !== null && !session('magiclink'))
                  <div class="notification is-danger has-text-left">
                    <b>Email tidak valid!</b><br>
                    Silakan masukkan alamat surel yang valid.
                  </div>
                @elseif (session('magiclink_login') !== null && !session('magiclink_login'))
                  <div class="notification is-danger has-text-left">
                    <b>Gagal akses masuk!</b><br>
                    Tautan pintas telah kedaluarsa atau tidak ditemukan. Silakan masukkan alamat surel untuk mendapatkan tautan pintas yang baru.
                  </div>
                @endif
                <div class="field">
                  <p class="has-text-grey has-text-left"><b>Tautan Pintas</b><br>Kami akan mengirimkan tautan pintas untuk akses masuk Anda tanpa menggunakan sandi.</p>
                  <input class="input" name="email" placeholder="Alamat email.." value="{{ old('email') }}" {{ !old('email') ? 'autofocus' : '' }} required maxlength="100">
                </div>
                <div class="level is-mobile">
                  <div class="level-left">
                    <input type="hidden" name="form" value="register">
                    <button type="submit" class="button is-danger">Kirim</button>
                  </div>
                  <div class="level-right">
                    <a class="has-text-danger" onclick="closeMagicLink()">&laquo; Kembali</a>
                  </div>
                </div>
              </form>
            </div>
            
            <div id="magiclink-validate" class="is-hidden">
              <form id="form-magiclink-validate" method="get" action="{{ route('web.login.driver.callback', ['driver' => 'magiclink']) }}">
                <div class="field">
                  <div class="notification is-success has-text-left">
                    <b>Tautan pintas berhasil terkirim!</b><br>
                    Silakan periksa surel Anda (termasuk kotak sampah) untuk proses masuk ke situs.
                  </div>
                  <input class="input" name="code" placeholder="Kode tautan pintas.." required value="{{ old('code') }}" {{ !old('code') ? 'autofocus' : '' }}>
                </div>
                <div class="level is-mobile">
                  <div class="level-left">
                    <button type="submit" class="button is-danger">Masuk</button>
                  </div>
                  <div class="level-right">
                    <a class="has-text-danger" onclick="closeMagicLinkValidate()">&laquo; Kembali</a>
                  </div>
                </div>
              </form>
            </div>
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
      @if ((session('magiclink') !== null && !session('magiclink')) 
        || (session('magiclink_login') !== null && !session('magiclink_login')))
        openMagicLink();
      @endif
      @if (session('magiclink'))
        openMagicLinkValidate();
      @endif
    });

    function checkPropSwitch() {
      let is_register = $('#switch').prop('checked');
      if (is_register) {
        $('#form-login').addClass('is-hidden');
        $('#form-register').removeClass('is-hidden');
        $('input[name=fullname]').focus();
      } else {
        $('#form-login').removeClass('is-hidden');
        $('#form-register').addClass('is-hidden');
        $('input[name=name]').focus();
      }
    }

    function openMagicLink() {
      $('#default-login').addClass('is-hidden');
      $('#magiclink-login').removeClass('is-hidden');
      $('input[name=email]').focus();
    }

    function closeMagicLink() {
      $('#default-login').removeClass('is-hidden');
      $('#magiclink-login').addClass('is-hidden');
    }

    function openMagicLinkValidate() {
      $('#default-login').addClass('is-hidden');
      $('#magiclink-validate').removeClass('is-hidden');
      $('input[name=code]').focus();
    }

    function closeMagicLinkValidate() {
      $('#default-login').removeClass('is-hidden');
      $('#magiclink-validate').addClass('is-hidden');
      $('input[name=code]').focus();
    }
  </script>
@endsection