<div class="footer">
  <div class="container">
    <div class="col-md-4 footer-left wow fadeInDown" data-wow-duration=".8s" data-wow-delay=".2s">
      <h4>Tentang</h4>
      <p>{{ app('site')->description ?? '-' }}</p>
      @if (app('site')->description)
        <div class="bht1"><a href="{{ url('about') }}">Baca</a></div>
      @endif
    </div>
    <div class="col-md-4 footer-middle wow fadeInDown" data-wow-duration=".8s" data-wow-delay=".2s">
      <h4>Komentar Terbaru</h4>
      @forelse (_getComments(3) as $comment)
        <div class="mid-btm">
          <p>{{ $comment->name . ': "' . $comment->comment . '"' }} di <a href="{{ url($comment->post->slug) }}">{{ $comment->post->title }}</a></p>
        </div>
      @empty
        <p>-</p>
      @endforelse
    </div>
    <div class="col-md-4 footer-right wow fadeInDown" data-wow-duration=".8s" data-wow-delay=".2s">
      <h4>Tautan Lain</h4>
      @php $menus = getMenu('lainnya') ?? []; @endphp
      <ul>
        @forelse ($menus as $menu)
          <li>
            <a href="{{ $menu->url }}" title="{{ $menu->name }}">{{ $menu->name }}</a>
          </li>
        @empty
          <p>-</p>
        @endforelse
      </ul>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
<div class="copyright wow fadeInDown" data-wow-duration=".8s" data-wow-delay=".2s">
  <div class="container">
    <p>&copy; {{ date("Y") }} {{ app('site')->name }}. All rights reserved | Design by <a href="http://w3layouts.com/">W3layouts</a>
    </p>
  </div>
</div>
{!! _site_js('themes/WebSC/js/jquery-1.11.1.min.js') !!}
{!! _site_js('themes/WebSC/js/bootstrap.min.js') !!}
{!! _site_js('themes/WebSC/js/wow.min.js') !!}
<script>
  new WOW().init(); 
</script>
@yield('scripts')
@include('google.analytics')
</body>

</html>