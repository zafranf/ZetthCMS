@include('admin.layouts.header')
@include('admin.layouts.sidebar')
  {{-- START PAGE-CONTAINER --}}
  <div class="page-container">
    @include('admin.layouts.topbar')
    {{-- START PAGE CONTENT WRAPPER --}}
    <div class="page-content-wrapper">
      {{-- START PAGE CONTENT --}}
      <div class="content">
        {{-- START JUMBOTRON --}}
        <div class="jumbotron" data-pages="parallax">
          <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
            <div class="inner">
              {{-- START BREADCRUMB --}}
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active">Blank template</li>
              </ol>
              {{-- END BREADCRUMB --}}
            </div>
          </div>
        </div>
        {{-- END JUMBOTRON --}}
        {{-- START CONTAINER FLUID --}}
        <div class=" container-fluid   container-fixed-lg">
          {{-- BEGIN PlACE PAGE CONTENT HERE --}}
          {{-- END PLACE PAGE CONTENT HERE --}}
        </div>
        {{-- END CONTAINER FLUID --}}
      </div>
      {{-- END PAGE CONTENT --}}
      {{-- START COPYRIGHT --}}
      {{-- START CONTAINER FLUID --}}
      {{-- START CONTAINER FLUID --}}
      <div class=" container-fluid  container-fixed-lg footer">
        <div class="copyright sm-text-center">
          <p class="small no-margin pull-left sm-pull-reset">
            <span class="hint-text">Copyright &copy; 2017 </span>
            <span class="font-montserrat">REVOX</span>.
            <span class="hint-text">All rights reserved. </span>
            <span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> <span class="muted">|</span> <a href="#" class="m-l-10">Privacy Policy</a></span>
          </p>
          <p class="small no-margin pull-right sm-pull-reset">
            Hand-crafted <span class="hint-text">&amp; made with Love</span>
          </p>
          <div class="clearfix"></div>
        </div>
      </div>
      {{-- END COPYRIGHT --}}
    </div>
    {{-- END PAGE CONTENT WRAPPER --}}
  </div>
  {{-- END PAGE CONTAINER --}}
  @include('admin.layouts.quickview')
  @include('admin.layouts.overlay')
@include('admin.layouts.footer')