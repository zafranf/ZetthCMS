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
                Kami telah mengirimkan tautan untuk mengubah sandi Anda. Silakan cek email Anda (kotak masuk/sampah).
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
              <p class="has-text-grey has-text-left"><b>Ubah sandi</b><br>
              Masukkan sandi baru Anda.</p>
              <form id="form-login" method="post" action="{{ route('web.reset.post') }}">
                @if (count($errors))
                  <div class="notification is-warning has-text-left">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
                <div class="field">
                  <input class="input" type="password" name="password" placeholder="Sandi baru.." required autofocus>
                </div>
                <div class="field">
                  <input class="input" type="password" name="password_confirmation" placeholder="Ulangi sandi baru.." required autofocus>
                </div>
                <div class="level is-mobile">
                  @csrf
                  <input type="hidden" name="code" value="{{ request()->input('kode') }}">
                  <div class="level-left">
                    <button type="submit" class="button is-danger">Ubah</button>
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