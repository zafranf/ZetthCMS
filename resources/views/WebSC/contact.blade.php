@extends('WebSC.layouts.main')

@section('content')
<div class="technology">
  <div class="container">
    <div class="col-md-9 technology-left">
      <div class="contact-section">
        <h2 class="w3">Hubungi Kami</h2>
        <div class="contact-grids">
          @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
          @endif
          @if (count($errors) > 0)
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          <div class="col-md-7 contact-grid">
            {{-- <p>Nemo enim ips voluptatem voluptas sitsper natuaut odit aut fugit consequuntur magni dolores
              eosqratio nevoluptatem amet eism com odictor ut ligulate cot ameti dapibu</p> --}}
            <form id="form-contact" method="post" action="{{ url('/contact') }}">
              <input type="text" name="name" placeholder="Nama*" required>
              <input type="email" name="email" placeholder="Email*" required>
              <input type="text" name="phone" placeholder="No. Telpon">
              <textarea type="text" name="message" placeholder="Pesan*" required
                style="height:100px!important;"></textarea>
              <p style="padding:0!important;">* kolom wajib diisi</p>
              @csrf
              <input type="submit" value="Kirim">
              <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}" data-callback="onSubmit"
                data-size="invisible">
              </div>
            </form>
          </div>
          <div class="col-md-5 contact-grid1">
            <h4>{{ app('site')->name }}</h4>
            @if (app('site')->address)
            <p>{!! nl2br(app('site')->address) !!}</p>
            @endif
            {{-- <h4>Address</h4>
            <div class="contact-top">
              <div class="clearfix"></div>
            </div> --}}
            <ul>
              @if (app('site')->phone)
              <li>
                <i class="glyphicon glyphicon-earphone" aria-hidden="true"></i> {{ app('site')->phone }}
              </li>
              @endif
              @if (app('site')->email)
              <li>
                <i class="glyphicon glyphicon-envelope" aria-hidden="true"></i>
                <a href="mailto:{{ app('site')->email }}">{{ app('site')->email }}</a>
              </li>
              @endif
            </ul>
          </div>
          <div class="clearfix"></div>
        </div>
        @if (app('site')->coordinate)
        <div class="google-map">
          @include('google.maps')
        </div>
        @endif
      </div>
    </div>
    @include('WebSC.components.sidebar')
    <div class="clearfix"></div>
  </div>
</div>
@endsection

@section('styles')
<style>
  .technology-left p {
    line-height: 1.9em;
    font-size: 0.9em;
    color: #777;
    margin: 1em 0;
  }

  .contact-grid1 h4 {
    font-size: 1.3em !important;
  }
</style>
@endsection

@section('scripts')
@include('google.recaptcha')
<script>
  let formContact = document.getElementById('form-contact');
  formContact.addEventListener('submit', function(e) {
    e.preventDefault();
    grecaptcha.execute();
  });
</script>
@endsection