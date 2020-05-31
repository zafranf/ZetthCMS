@extends('WebSC.auth.layouts.main')

@section('content')
  <section class="hero">
    <div class="hero-body">
      <div class="container has-text-centered">
        <div class="column is-4 is-offset-4">
          <div class="box">
            <figure class="avatar">
              <a href="{{ _url('/') }}"><img src="{{ getImageLogo() }}" width="100"></a>
            </figure>
            @if (session('success'))
              <div class="notification is-success has-text-left">
                <b>Berhasil!</b><br>
                Kami telah mengirimkan tautan untuk mengubah sandi Anda. Silakan cek surel Anda (termasuk kotak sampah).
                <br>
                Anda akan dialihkan ke halaman utama dalam <span class="seconds">5</span> detik.
              </div>
            @elseif (session('success') === false)
              <div class="notification is-warning has-text-left">
                <b>Gagal!</b><br>
                Email tidak ditemukan atau akun belum diaktifkan. Silakan lakukan <a class="has-text-danger" href="{{ route('web.login') }}">pendaftaran</a> atau <a class="has-text-danger" href="{{ route('web.verify', ['type' => 'email']) }}">aktifkan</a> terlebih dahulu.
              </div>
            @elseif (session('oauths'))
              <div class="notification is-warning has-text-left">
                <b>Permintaan ubah sandi gagal!</b><br>
                @php
                  $oauths = session('oauths');
                  $last = array_pop($oauths);
                  $string = count($oauths) ? implode(", ", $oauths) . " & " . $last : $last;
                @endphp
                Akun terdaftar menggunakan {!! '<i>' . $string . '</i>.' !!}
                Silakan masuk menggunakan tombol yang tersedia di halaman <a class="has-text-danger" href="{{ route('web.login') }}">masuk</a>.
              </div>
            @else
              @if (session('expired'))
                <div class="notification is-warning has-text-left">
                  <b>Gagal!</b><br>
                  Kode ubah sandi sudah kedaluarsa atau tidak ditemukan. Silakan masukkan alamat surel untuk buat permintaan ubah sandi.
                </div>
              @else
                <p class="has-text-grey has-text-left"><b>Lupa sandi?</b><br>
                Masukkan surel Anda di kolom bawah ini. Kami akan mengirimkan tautan untuk mengubah sandi Anda.</p>
              @endif
              <form id="form-login" method="post" action="{{ route('web.forgot.post') }}">
                @if (isset($errors) && $errors->has('email'))
                  <div class="notification is-warning has-text-left">
                    {{ $errors->first('email') }}
                  </div>
                @endif
                <div class="field">
                  <input class="input" name="email" placeholder="Alamat surel.." required autofocus>
                </div>
                <div class="level is-mobile">
                  @csrf
                  <div class="level-left">
                    <button type="submit" class="button is-danger">Kirim</button>
                  </div>
                  <div class="level-right">
                    <a class="has-text-danger" href="{{ _url()->previous() }}">&laquo; Kembali</a>
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
          window.top.location.href = '{{ _url('/') }}';
        }, 5000);
      });
    </script>
  @endsection
@endif