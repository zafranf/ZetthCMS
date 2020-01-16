@if (in_array(_server('SERVER_NAME'), [env('APP_DOMAIN'), 'www.'.env('APP_DOMAIN')]) &&
env('GOOGLE_ANALYTICS_CODE'))
{{-- Global site tag (gtag.js) - Google Analytics --}}
<script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_ANALYTICS_CODE') }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{ env('GOOGLE_ANALYTICS_CODE') }}');
</script>
@endif