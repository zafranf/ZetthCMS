<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="icon" href="{{ _get_image('/images/' . $apps->logo) }}" type="image/x-icon"/>
  <link rel="shortcut icon" type="image/x-icon" href="{{ _get_image('/images/' . $apps->logo) }}" />
  <title>{{ $page_title }} | {{ $apps->name }}</title>

  {{-- Fonts --}}
  <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400" rel='stylesheet' type='text/css'>
  {!! _load_css('themes/admin/AdminSC/plugins/fontawesome-4.6.3/css/bootstrap.min.css') !!}

  {{-- Styles --}}
  {!! _load_css('themes/admin/AdminSC/plugins/bootstrap-3.3.6/css/bootstrap.min.css') !!}
  @yield('styles')
  {!! _load_css('themes/admin/AdminSC/css/app.css') !!}
</head>

<body id="app-layout">