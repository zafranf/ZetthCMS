@include('WebSC.layouts.header')

  {{-- <!-- START NAV --> --}}
  <nav class="navbar is-white is-fixed-top">
    <div class="navbar-brand">
      <a class="navbar-item brand-text" href="{{ url('/') }}" style="padding:0">
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
      <div class="navbar-start">
        <a class="navbar-item{{ in_array(Request::segment(1), ['artikel', 'baca-artikel']) ? ' has-text-danger has-background-white-bis' : '' }}" href="{{ url('/artikel') }}">
          <i class="fad fa-newspaper"></i>&nbsp;Artikel
        </a>
        <a class="navbar-item" {{-- href="{{ url('/burung') }}" --}} disabled>
          <i class="fad fa-dove"></i>&nbsp;Burung
        </a>
        {{-- <a class="navbar-item" href="{{ url('/silsilah') }}" disabled>
          <i class="fad fa-code-branch"></i>&nbsp;Silsilah
        </a> --}}
        <a class="navbar-item" {{-- href="{{ url('/acara') }}" --}} disabled>
          <i class="fad fa-calendar-week"></i>&nbsp;Acara
        </a>
        <a class="navbar-item" {{-- href="{{ url('/lomba') }}" --}} disabled>
          <i class="fad fa-flag-checkered"></i>&nbsp;Lomba
        </a>
        <a class="navbar-item" {{-- href="{{ url('/pasar') }}" --}} disabled>
          <i class="fad fa-dumpster"></i>&nbsp;Pasar
        </a>
        <a class="navbar-item" {{-- href="{{ url('/lelang') }}" --}} disabled>
          <i class="fad fa-gavel"></i>&nbsp;Lelang
        </a>
      </div>
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
          <a class="navbar-item" href="{{ route('web.profile') }}">
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