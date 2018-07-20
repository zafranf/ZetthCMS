@php 
$page_title = 'Masuk Aplikasi';
@endphp
@include('layouts.header')

<div class="page-single">
  <div class="container">
    <div class="row">
      <div class="col col-login mx-auto">
        <div class="text-center mb-6">
          <img src="{{ url('/images/logo.jpg') }}" class="h-6" alt="">
        </div>
        <form class="card" action="{{ url('/login') }}" method="post">
          @csrf
          <div class="card-body p-6">
            <div class="card-title">Masuk ke aplikasi NYPSoft</div>
            <div class="form-group">
              <label class="form-label">Pengguna</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Nama Pengguna">
            </div>
            <div class="form-group">
              <label class="form-label">
                Sandi
              </label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Kata Sandi">
            </div>
            <div class="form-footer">
              <button type="submit" class="btn btn-primary btn-block">Masuk</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@include('layouts.footer')