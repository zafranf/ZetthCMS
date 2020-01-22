<div class="col-md-3 technology-right">
  <div class="blo-top1">
    <div class="tech-btm">
      <div class="search-1 wow fadeInDown" data-wow-duration=".8s" data-wow-delay=".2s">
        <form action="{{ url('/search') }}"><input type="search" name="q" value="{{ _get('q') }}" placeholder="Cari berita..">
          <input type="submit" value=" ">
        </form>
      </div>
      <h4>Berita Hangat</h4>
      @forelse (_getPopularPosts(5) as $pop)
        <div class="blog-grids wow fadeInDown" data-wow-duration=".8s" data-wow-delay=".2s">
          @if ($pop->post->cover)
          <div class="blog-grid-left">
            <a href="{{ '/post/' . $pop->post->slug }}">
              <img src="{{ $pop->post->cover }}" class="img-responsive" alt="{{ $pop->post->title }}">
            </a>
          </div>
          @endif
          <div class="blog-grid-right" {!! empty($pop->post->cover) ? 'style="width:100%"' : '' !!}>
            <h5><a href="{{ '/post/' . $pop->post->slug }}">{{ $pop->post->title }}</a></h5>
          </div>
          <div class="clearfix"></div>
        </div>
      @empty
        <div class="blog-grids wow fadeInDown">
          <h3 class="no-data-yet">Belum ada berita</h3>
        </div>
      @endforelse
      <div class="insta wow fadeInDown" data-wow-duration=".8s" data-wow-delay=".2s">
        <h4>Koleksi Foto</h4>
        @php
          $photos = _getPhotos(9)
        @endphp
        @if (count($photos) > 0)
          <ul>
            @foreach ($photos as $photo)
              <li>
                <a href="singlepage.html">
                  <img src="themes/WebSC/images/t1.jpg" class="img-responsive" alt="">
                </a>
              </li>
            @endforeach
          </ul>
        @else
          <h3 class="no-data-yet">Belum ada foto</h3>
        @endif
      </div>
    </div>
  </div>
</div>