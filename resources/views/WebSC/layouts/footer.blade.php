
    {{-- <!-- START FOOTER --> --}}
    <footer class="footer">
      <div class="container">
        <div class="content has-text-grey has-text-centered">
          <a href="#{{-- {{ _url('/tentang') }} --}}" class="has-text-danger">Tentang</a> |
          <a href="#{{-- {{ _url('/kontak') }} --}}" class="has-text-danger">Kontak</a>  | 
          <a href="#{{-- {{ _url('/sangkalan') }} --}}" class="has-text-danger">Sangkalan</a> | 
          <a href="#{{-- {{ _url('/pp') }} --}}" class="has-text-danger">Kebijakan Privasi</a> | 
          <a href="#{{-- {{ _url('/psd') }} --}}" class="has-text-danger">PSD</a> 
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

    {{-- <button class="button is-primary is-large modal-button" data-target="modal" aria-haspopup="true">Launch example modal</button> --}}
    {{-- <!-- START MODAL --> --}}
    <div id="modal" class="modal">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Modal title</p>
          <button class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <!-- Content ... -->
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success">Save changes</button>
          <button class="button">Cancel</button>
        </footer>
      </div>
    </div>
    {{-- <!-- END MODAL --> --}}

    <script defer src="https://pro.fontawesome.com/releases/v5.12.1/js/all.js" integrity="sha384-RiuSF/PBDHssKXqYfH16Hw3famw7Xg29hNO7Lg636dZXUg42q2UtNLPsGfihOxT9" crossorigin="anonymous"></script>
    {!! _site_js('themes/WebSC/js/scripts.js') !!}
    @stack('scripts')
    @include('google.analytics')
    {{-- <!-- Go to www.addthis.com/dashboard to customize your tools --> --}}
    {{-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5e7b16825b2feb44"></script> --}}
<!--[if]>
</body></html>
<![endif]-->
</body>
</html>