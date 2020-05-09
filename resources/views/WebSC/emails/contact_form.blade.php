<div style="width:90%;margin:0 auto;border:1px solid #ccc;color:#8B8B8B;padding:5px 10px;" id="zetth-email">
  <center>
    <a href="{{ url('/') }}">
      <img src="{{ getImageLogo('logo/landscape.png') }}" style="max-height:200px;">
    </a>
  </center>
  <hr>
  <table width="100%" cellspacing="0">
    <tr>
      <td colspan="3">Detail Pesan</td>
    </tr>
    <tr>
      <td width="100">Nama</td>
      <td width="10">:</td>
      <td>{{ $name }}</td>
    </tr>
    <tr>
      <td>Email</td>
      <td>:</td>
      <td>{{ $email }}</td>
    </tr>
    <tr>
      <td>No. Telepon</td>
      <td>:</td>
      <td>{{ $phone ?? '-' }}</td>
    </tr>
    <tr>
      <td>Situs</td>
      <td>:</td>
      <td>{{ $site ?? '-' }}</td>
    </tr>
    <tr>
      <td>Subyek</td>
      <td>:</td>
      <td>{{ $title ?? '-' }}</td>
    </tr>
    <tr>
      <td style="vertical-align:top;">Pesan</td>
      <td style="vertical-align:top;">:</td>
      <td>{!! nl2br($content) !!}</td>
    </tr>
  </table>
  <hr>
  <p><small>*mohon untuk tidak membalas surel ini.</small></p>
</div>