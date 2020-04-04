

    {{-- <!-- START FOOTER --> --}}
    <footer class="footer">
      <div class="container">
        <div class="content has-text-grey has-text-centered">
          <a href="#{{-- {{ url('/tentang') }} --}}" class="has-text-danger">Tentang</a> |
          <a href="#{{-- {{ url('/kontak') }} --}}" class="has-text-danger">Kontak</a>  | 
          <a href="#{{-- {{ url('/sangkalan') }} --}}" class="has-text-danger">Sangkalan</a> | 
          <a href="#{{-- {{ url('/pp') }} --}}" class="has-text-danger">Kebijakan Privasi</a> | 
          <a href="#{{-- {{ url('/psd') }} --}}" class="has-text-danger">PSD</a> 
          <br>
          <small class="has-text-grey-light">
            2020 &copy; {{ app('site')->name }}.
            Templat oleh
            <a href="https://bulmatemplates.github.io/bulma-templates/" target="_blank" class="has-text-grey">Bulma Templates</a>.
          </small>
        </div>
      </div>
    </footer>
    {{-- <!-- END FOOTER --> --}}
  </div>
    <script defer src="https://pro.fontawesome.com/releases/v5.12.1/js/all.js" integrity="sha384-RiuSF/PBDHssKXqYfH16Hw3famw7Xg29hNO7Lg636dZXUg42q2UtNLPsGfihOxT9" crossorigin="anonymous"></script>
    {!! _site_js('themes/WebSC/js/scripts.js') !!}
    @yield('scripts')
    @include('google.analytics')
<!--[if]>
</body></html>
<![endif]-->
</body>
</html>