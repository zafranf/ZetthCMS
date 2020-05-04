<div style="background:#fff;width:90%;margin:0 auto;border:1px solid #ccc;color:#8B8B8B;padding:5px 10px;" id="merpati-email">
  <center>
    <a href="{{ url('/') }}">
      <img src="{{ getImageLogo('logo/landscape.png') }}" style="max-height:200px;">
    </a>
  </center>
  <hr>
  <p>Halo, {{ $name }}</p>
  <p>Silakan klik tombol verifikasi di bawah ini untuk memverifikasi akun Anda.</p>
  <p>
    <a href="{{ url(route('web.verify', ['type' => 'email']) . '?kode=' . $code) }}" style="padding:5px;border:1px solid transparent;color:#fff;background:#ed4568;border-radius:4px;text-decoration:none;">Verifikasi</a>
  </p>
  <p>
    Jika tombol tidak berfungsi, silakan salin dan tempel tautan berikut ke peramban Anda:
    <pre style="background:#e9e9e9;padding:10px;"><code>{{ url(route('web.verify', ['type' => 'email']) . '?kode=' . $code) }}</code></pre>
  </p>
  <p>Abaikan jika Anda tidak melakukan pendaftaran ini.</p>
  <hr>
  <p><small>*mohon untuk tidak membalas email ini.</small></p>
</div>