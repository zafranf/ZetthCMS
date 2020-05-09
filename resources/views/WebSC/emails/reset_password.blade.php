<div style="background:#fff;width:90%;margin:0 auto;border:1px solid #ccc;color:#8B8B8B;padding:5px 10px;" id="zetth-email">
  <center>
    <a href="{{ url('/') }}">
      <img src="{{ getImageLogo('logo/landscape.png') }}" style="max-height:200px;">
    </a>
  </center>
  <hr>
  <p>Halo, {{ $name }}</p>
  <p>Anda telah berhasil mengubah sandi Anda. Silakan klik tombol di bawah untuk melanjutkan akses masuk menggunakan sandi yang baru.</p>
  <p>
    <a href="{{ route('web.login') }}" style="padding:5px;border:1px solid transparent;color:#fff;background:#ed4568;border-radius:4px;text-decoration:none;">Masuk</a>
  </p>
  <p>
    Jika tombol tidak berfungsi, silakan salin dan tempel tautan berikut ke peramban Anda:
    <pre style="background:#e9e9e9;padding:10px;"><code>{{ route('web.login') }}</code></pre>
  </p>
  <hr>
  <p><small>*mohon untuk tidak membalas surel ini.</small></p>
</div>