<div style="background:#fff;width:90%;margin:0 auto;border:1px solid #ccc;color:#8B8B8B;padding:5px 10px;" id="zetth-email">
  <center>
    <a href="{{ _url('/') }}">
      <img src="{{ getImageLogo('logo/landscape.png') }}" style="max-height:200px;">
    </a>
  </center>
  <hr>
  <p>Halo, {{ $name }}</p>
  <p>Silakan klik tombol di bawah ini untuk masuk ke akun Anda.</p>
  <p>
    <a href="{{ url(route('web.login.driver.callback', ['driver' => 'magiclink']) . '?code=' . $code) }}" style="padding:5px;border:1px solid transparent;color:#fff;background:#ed4568;border-radius:4px;text-decoration:none;">Masuk</a>
  </p>
  <p>
    Atau masukkan kode berikut ke halaman tautan pintas:
    <pre style="background:#e9e9e9;padding:10px;"><code>{{ $code }}</code></pre>
  </p>
  <p>Abaikan jika Anda tidak melakukan permintaan tautan pintas ini.</p>
  <hr>
  <p><small>*mohon untuk tidak membalas surel ini.</small></p>
</div>