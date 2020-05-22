<div style="background:#fff;width:90%;margin:0 auto;border:1px solid #ccc;color:#8B8B8B;padding:5px 10px;" id="zetth-email">
  <center>
    <a href="{{ _url('/') }}">
      <img src="{{ getImageLogo('logo/landscape.png') }}" style="max-height:200px;">
    </a>
  </center>
  <hr>
  <p>Halo, {{ $name }}</p>
  <p>Selamat bergabung di situs <b>{{ env('APP_NAME') }}</b>. Sekarang anda dapat masuk ke situs dan menggunakan situs untuk mendukung kebutuhan hobi merpati anda.</p>
  <p>
    <a href="{{ route('web.login') }}" style="padding:5px;border:1px solid transparent;color:#fff;background:#ed4568;border-radius:4px;text-decoration:none;">Masuk</a>
  </p>
  <p>Terima kasih telah menjadi bagian dari <b>{{ env('APP_NAME') }}</b>.</p>
  <hr>
  <p><small>*mohon untuk tidak membalas surel ini.</small></p>
</div>