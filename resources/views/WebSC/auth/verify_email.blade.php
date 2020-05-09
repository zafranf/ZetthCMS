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
            @if (session('resend'))
              <div class="notification is-success has-text-left">
                <b>Kode verifikasi berhasil dikirim!</b><br>
                Kami telah mengirimkan ulang kode verifikasi ke surel Anda. Silakan periksa surel Anda (termasuk kotak sampah) untuk proses verifikasi.
              </div>
            @elseif (session('registered'))
              <div class="notification is-success has-text-left">
                <b>Pendaftaran berhasil!</b><br>
                Kami telah mengirimkan kode verifikasi ke surel Anda. Silakan periksa surel Anda (termasuk kotak sampah) untuk proses verifikasi.
              </div>
            @elseif (session('success') === false)
              <div class="notification is-warning has-text-left">
                <b>Verifikasi gagal!</b><br>
                Kode verifikasi telah kedaluarsa atau akun sudah terverifikasi. Silakan klik "Kirim ulang code?" di bawah atau langsung <a class="has-text-danger" href="{{ route('web.login') }}">masuk</a>. 
              </div>
            @else
              <p class="has-text-grey has-text-left"><b>Verifikasi surel</b><br>
              Silakan masukkan kode verifikasi yang sudah kami kirim ke alamat surel Anda lalu tekan tombol untuk verifikasi.</p>
            @endif
            <form id="form-verification" method="post" action="{{ route('web.verify.post') }}">
              @if (isset($errors) && $errors->has('code'))
                <div class="notification is-warning has-text-left">
                  {{ $errors->first('code') }}
                </div>
              @endif
              <div class="field">
                <input class="input" name="code" placeholder="Kode verifikasi.." required autofocus>
              </div>
              <div class="level is-mobile">
                @csrf
                <input type="hidden" name="type" value="email">
                <div class="level-left">
                  <button type="submit" class="button is-danger">Verifikasi</button>
                </div>
                <div class="level-right">
                  <a class="has-text-danger" href="{{ route('web.verify', ['type' => config('path.verification_resend')]) }}">Kirim ulang kode?</a>
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
@endsection