<div style="width:90%;margin:0 auto;border:1px solid #ccc;color:#8B8B8B;padding:5px 10px;" id="pwd-email">
  <center><a href="{{ url('/') }}"><img
        src="{{ _get_image("assets/images/" . app('site')->icon, url("themes/admin/AdminSC/images/" . (app('site')->icon ?? 'logo.v2.png'))) }}"
        style="max-height:200px;"></a></center>
  <hr>
  <p>Halo,</p>
  <br>
  <p>Terima kasih sudah bersedia menunggu.<br>
    Kami ingin menginformasikan bahwa saat ini website <b><a href="{{ url('/') }}"
        style="text-decoration:none;color:#7F7D7D">{{ app('site')->name }}</a></b> sudah aktif. Silakan kunjungi website
    kami.</p>

  <p><a href="{{ url('/') }}"
      style="padding:5px;border:1px solid transparent;color:#fff;background:#565656;text-decoration:none;">{{ app('site')->name }}</a>
  </p>

  <p><small>*mohon untuk tidak membalas email ini.</small></p>
</div>