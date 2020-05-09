@extends('WebSC.layouts.main')

@section('content')
  {{-- <!-- START STATUS FEED --> --}}
  <section class="articles">
    <div class="column is-10 is-offset-1">
      {{-- <!-- START PROMO BLOCK -->
      <section class="hero is-primary is-bold is-small promo-block">
        <div class="hero-body">
          <div class="container">
            <h1 class="title">
              <i class="fal fa-bell"></i> 
              Nemo enim ipsam voluptatem quia.
            </h1>
            <span class="tag is-black is-large is-rounded">
              <i class="fal fa-exclamation-circle"></i>
              &nbsp;Natus error sit voluptatem
            </span>
          </div>
        </div>
      </section>
      <!-- END PROMO BLOCK --> --}}
      @forelse ($posts as $post)
        @php
          $author = $post->author;
        @endphp
        {{-- <!-- START ARTICLE --> --}}
        <div class="card article">
          <div class="card-content">
            <div class="media">
              @if ($author->image)
                <div class="media-center" style="z-index:2;">
                  <a href="{{ url(config('path.author') . '/' . $author->name) }}" title="Penulis: {{ $author->fullname }}">
                    <img src="{{ getImageUser($author->image ?? '') }}" class="author-image" alt="Penulis: {{ $author->fullname }}" title="Penulis: {{ $author->fullname }}">
                  </a>
                </div>
              @endif
              <div class="media-content has-text-centered" {!! !$author->image ? 'style="margin-top:2rem;overflow:unset;"' : '' !!}>
                @if ($post->cover)
                  <figure class="image is-3by1">
                    <a href="{{ url(config('path.post') . '/' . $post->slug) }}" title="{{ $post->title . ' - ' . app('site')->name }}">
                      <img src="{{ getImage('/assets/images/posts/' . $post->cover) }}" alt="{{ $post->title . ' - ' . app('site')->name }}" title="{{ $post->title . ' - ' . app('site')->name }}">
                    </a>
                  </figure>
                @endif
                <p class="title article-title">
                  <a href="{{ url(config('path.post') . '/' . $post->slug) }}" title="{{ $post->title . ' - ' . app('site')->name }}" class="has-text-danger">{{ $post->title }}</a>
                </p>
                <div class="tags has-addons level-item">
                  <span class="tag is-rounded is-danger" title="Penulis: {{ $author->fullname }}">
                    <a href="{{ url(config('path.author') . '/' . $author->name) }}" title="Penulis: {{ $author->fullname }}" class="has-text-white">
                      {{ $author->fullname }}
                    </a>
                  </span>
                  <span class="tag is-rounded has-text-grey-light" title="Tanggal terbit: {{ $post->published_string }}">
                    {{ carbon($post->published_at)->isoFormat('Do MMMM YYYY') }}
                  </span>
                </div>
                <p class="subtitle is-6 article-subtitle">
                  di 
                  @foreach ($post->categories as $category)
                    <a href="{{ url(config('path.category') . '/' . $category->slug) }}" class="has-text-danger" title="Kategori">{{ $category->name }}</a>{{ !$loop->last ? ',' : '' }}
                  @endforeach
                </p>
              </div>
            </div>
            <div class="content article-body">
              {{ $post->excerpt }}
              <br><br>
              <a href="{{ url(config('path.post') . '/' . $post->slug) }}" title="{{ $post->title .' - ' . app('site')->name }}" class="button is-danger">Baca lengkap</a>
            </div>
          </div>
        </div>
        {{-- <!-- END ARTICLE --> --}}
      @empty
        {{-- <!-- START ARTICLE --> --}}
        <section class="hero is-warning is-bold is-small promo-block">
          <div class="hero-body">
            <div class="container">
              <h1 class="title">
                <span class="has-text-white">
                  <i class="fal fa-exclamation-circle"></i> 
                  @if (in_array(Request::segment(1), [config('path.search')]))
                    Pencarian artikel dengan kata "{{ Request::input('q') }}" tidak ditemukan.
                  @elseif (Request::segment(1) === null || in_array(Request::segment(1), [config('path.articles')]))
                    Belum ada data artikel.
                  @else
                    Artikel dari {{ Request::segment(1) }} "{{ Request::segment(2) }}" tidak ditemukan.
                  @endif
                </span>
              </h1>
              {{-- <span class="tag is-black is-large is-rounded">
                <i class="fal fa-exclamation-circle"></i>
                &nbsp;Natus error sit voluptatem
              </span> --}}
            </div>
          </div>
        </section>
        {{-- <!-- END ARTICLE --> --}}
      @endforelse
      {{-- <!-- START ARTICLE -->
      <div class="card article">
        <div class="card-content">
          <div class="media">
            <div class="media-center">
              <img src="http://www.radfaces.com/images/avatars/daria-morgendorffer.jpg" class="author-image" alt="Placeholder image">
            </div>
            <div class="media-content has-text-centered">
              <p class="title article-title">Sapien eget mi proin sed 🔱</p>
              <p class="subtitle is-6 article-subtitle">
                <a href="#">@daria</a> on February 17, 2018
              </p>
            </div>
          </div>
          <div class="content article-body">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Accumsan lacus vel facilisis volutpat est velit egestas. Sapien eget mi proin sed. Sit amet mattis vulputate enim.
            </p>
            <p>
                Commodo ullamcorper a lacus vestibulum sed arcu. Fermentum leo vel orci porta non. Proin fermentum leo vel orci porta non pulvinar. Imperdiet proin fermentum leo vel. Tortor posuere ac ut consequat semper viverra. Vestibulum lectus mauris ultrices eros.
            </p>
            <h3 class="has-text-centered">Lectus vestibulum mattis ullamcorper velit sed ullamcorper morbi. Cras tincidunt lobortis feugiat vivamus.</h3>
            <p>
                In eu mi bibendum neque egestas congue quisque egestas diam. Enim nec dui nunc mattis enim ut tellus. Ut morbi tincidunt augue interdum velit euismod in. At in tellus integer feugiat scelerisque varius morbi enim nunc. Vitae suscipit tellus mauris a diam.
                Arcu non sodales neque sodales ut etiam sit amet.
            </p>
          </div>
        </div>
      </div>
      <!-- END ARTICLE --> --}}

      {{ $posts->onEachSide(2)->links('WebSC.components.pagination') }}
    </div>
  </section>
  {{-- <!-- END STATUS FEED --> --}}
@endsection