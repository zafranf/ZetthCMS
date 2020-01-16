@extends('WebSC.layouts.main')

@section('content')
<div class="technology">
  <div class="container">
    <div class="col-md-9 technology-left">
      <div class="agileinfo">
        <h2 class="w3">{{ $page->title }}</h2>
        <div class="single">
          @if ($page->cover)
          <img src="{{ $page->cover }}" class="img-responsive" alt="{{ $page->title }}">
          @endif
          <div class="b-bottom">
            {!! $page->content !!}
          </div>
        </div>
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