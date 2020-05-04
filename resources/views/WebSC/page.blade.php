@extends('WebSC.layouts.main')

@section('content')
  {{-- <!-- START STATUS FEED --> --}}
  <section class="articles">
    <div class="column is-10 is-offset-1">
      {{-- <!-- START ARTICLE --> --}}
      <div class="card article">
        <div class="card-content">
          <div class="media">
            <div class="media-content has-text-centered" style="margin-top:2rem;overflow:unset;">
              @if ($page->cover)
                <figure class="image is-3by1">
                  <a href="{{ url(env('POST_PATH', 'post') . '/' . $page->slug) }}" title="{{ $page->title . ' - ' . app('site')->name }}">
                    <img src="{{ getImage('/assets/images/posts/' . $page->cover) }}" alt="{{ $page->title . ' - ' . app('site')->name }}">
                  </a>
                </figure>
              @endif
              <p class="title article-title">
                <a href="{{ url(env('POST_PATH', 'post') . '/' . $page->slug) }}" title="{{ $page->title . ' - ' . app('site')->name }}" class="has-text-danger">{{ $page->title }}</a>
              </p>
            </div>
          </div>
          <div class="content article-body">
            {!! $page->content !!}

            @if (bool(app('site')->enable_share) && bool($page->enable_share))
              <div class="buttons">
                <a class="button" style="border:0;padding:0;">
                  <span>Sebar:</span>
                </a>
                <a href="{{ url('/action/share/' . $page->slug . '/facebook') }}" target="_blank" class="button button-socmed is-facebook">
                  <span class="icon">
                    <i class="fab fa-facebook-f"></i>
                  </span>
                  @if (app('is_desktop'))
                    <span>Facebook</span>
                  @endif
                </a>
                <a href="{{ url('/action/share/' . $page->slug . '/twitter') }}" target="_blank" class="button button-socmed is-twitter">
                  <span class="icon">
                    <i class="fab fa-twitter"></i>
                  </span>
                  @if (app('is_desktop'))
                    <span>Twitter</span>
                  @endif
                </a>
                <a href="{{ url('/action/share/' . $page->slug . '/whatsapp') }}" target="_blank" class="button button-socmed is-whatsapp">
                  <span class="icon">
                    <i class="fab fa-whatsapp"></i>
                  </span>
                  @if (app('is_desktop'))
                    <span>WhatsApp</span>
                  @endif
                </a>
                <a href="{{ url('/action/share/' . $page->slug . '/telegram') }}" target="_blank" class="button button-socmed is-telegram">
                  <span class="icon">
                    <i class="fab fa-telegram-plane"></i>
                  </span>
                  @if (app('is_desktop'))
                    <span>Telegram</span>
                  @endif
                </a>
                <a class="button is-copy">
                  <span class="icon">
                    <i class="fad fa-link"></i>
                  </span>
                  @if (app('is_desktop'))
                    <span>Salin Tautan</span>
                  @endif
                </a>
              </div>
            @endif
          </div>
        </div>
      </div>
      {{-- <!-- END ARTICLE --> --}}
    </div>
  </section>
  {{-- <!-- END STATUS FEED --> --}}
@endsection