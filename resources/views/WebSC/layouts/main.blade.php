@include('WebSC.layouts.header')

  {{-- <!-- START NAV --> --}}
  <nav class="navbar is-white is-fixed-top">
    <div class="navbar-brand">
      <a class="navbar-item brand-text" href="{{ route('web.root') }}" style="padding:0">
        <img src="{{ getImageLogo() }}">
      </a>
      <div class="navbar-item is-hidden-desktop">
        <div class="control has-icons-left">
          <input class="input is-rounded" type="email" placeholder="{{ Request::input('q') ?? 'Cari sesuatu' }}">
          <span class="icon is-left">
            <i class="fa fa-search"></i>
          </span>
        </div>
      </div>
      <div class="navbar-burger burger" data-target="nav-menu">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div id="nav-menu" class="navbar-menu">
      {!! generateMenu('website', config('site.menu.options')) !!}
      <div class="navbar-end">
        <hr class="navbar-divider" style="display:block;">
        <div class="navbar-item is-hidden-mobile">
          <form action="{{ route('web.search') }}" method="get">
            <div class="control has-icons-left">
              <input name="q" class="input is-rounded" type="text" placeholder="{{ Request::input('q') ?? 'Cari sesuatu' }}">
              <span class="icon is-left">
                <i class="fad fa-search"></i>
              </span>
            </div>
          </form>
        </div>
        @if (Auth::user())
          <a class="navbar-item" href="{{ url(app('user')->name) }}">
            <i class="fad fa-user"></i>&nbsp;Profil
          </a>
          <a class="navbar-item" href="{{ url('#') }}" onclick="event.preventDefault();$('#form-logout').submit();">
            <i class="fad fa-sign-out-alt"></i>&nbsp;Keluar
          </a>
          <form action="{{ route('web.logout.post') }}" id="form-logout" method="post" class="is-hidden">
            {{ csrf_field() }}
          </form>
        @else
          <a class="navbar-item" href="{{ route('web.login') }}">
            <i class="fad fa-sign-in-alt"></i>&nbsp;Masuk/Daftar
          </a>
          {{-- <a class="navbar-item" href="{{ url('/pendaftaran') }}">
            <i class="fab fa-wpforms"></i>&nbsp;Daftar
          </a> --}}
        @endif
      </div>
    </div>
  </nav>
  {{-- <!-- END NAV --> --}}
  
  @if (isset($banners))
    @include('WebSC.components.banner')
  @endif

  <div class="container">
    @yield('content')
  </div>

@include('WebSC.layouts.footer')