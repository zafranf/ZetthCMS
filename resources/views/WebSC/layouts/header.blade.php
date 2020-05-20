<!DOCTYPE html>
<html lang="{{ app('site')->lang }}" class="has-navbar-fixed-top">

<head>
  {!! SEOMeta::generate() !!}
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @if (!isset($status_code) && Request::path() != 'profile/edit')
    <meta name="robots" content="index, follow">
  @else
    <meta name="robots" content="none">
  @endif
  {{-- Open Graph SEO --}}
  {!! OpenGraph::generate() !!}
  @if (!empty($page_title))
    {!! Twitter::generate() !!}
  @endif
  <meta name="theme-color" content="#df342f">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ getImageLogo(app('site')->icon) }}" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  {!! _site_css('themes/WebSC/css/styles.css') !!}
  @stack('styles')
</head>

<body>