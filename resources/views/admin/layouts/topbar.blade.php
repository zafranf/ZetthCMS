    {{-- START HEADER --}}
    <div class="header ">
      {{-- START MOBILE SIDEBAR TOGGLE --}}
      <a href="#" class="btn-link toggle-sidebar d-lg-none pg pg-menu" data-toggle="sidebar"></a>
      {{-- END MOBILE SIDEBAR TOGGLE --}}
      <div class="">
        <div class="brand inline">
          <img src="{{ _get_image('/admin/images/' . $apps->logo) }}" alt="{{ $apps->name }} logo" data-src="{{ _get_image('/admin/images/' . $apps->logo) }}" data-src-retina="{{ _get_image('/admin/images/' . $apps->logo) }}" width="78" height="22">
        </div>
        {{-- <a href="#" class="search-link d-lg-inline-block d-none" data-toggle="search"><i class="pg-search"></i>Type anywhere to <span class="bold">search</span></a> --}}
      </div>
      <div class="d-flex align-items-center">
        {{-- START NOTIFICATION LIST --}}
        <ul class="d-lg-inline-block notification-list no-margin d-lg-inline-block b-grey b-r no-style p-r-5" style="margin-right:10px!important">
          <li class="p-r-10 inline">
            <div class="dropdown">
              <a href="javascript:;" id="notification-center" class="header-icon pg pg-world" data-toggle="dropdown">
                <span class="bubble"></span>
              </a>
              {{-- START Notification Dropdown --}}
              <div class="dropdown-menu notification-toggle" role="menu" aria-labelledby="notification-center">
                {{-- START Notification --}}
                <div class="notification-panel">
                  {{-- START Notification Body--}}
                  <div class="notification-body scrollable">
                    {{-- START Notification Item--}}
                    <div class="notification-item unread clearfix">
                      <div class="heading">
                        <a href="#" class="text-danger pull-left">
                          <i class="fa fa-exclamation-triangle m-r-10"></i>
                          <span class="bold">98% Server Load</span>
                          <span class="fs-12 m-l-10">Take Action</span>
                        </a>
                        <span class="pull-right time">2 mins ago</span>
                      </div>
                      {{-- START Notification Item Right Side--}}
                      <div class="option">
                        <a href="#" class="mark"></a>
                      </div>
                      {{-- END Notification Item Right Side--}}
                    </div>
                    {{-- END Notification Item--}}
                    {{-- START Notification Item--}}
                    <div class="notification-item  clearfix">
                      <div class="heading">
                        <a href="#" class="text-warning-dark pull-left">
                          <i class="fa fa-exclamation-triangle m-r-10"></i>
                          <span class="bold">Warning Notification</span>
                          <span class="fs-12 m-l-10">Buy Now</span>
                        </a>
                        <span class="pull-right time">yesterday</span>
                      </div>
                      {{-- START Notification Item Right Side--}}
                      <div class="option">
                        <a href="#" class="mark"></a>
                      </div>
                      {{-- END Notification Item Right Side--}}
                    </div>
                    {{-- END Notification Item--}}
                  </div>
                  {{-- END Notification Body--}}
                  {{-- START Notification Footer--}}
                  <div class="notification-footer text-center">
                    <a href="#" class="">Read all notifications</a>
                    <a data-toggle="refresh" class="portlet-refresh text-black pull-right" href="#">
                      <i class="pg-refresh_new"></i>
                    </a>
                  </div>
                  {{-- START Notification Footer--}}
                </div>
                {{-- END Notification --}}
              </div>
              {{-- END Notification Dropdown --}}
            </div>
          </li>
        </ul>
        {{-- END NOTIFICATIONS LIST --}}
        {{-- START User Info--}}
        <div class="pull-left fs-14 font-heading d-lg-block d-none">
          {{-- <span class="semi-bold">David</span> <span class="text-master">Nest</span> --}}
          <span class="semi-bold">{{ Auth::user()->fullname }}</span>
        </div>
        <div class="dropdown pull-right d-lg-block d-nonex">
          <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="thumbnail-wrapper d32 circular inline">
            <img src="{{ _get_image('/admin/images/avatar.png') }}" alt="" data-src="{{ _get_image('/admin/images/avatar.png') }}" data-src-retina="{{ _get_image('/admin/images/avatar.png') }}" width="32" height="32">
            </span>
          </button>
          <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
            <a href="#" class="dropdown-item"><i class="fa fa-user"></i> Akun</a>
            {{-- <a href="#" class="dropdown-item"><i class="pg-outdent"></i> Feedback</a>
            <a href="#" class="dropdown-item"><i class="pg-signals"></i> Help</a> --}}
            <a href="#" class="clearfix bg-master-lighter dropdown-item" onclick="logout()">
              <form id="form-logout" action="{{ url('/logout') }}" method="POST" style="display:none;">
              @csrf
              </form>
              <i class="fa fa-sign-out"></i> Keluar
            </a>
          </div>
        </div>
        {{-- END User Info--}}
        {{-- <a href="#" class="header-icon pg pg-alt_menu btn-link m-l-10 sm-no-margin d-inline-block" data-toggle="quickview" data-toggle-element="#quickview"></a> --}}
      </div>
    </div>
    {{-- END HEADER --}}
    <script>
    function logout() {
      $('#form-logout').submit();
    }
    </script>