<!DOCTYPE html>
<html lang="{{ app('site')->language }}">

<head>
  {!! SEOMeta::generate() !!}
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @if (!isset($status_code))
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
  <link rel="shortcut icon" href="{{ getImageLogo(app('site')->icon) }}" type="image/x-icon">
  <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
  <style>
    html,
    body {
        height: 100%;
    }
    
    body {
        margin: 0;
        padding: 0;
        width: 100%;
        display: table;
        font-weight: 100;
        font-family: 'Lato';
    }
    
    .container {
        text-align: center;
        display: table-cell;
        vertical-align: middle;
    }
    
    .content {
        text-align: center;
        display: inline-block;
    }
    
    .title {
        font-size: 56px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="content">
      <div class="logo">
        <img src="{{ getImageLogo('logo/landscape.png') }}" width="100%">
      </div>
      <div class="title">segera hadir...</div>
    </div>
  </div>
  
  @include('google.analytics')
  <!--[if]></body></html><![endif]-->
</body>

</html>