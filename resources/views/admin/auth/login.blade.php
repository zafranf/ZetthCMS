@include('admin.layouts.header')
<div class="register-container full-height sm-p-t-30">
  <div class="d-flex justify-content-center flex-column full-height ">
    <img src="{{ _get_image('/admin/images/' . $apps->logo) }}" alt="{{ $apps->name }} logo" data-src="{{ _get_image('/admin/images/' . $apps->logo) }}" data-src-retina="{{ _get_image('/admin/images/' . $apps->logo) }}" width="78" height="22">
    {{-- <h3>Pages makes it easy to enjoy what matters the most in your life</h3> --}}
    <p class="p-t-35">Masuk ke halaman admin {{ $apps->name }}</p>
    {{-- START Login Form --}}
    <form id="form-login" class="p-t-15" role="form" action="{{ url('/login') }}" method="POST">
      {{ csrf_field() }}
      {{-- START Form Control--}}
      <div class="form-group form-group-default">
        <label>Nama pengguna</label>
        <div class="controls">
          <input type="text" name="name" placeholder="Masukkan nama pengguna" class="form-control" required>
        </div>
      </div>
      {{-- END Form Control--}}
      {{-- START Form Control--}}
      <div class="form-group form-group-default">
        <label>Kata sandi</label>
        <div class="controls">
          <input type="password" class="form-control" name="password" placeholder="Masukkan kata sandi" required>
        </div>
      </div>
      {{-- START Form Control--}}
      <div class="row">
        <div class="col-md-6 no-padding sm-p-l-10">
          <div class="checkbox ">
            <input type="checkbox" name="remember_me" id="remember-me">
            <label for="remember-me">Ingat saya</label>
          </div>
        </div>
        {{-- <div class="col-md-6 d-flex align-items-center justify-content-end">
          <a href="#" class="text-info small">Help? Contact Support</a>
        </div> --}}
      </div>
      {{-- END Form Control--}}
      <button class="btn btn-primary btn-cons m-t-10" type="submit">Masuk</button>
    </form>
    {{--END Login Form--}}
  </div>
</div>
@include('admin.layouts.footer')

@section('scripts')
<script type="text/javascript">
window.onload = function() {
  // fix for windows 8
  if (navigator.appVersion.indexOf("Windows NT 6.2") != -1) {
    document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="/admin/css/windows.chrome.fix.css">'
  }
}
</script>
<script>
  $(function() {
    $('#form-login').validate()
  })
</script>
@endsection