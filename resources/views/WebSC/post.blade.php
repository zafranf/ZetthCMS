@extends('WebSC.layouts.main')

@section('content')
<div class="technology">
  <div class="container">
    <div class="col-md-9 technology-left">
      <div class="agileinfo">
        <h2 class="w3">{{ $post->title }}</h2>
        <div class="single">
          @if ($post->cover)
          <img src="{{ $post->cover }}" class="img-responsive" alt="{{ $post->title }}">
          @endif
          <div class="b-bottom">
            {!! $post->content !!}
            <p style="margin-top:10px;font-size:small;">
              {{ carbon($post->published_at)->isoFormat('Do MMMM YYYY') }}
              {{-- <a class="span_link" href="#">
                <span class="glyphicon glyphicon-comment"></span>0
              </a> --}}
              <a class="span_link">
                <span class="glyphicon glyphicon-eye-open"></span> {{ $post->visited }}
              </a>
            </p>
          </div>
        </div>

        {{-- <div class="response">
          <h4>Responses</h4>
          <div class="media response-info">
            <div class="media-left response-text-left">
              <a href="#">
                <img src="images/sin1.jpg" class="img-responsive" alt="">
              </a>
            </div>
            <div class="media-body response-text-right">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,There are many variations of
                passages of Lorem Ipsum available,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
              <ul>
                <li>Jun 21, 2016</li>
                <li><a href="#">Reply</a></li>
              </ul>
              <div class="media response-info">
                <div class="media-left response-text-left">
                  <a href="#">
                    <img src="images/sin2.jpg" class="img-responsive" alt="">
                  </a>
                </div>
                <div class="media-body response-text-right">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,There are many
                    variations of passages of Lorem Ipsum available,
                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                  <ul>
                    <li>July 17, 2016</li>
                    <li><a href="#">Reply</a></li>
                  </ul>
                </div>
                <div class="clearfix"> </div>
              </div>
            </div>
            <div class="clearfix"> </div>
          </div>
          <div class="media response-info">
            <div class="media-left response-text-left">
              <a href="#">
                <img src="images/sin1.jpg" class="img-responsive" alt="">
              </a>
            </div>
            <div class="media-body response-text-right">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,There are many variations of
                passages of Lorem Ipsum available,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
              <ul>
                <li>Jul 22, 2016</li>
                <li><a href="#">Reply</a></li>
              </ul>
              <div class="media response-info">
                <div class="media-left response-text-left">
                  <a href="#">
                    <img src="images/sin2.jpg" class="img-responsive" alt="">
                  </a>
                </div>
                <div class="media-body response-text-right">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,There are many
                    variations of passages of Lorem Ipsum available,
                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                  <ul>
                    <li>Aug 01, 2016</li>
                    <li><a href="#">Reply</a></li>
                  </ul>
                </div>
                <div class="clearfix"> </div>
              </div>
            </div>
            <div class="clearfix"> </div>
          </div>
        </div>
        <div class="coment-form">
          <h4>Leave your comment</h4>
          <form action="#" method="post">
            <input type="text" value="Name " name="name" onfocus="this.value = '';"
              onblur="if (this.value == '') {this.value = 'Name';}" required="">
            <input type="email" value="Email" name="email" onfocus="this.value = '';"
              onblur="if (this.value == '') {this.value = 'Email';}" required="">
            <input type="text" value="Website" name="websie" onfocus="this.value = '';"
              onblur="if (this.value == '') {this.value = 'Website';}" required="">
            <textarea onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Your Comment...';}"
              required="">Your Comment...</textarea>
            <input type="submit" value="Submit Comment">
          </form>
        </div> --}}
        <div class="clearfix"></div>
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
    margin-bottom: 1em;
  }
</style>
@endsection