@extends('WebSC.layouts.main')

@section('content')
<div class="technology">
  <div class="container">
    <div class="col-md-9 technology-left">
      <div class="tech-no">
        @forelse ($posts as $post)
        @php
          $type = $post->type;
          if ($post->type == 'article') {
            $type = 'post';
          } else if ($post->type == 'page') {
            $type = '';
          }
        @endphp
        @if ($loop->first)
          <div class="wthree">
            <h3>Pencarian "{{ _get('q') }}"</h3>
          </div>
        @endif
        <div class="wthree">
          @if ($post->cover)
            <div class="col-md-6 wthree-left wow fadeInDown" data-wow-duration=".8s" data-wow-delay=".2s">
              <div class="tch-img">
                <a href="{{ url($type . '/' . $post->slug) }}">
                  <img src="{{ $post->cover }}" class="img-responsive" alt="Gambar {{ $post->title }}">
                </a>
              </div>
            </div>
          @endif
          <div class="col-md-{{ $post->cover ? '6' : '12' }} wthree-right wow fadeInDown" data-wow-duration=".8s"
            data-wow-delay=".2s">
            <h3><a href="{{ url($type . '/' . $post->slug) }}">{{ $post->title }}</a></h3>
            {!! $type != '' ? '<h6>'.carbon($post->published_at)->isoFormat('Do MMMM YYYY').'</h6>' : '' !!}
            {{ $post->excerpt }}
            <div class="bht1"><a href="{{ url($type.'/'.$post->slug) }}">Baca</a></div>
            <div class="clearfix"></div>
          </div>
          <div class="clearfix"></div>
        </div>
        @empty
        <div class="wthree">
          <h3 class="no-data-yet">Pencarian "{{ _get('q') }}" tidak ditemukan</h3>
        </div>
        @endforelse
      </div>
    </div>
    @include('WebSC.components.sidebar')
    <div class="clearfix"></div>
  </div>
</div>
@endsection