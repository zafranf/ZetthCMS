@extends('WebSC.auth.layouts.main')

@section('content')
  <section class="hero">
    <div class="hero-body">
      <div class="container has-text-centered">
        <div class="column is-4 is-offset-4">
          <div class="box">
            <figure class="avatar">
              <a href="{{ url('/') }}"><img src="{{ getImageLogo() }}" width="100"></a>
            </figure>
            @if (session('success'))
              <div class="notification is-success has-text-left">
                <b>Berhasil!</b><br>
                Kami telah mengirimkan tautan untuk mengubah sandi Anda. Silakan cek surel Anda (kotak masuk/sampah).
                <br>
                Anda akan dialihkan ke halaman utama dalam <span class="seconds">5</span> detik.
              </div>
            @elseif (session('success') === false)
              <div class="notification is-warning has-text-left">
                <b>Gagal!</b><br>
                Email tidak ditemukan. Silakan lakukan <a class="has-text-danger" href="{{ route('web.login') }}">pendaftaran</a> terlebih dahulu.
              </div>
            @elseif (session('oauths'))
              <div class="notification is-warning has-text-left">
                <b>Permintaan kode verifikasi ulang gagal!</b><br>
                @php
                  $oauths = session('oauths');
                  $last = array_pop($oauths);
                  $string = count($oauths) ? implode(", ", $oauths) . " & " . $last : $last;
                @endphp
                Akun terdaftar menggunakan {!! '<i>' . $string . '</i>.' !!}
                Silakan masuk menggunakan tombol yang tersedia di halaman <a class="has-text-danger" href="{{ route('web.login') }}">masuk</a>.
              </div>
            @else
              <p class="has-text-grey has-text-left"><b>Kirim ulang kode verifikasi</b><br>
              Masukkan surel Anda di kolom bawah ini. Kami akan mengirimkan ulang kode verifikasi ke surel Anda.</p>
              <form id="form-login" method="post" action="{{ route('web.verify.resend.post') }}">
                @if (isset($errors) && $errors->has('email'))
                  <div class="notification is-warning has-text-left">
                    {{ $errors->first('email') }}
                  </div>
                @endif
                <div class="field">
                  <input class="input" name="email" placeholder="Alamat email.." required autofocus>
                </div>
                <div class="level is-mobile">
                  @csrf
                  <div class="level-left">
                    <button type="submit" class="button is-danger">Kirim</button>
                  </div>
                  <div class="level-right">
                    <a class="has-text-danger" href="{{ url()->previous() }}">&laquo; Kembali</a>
                  </div>
                </div>
              </form>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('styles')
  {!! _site_css('themes/WebSC/css/login.css') !!}
@endsection

@if (session('success'))
  @section('scripts')
    <script>
      $(document).ready(function() {
        setTimeout(function() {
          window.top.location.href = '{{ route('web.root') }}';
        }, 5000);
      });
    </script>
  @endsection
@endif