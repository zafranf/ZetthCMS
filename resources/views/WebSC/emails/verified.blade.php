<div style="background:#fff;width:90%;margin:0 auto;border:1px solid #ccc;color:#8B8B8B;padding:5px 10px;" id="merpati-email">
  <center>
    <a href="{{ url('/') }}">
      <img src="{{ getImageLogo('logo/landscape.png') }}" style="max-height:200px;">
    </a>
  </center>
  <hr>
  <p>Halo, {{ $name }}</p>
  <p>Selamat bergabung di situs <b>{{ env('APP_NAME') }}</b>. Sekarang anda dapat masuk ke situs dan menggunakan situs untuk mendukung kebutuhan hobi merpati anda.</p>
  <p>Terima kasih telah menjadi bagian dari <b>{{ env('APP_NAME') }}</b>.</p>
  <hr>
  <p><small>*mohon untuk tidak membalas email ini.</small></p>
</div>