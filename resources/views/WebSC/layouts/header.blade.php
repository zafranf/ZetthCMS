<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="id">

<head>
  {!! SEOMeta::generate() !!}
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @if (!isset($status_code))
    <meta name="robots" content="index, follow">
  @endif
  {{-- Open Graph SEO --}}
  {!! OpenGraph::generate() !!}
  @if(!empty($page_title))
    {!! Twitter::generate() !!}
  @endif
  {{-- <meta name="keywords" content="{{ app('site')->keywords }}">
  <meta name="description" content="{{ app('site')->description }}"> --}}
  {{-- <title>{{ (!empty($page_title) ? $page_title . ' | ' : '') . app('site')->name }}</title> --}}
  <link rel="shortcut icon" href="{{ _get_image("assets/images/" . app('site')->icon, url("themes/admin/AdminSC/images/logo.v2.png")) }}" type="image/x-icon">
  {{-- Styles --}}
  <link href="https://fonts.googleapis.com/css?family=Raleway:400,600,700" rel="stylesheet" type="text/css">
  {!! _site_css('themes/WebSC/css/bootstrap.min.css') !!}
  {!! _site_css('themes/WebSC/css/font-awesome.min.css') !!}
  {!! _site_css('themes/WebSC/css/style.css') !!}
  {!! _site_css('themes/WebSC/css/animate.min.css') !!}
  @yield('styles')
</head>

<body>
  <div class="header" id="ban">
    <div class="container">
      <div data-wow-delay=".5s" class="head-left wow fadeInLeft animated animated">
        <div class="header-search">
          <div class="search">
            <input class="search_box" type="checkbox" id="search_box">
            <label class="icon-search" for="search_box">
              <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            </label>
            <div class="search_form">
              <form action="{{ url('/search') }}" method="get">
                <input type="text" name="q" value="{{ _get('q') }}" placeholder="Cari berita..">
                <button><i class="fa fa-search"></i></button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div data-wow-delay=".5s" class="header_right wow fadeInLeft animated animated">
        <nav class="navbar navbar-default">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
              data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
            <nav class="link-effect-7" id="link-effect-7">
              {!! generateMenu('website',[
                'main' => [
                  'wrapper' => [
                    'tag' => 'ul',
                    'class' => 'nav navbar-nav ',
                  ],
                ],
              ]) !!}
            </nav>
          </div>
        </nav>
      </div>
      <div data-wow-delay=".5s" class="nav navbar-nav navbar-right social-icons wow fadeInRight animated animated">
        <ul>
          @foreach (app('site')->socmed_data as $socmed)
          <li>
            <a href="{{ $socmed->socmed->url . '/'. $socmed->username }}" target="_blank" title="{{ $socmed->socmed->name. ': ' . $socmed->username }}">
              <i class="{{ $socmed->socmed->icon }}"></i>
            </a>
          </li>
          @endforeach
        </ul>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
  <div class="header-bottom">
    <div class="container">
      <div class="logo wow fadeInDown" data-wow-duration=".8s" data-wow-delay=".2s">
        <h1><a href="{{ url('/') }}">{{ app('site')->name }}</a></h1>
        @if (!empty(app('site')->tagline))
          <p><label class="of"></label>{{ app('site')->tagline }}<label class="on"></label></p>
        @endif
      </div>
    </div>
  </div>