@if (in_array(_server('SERVER_NAME'), [env('APP_DOMAIN'), 'www.'.env('APP_DOMAIN')]) )
  {{-- Global site tag (gtag.js) - Google Analytics --}}
  <script async src="https://www.googletagmanager.com/gtag/js?id={{ app('site')->google_analytics }}"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '{{ app('site')->google_analytics }}');
  </script>
@endif