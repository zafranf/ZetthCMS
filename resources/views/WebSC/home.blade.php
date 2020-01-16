@extends('WebSC.layouts.main')

@section('content')
@include('WebSC.components.banner')
{{-- <div class="services w3l wow fadeInDown" data-wow-duration=".8s" data-wow-delay=".2s">
        <div class="container">
            <div class="grid_3 grid_5">
                <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#expeditions" id="expeditions-tab" role="tab"
                                data-toggle="tab" aria-controls="expeditions" aria-expanded="true">FASHION</a></li>
                        <li role="presentation" class=""><a href="#safari" role="tab" id="safari-tab" data-toggle="tab"
                                aria-controls="safari">TRAVEL</a></li>
                        <li role="presentation" class=""><a href="#trekking" role="tab" id="trekking-tab"
                                data-toggle="tab" aria-controls="trekking">MUSIC</a></li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade" id="expeditions" aria-labelledby="expeditions-tab">
                            <div class="col-md-4 col-sm-5 tab-image"><img src="themes/WebSC/images/f2.jpg"
                                    class="img-responsive" alt="Wanderer"></div>
                            <div class="col-md-4 col-sm-5 tab-image"><img src="themes/WebSC/images/f4.jpg"
                                    class="img-responsive" alt="Wanderer"></div>
                            <div class="col-md-4 col-sm-5 tab-image"><img src="themes/WebSC/images/f3.jpg"
                                    class="img-responsive" alt="Wanderer"></div>
                            <div class="clearfix"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="safari" aria-labelledby="safari-tab">
                            <div class="col-md-4 col-sm-5 tab-image"><img src="themes/WebSC/images/t1.jpg"
                                    class="img-responsive" alt="Wanderer"></div>
                            <div class="col-md-4 col-sm-5 tab-image"><img src="themes/WebSC/images/t2.jpg"
                                    class="img-responsive" alt="Wanderer"></div>
                            <div class="col-md-4 col-sm-5 tab-image"><img src="themes/WebSC/images/t3.jpg"
                                    class="img-responsive" alt="Wanderer"></div>
                            <div class="clearfix"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade active in" id="trekking"
                            aria-labelledby="trekking-tab">
                            <div class="col-md-4 col-sm-5 tab-image"><img src="themes/WebSC/images/m2.jpg"
                                    class="img-responsive" alt="Wanderer"></div>
                            <div class="col-md-4 col-sm-5 tab-image"><img src="themes/WebSC/images/m1.jpg"
                                    class="img-responsive" alt="Wanderer"></div>
                            <div class="col-md-4 col-sm-5 tab-image"><img src="themes/WebSC/images/m3.jpg"
                                    class="img-responsive" alt="Wanderer"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
<div class="technology">
  <div class="container">
    <div class="col-md-9 technology-left">
      <div class="tech-no">
        {{-- Headline!
        <div class="tc-ch wow fadeInDown" data-wow-duration=".8s" data-wow-delay=".2s">
          <div class="tch-img"><a href="singlepage.html"><img src="themes/WebSC/images/t4.jpg" class="img-responsive"
                alt=""></a></div>
          <h3><a href="singlepage.html">Lorem Ipsum is simply</a></h3>
          <h6>BY <a href="singlepage.html">ADAM ROSE </a>JULY 10 2016.</h6>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud eiusmod tempor
            incididunt ut labore et dolore magna aliqua exercitation ullamco laboris nisi ut aliquip ex
            ea commodo consequat.</p>
          <p>Ut enim ad minim veniam, quis nostrud eiusmod tempor incididunt ut labore et dolore magna
            aliqua exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          <div class="bht1"><a href="singlepage.html">Continue Reading</a></div>
          <div class="soci">
            <ul>
              <li class="hvr-rectangle-out"><a class="fb" href="#"></a></li>
              <li class="hvr-rectangle-out"><a class="twit" href="#"></a></li>
              <li class="hvr-rectangle-out"><a class="goog" href="#"></a></li>
              <li class="hvr-rectangle-out"><a class="pin" href="#"></a></li>
              <li class="hvr-rectangle-out"><a class="drib" href="#"></a></li>
            </ul>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div> --}}
        {{-- Editor Choice!
        <div class="w3ls">
          <div class="col-md-6 w3ls-left wow fadeInDown" data-wow-duration=".8s" data-wow-delay=".2s">
            <div class="tc-ch">
              <div class="tch-img"><a href="singlepage.html"><img src="themes/WebSC/images/m4.jpg" class="img-responsive"
                    alt=""></a></div>
              <h3><a href="singlepage.html">Lorem Ipsum is simply</a></h3>
              <h6>BY <a href="singlepage.html">ADAM ROSE </a>JULY 10 2016.</h6>
              <p>Ut enim ad minim veniam, quis nostrud eiusmod tempor incididunt ut labore et dolore
                magna aliqua exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
              </p>
              <div class="bht1"><a href="singlepage.html">Read More</a></div>
              <div class="soci">
                <ul>
                  <li class="hvr-rectangle-out"><a class="fb" href="#"></a></li>
                  <li class="hvr-rectangle-out"><a class="pin" href="#"></a></li>
                </ul>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="col-md-6 w3ls-left wow fadeInDown" data-wow-duration=".8s" data-wow-delay=".2s">
            <div class="tc-ch">
              <div class="tch-img"><a href="singlepage.html"><img src="themes/WebSC/images/m5.jpg" class="img-responsive"
                    alt=""></a></div>
              <h3><a href="singlepage.html">Lorem Ipsum is simply</a></h3>
              <h6>BY <a href="singlepage.html">ADAM ROSE </a>JULY 10 2016.</h6>
              <p>Ut enim ad minim veniam, quis nostrud eiusmod tempor incididunt ut labore et dolore
                magna aliqua exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
              </p>
              <div class="bht1"><a href="singlepage.html">Read More</a></div>
              <div class="soci">
                <ul>
                  <li class="hvr-rectangle-out"><a class="twit" href="#"></a></li>
                  <li class="hvr-rectangle-out"><a class="drib" href="#"></a></li>
                </ul>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="clearfix"></div>
        </div> --}}
        @forelse ($posts as $post)
          <div class="wthree">
            @if ($post->cover)
              <div class="col-md-6 wthree-left wow fadeInDown" data-wow-duration=".8s" data-wow-delay=".2s">
                <div class="tch-img">
                  <a href="{{ url('/post/' . $post->slug) }}">
                    <img src="{{ $post->cover }}" class="img-responsive" alt="Gambar {{ $post->title }}">
                  </a>
                </div>
              </div>
            @endif
            <div class="col-md-{{ $post->cover ? '6' : '12' }} wthree-right wow fadeInDown" data-wow-duration=".8s"
              data-wow-delay=".2s">
              <h3><a href="{{ url('/post/' . $post->slug) }}">{{ $post->title }}</a></h3>
              {!! '<h6>'.carbon($post->published_at)->isoFormat('Do MMMM YYYY').'</h6>' !!}
              {{ $post->excerpt }}
              <div class="bht1"><a href="{{ url('/post/' . $post->slug) }}">Baca</a></div>
              <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
          </div>
        @empty
          <div class="wthree">
            <h3 class="no-data-yet">Belum ada berita</h3>
          </div>
        @endforelse
      </div>
    </div>
    @include('WebSC.components.sidebar')
    <div class="clearfix"></div>
  </div>
</div>
@endsection