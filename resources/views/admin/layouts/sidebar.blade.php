  {{-- BEGIN SIDEBPANEL--}}
  <nav class="page-sidebar" data-pages="sidebar">
    {{-- BEGIN SIDEBAR MENU TOP TRAY CONTENT--}}
    {{-- <div class="sidebar-overlay-slide from-top" id="appMenu">
      <div class="row">
        <div class="col-xs-6 no-padding">
          <a href="#" class="p-l-40"><img src="assets/img/demo/social_app.svg" alt="social"></a>
        </div>
        <div class="col-xs-6 no-padding">
          <a href="#" class="p-l-10"><img src="assets/img/demo/email_app.svg" alt="social"></a>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-6 m-t-20 no-padding">
          <a href="#" class="p-l-40"><img src="assets/img/demo/calendar_app.svg" alt="social"></a>
        </div>
        <div class="col-xs-6 m-t-20 no-padding">
          <a href="#" class="p-l-10"><img src="assets/img/demo/add_more.svg" alt="social"></a>
        </div>
      </div>
    </div> --}}
    {{-- END SIDEBAR MENU TOP TRAY CONTENT--}}
    {{-- BEGIN SIDEBAR MENU HEADER--}}
    <div class="sidebar-header">
      <img src="{{ _get_image('/admin/images/' . $apps->logo) }}" alt="{{ $apps->name }} logo" class="brand" data-src="{{ _get_image('/admin/images/' . $apps->logo) }}" data-src-retina="{{ _get_image('/admin/images/' . $apps->logo) }}" width="78" height="22">
      {{-- <div class="sidebar-header-controls">
        <button type="button" class="btn btn-xs sidebar-slide-toggle btn-link m-l-20" data-pages-toggle="#appMenu">
          <i class="fa fa-angle-down fs-16"></i>
        </button>
        <button type="button" class="btn btn-link d-lg-inline-block d-xlg-inline-block d-md-inline-block d-sm-none d-none" data-toggle-pin="sidebar">
          <i class="fa fs-12"></i>
        </button>
      </div> --}}
    </div>
    {{-- END SIDEBAR MENU HEADER--}}
    {{-- START SIDEBAR MENU --}}
    <div class="sidebar-menu">
      {{-- BEGIN SIDEBAR MENU ITEMS--}}
      <ul class="menu-items">
        <li class="m-t-30 ">
          <a href="index.html" class="detailed">
            <span class="title">Dashboard</span>
            <span class="details">12 New Updates</span>
          </a>
          <span class="bg-success icon-thumbnail">
            <i class="pg-home"></i>
          </span>
        </li>
        <li class="">
          <a href="javascript:;"><span class="title">Menu Levels</span><span class="arrow"></span></a>
          <span class="icon-thumbnail"><i class="pg-menu_lv"></i></span>
          <ul class="sub-menu">
            <li>
              <a href="javascript:;">Level 1</a>
              <span class="icon-thumbnail">L1</span>
            </li>
            <li>
              <a href="javascript:;"><span class="title">Level 2</span><span class="arrow"></span></a>
              <span class="icon-thumbnail">L2</span>
              <ul class="sub-menu">
                <li>
                  <a href="javascript:;">Sub Menu</a>
                  <span class="icon-thumbnail">Sm</span>
                </li>
                <li>
                  <a href="ujavascript:;">Sub Menu</a>
                  <span class="icon-thumbnail">Sm</span>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    {{-- END SIDEBAR MENU --}}
  </nav>
  {{-- END SIDEBAR --}}
  {{-- END SIDEBPANEL--}}