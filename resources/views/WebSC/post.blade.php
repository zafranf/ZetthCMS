@extends('WebSC.layouts.main')

@section('content')
  @php
    $author = $post->author;
    $dislike = $like = false;
    if (app('user') && isset($post->likes_user->like)) {
      $like = $post->likes_user->like;
      $dislike = !$post->likes_user->like;
    }
  @endphp
  {{-- <!-- START STATUS FEED --> --}}
  <section class="articles">
    <div class="column is-10 is-offset-1">
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
            <div class="media-content has-text-centered" {!! $author && !$author->image ? 'style="margin-top:2rem;overflow:unset;"' : '' !!}>
              @if ($post->cover)
                <figure class="image is-3by1">
                  <img src="{{ getImage('/assets/images/posts/' . $post->cover) }}" alt="{{ $post->title . ' - ' . app('site')->name }}">
                </figure>
                <p class="has-text-grey has-text-left is-italic">{{ $post->caption }}</p>
              @endif
              <p class="title article-title">
                <a href="{{ url(config('path.post') . '/' . $post->slug) }}" title="{{ $post->title . ' - ' . app('site')->name }}" class="has-text-danger">{{ $post->title }}</a>
              </p>
              <p class="subtitle is-6 article-subtitle">
                <a href="{{ url(config('path.author') . '/' . $author->name) }}" class="has-text-danger" title="Penulis">
                  {{ $author->fullname }}
                </a> pada <span title="Tanggal terbit">{{ $post->published_string }}</a>
                @forelse ($post->categories as $category)
                  @if ($loop->first)
                    <br>
                    di 
                  @endif
                  <a href="{{ url(config('path.category') . '/' . $category->slug) }}" class="has-text-danger" title="Kategori">{{ $category->name }}</a>{{ !$loop->last ? ',' : '' }}
                @empty
                @endforelse
              </p>
            </div>
          </div>
          <div class="content article-body">
            {!! $post->content !!}

            <div class="tags has-addons level-item" style="justify-content:unset;">
              @foreach ($post->tags as $tag)
                <span class="tag is-medium is-danger">
                  <a href="{{ url(config('path.tag') . '/' . $tag->slug) }}" class="has-text-white" title="Label">#{{ $tag->name }}</a>
                </span>
              @endforeach
            </div>

            @if (bool(app('site')->enable_like) && bool($post->enable_like))
              <div class="buttons">
                <button id="btn-like" class="button has-background-white-bis {{ $like ? 'has-text-primary' : '' }}">
                  <span class="icon">
                    <i class="fad fa-thumbs-up"></i>
                  </span>
                  <span class="count">{{ $post->liked }}</span>
                </button>
                <button id="btn-dislike" class="button has-background-white-bis {{ $dislike ? 'has-text-danger' : '' }}">
                  <span class="icon">
                    <i class="fad fa-thumbs-down"></i>
                  </span>
                  <span class="count">{{ $post->disliked }}</span>
                </button>
              </div>
            @endif

            @if (bool(app('site')->enable_share) && bool($post->enable_share))
              <div class="buttons">
                <a class="button" style="border:0;padding:0;">
                  <span>Sebar:</span>
                </a>
                <a href="{{ url('/action/share/' . $post->slug . '/facebook') }}" target="_blank" class="button button-socmed is-facebook">
                  <span class="icon">
                    <i class="fab fa-facebook-f"></i>
                  </span>
                  @if (app('is_desktop'))
                    <span>Facebook</span>
                  @endif
                </a>
                <a href="{{ url('/action/share/' . $post->slug . '/twitter') }}" target="_blank" class="button button-socmed is-twitter">
                  <span class="icon">
                    <i class="fab fa-twitter"></i>
                  </span>
                  @if (app('is_desktop'))
                    <span>Twitter</span>
                  @endif
                </a>
                <a href="{{ url('/action/share/' . $post->slug . '/whatsapp') }}" target="_blank" class="button button-socmed is-whatsapp">
                  <span class="icon">
                    <i class="fab fa-whatsapp"></i>
                  </span>
                  @if (app('is_desktop'))
                    <span>WhatsApp</span>
                  @endif
                </a>
                <a href="{{ url('/action/share/' . $post->slug . '/telegram') }}" target="_blank" class="button button-socmed is-telegram">
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

  @if (bool(app('site')->enable_comment) && bool($post->enable_comment))
    {{-- <!-- START COMMENT SECTION --> --}}
    <section id="comments" class="articles">
      <div class="column is-10 is-offset-1">
        <div class="card article">
          <div class="card-content">
            <h1 class="title article-title has-border-grey-lighter" style="border-bottom:1px solid #ccc;">
              <a href="#comments" class="has-text-dark">Komentar</a>
            </h1>
            @if (session('success'))
              <div class="notification is-success has-text-left">
                Komentar berhasil terkirim dan menunggu persetujuan penulis untuk ditampilkan!
              </div>
            @endif

            @if (count($post->comments_sub))
              @foreach ($post->comments_sub as $comment)
                @php
                  $commentator = $comment->commentator;
                @endphp
                {{-- Start Comment Parent --}}
                <article id="comment-{{ md5($comment->id . env('DB_PORT', 3306)) }}" class="media">
                  <figure class="media-left">
                    <p class="image is-64x64">
                      <img class="is-rounded" src="{{ getImageUser($commentator->image ?? '') }}">
                    </p>
                  </figure>
                  <div class="media-content">
                    <div class="content">
                      <p style="margin:5px 0;"><strong>{{ $commentator->fullname }}</strong></p>
                      {!! $comment->content !!}
                      <p><small><a onclick="reply({{ $comment->id }}, '{{ $commentator->fullname }}')" class="has-text-danger">Balas</a> · {{ carbon($comment->created_at)->diffForHumans() }}</small></p>
                    </div>
                
                    @if (count($comment->subcomments))
                      @foreach ($comment->subcomments as $subcomment)
                        @php
                          $subcommentator = $subcomment->commentator;
                        @endphp
                        {{-- Start Comment Child --}}
                        <article id="comment-{{ md5($subcomment->id . env('DB_PORT', 3306)) }}" class="media">
                          <figure class="media-left">
                            <p class="image is-48x48">
                              <img class="is-rounded" src="{{ getImageUser($subcommentator->image ?? '') }}">
                            </p>
                          </figure>
                          <div class="media-content">
                            <div class="content">
                              <p style="margin:5px 0;"><strong>{{ $subcommentator->fullname }}</strong></p>
                              {!! $subcomment->content !!}
                              <p><small><a onclick="reply({{ $subcomment->parent_id }}, '{{ $subcommentator->fullname }}')" class="has-text-danger">Balas</a> · {{ carbon($subcomment->created_at)->diffForHumans() }}</small></p>
                            </div>
                          </div>
                        </article>
                        {{-- End Comment Child --}}
                      @endforeach
                    @endif
                  </div>
                </article>
                {{-- End Comment Parent --}}
              @endforeach
            @endif

            @if (Auth::guest())
              <article class="media">
                <div class="media-content">
                  Silakan <a class="tag is-danger is-medium" href="{{ route('web.login') }}">Masuk</a> untuk dapat memberikan komentar.
                </div>
              </article>
            @else
              {{-- Start Comment Form --}}
              <article id="comment-form" class="media">
                <figure class="media-left">
                  <p class="image is-64x64">
                    <img class="is-rounded" src="{{ getImageUser() }}">
                  </p>
                </figure>
                <div class="media-content">
                  <form method="post" action="{{ route('web.action.comment') }}">
                    <div class="field">
                      <div class="control">
                        <div class="info-reply is-hidden">
                          Balas komentar <span class="tag is-danger is-light is-medium">
                            <span class="reply-name"></span>&nbsp;
                            <button type="button" onclick="clear_reply()" class="delete is-small"></button>
                          </span>
                        </div>
                        <textarea name="comment" class="textarea" placeholder="Ketikkan komentar Anda di sini..."></textarea>
                      </div>
                    </div>
                    <div class="field">
                      <input class="is-checkradio is-danger" type="checkbox" id="notify" name="notify" checked="checked" value="yes">
                      <label for="notify">Terima notifikasi balasan</label>
                    </div>
                    <div class="field">
                      <div class="control">
                        @csrf
                        <input type="hidden" name="slug" value="{{ $post->slug }}">
                        <input type="hidden" name="reply_to">
                        <button class="button is-danger">Kirim!</button>
                      </div>
                    </div>
                  </form>
                </div>
              </article>
              {{-- End Comment Form --}}
            @endif
          </div>
        </div>
      </div>
    </section>
    {{-- <!-- END COMMENT SECTION --> --}}
  @endif
@endsection

@push('styles')
  <style>
    #comments {
      margin: unset;
    }
    #comments .card.article:first-child {
      margin: unset;
    }
    #comments .media-content {
      margin-top: unset!important;
    }
    #comments .content p {
      /* margin: unset!important; */
    }
    .info-reply {
      margin-bottom: 5px;
    }
    .clear-reply {
      color: unset;
    }

    .bg-color-fading {
      animation: fade 3s forwards;
      background-color: #fffabc;
    }

    @keyframes fade {
      from {background-color: #fffabc;}
      to {background-color: transparent;}
    }
  </style>
@endpush

@push('scripts')
  <script>
    $('document').ready(function() {
      $('#btn-like').on('click', function() {
        @if (Auth::guest())
          window.top.location.href = "{{ route('web.login') }}";
        @else
          $('#btn-like').addClass('is-loading');
          $.ajax({
              type: "POST",
              url: "{{ route('web.action.like') }}",
              data: {
                post: "{{ $post->slug }}"
              }
          }).done(function(result) {
            $('#btn-like').removeClass('is-loading').blur();
            if ($('#btn-like').hasClass('has-text-primary')) {
              $('#btn-like').removeClass('has-text-primary');
            } else {
              $('#btn-like').addClass('has-text-primary');
            }
            $('#btn-like .count').text(result.data.like);
            $('#btn-dislike .count').text(result.data.dislike);
            $('#btn-dislike').removeClass('has-text-danger');
            console.log(result);
          });
        @endif
      });

      $('#btn-dislike').on('click', function() {
        @if (Auth::guest())
          window.top.location.href = "{{ route('web.login') }}";
        @else
          $('#btn-dislike').addClass('is-loading');
          $.ajax({
              type: "POST",
              url: "{{ route('web.action.dislike') }}",
              data: {
                post: "{{ $post->slug }}"
              }
          }).done(function(result) {
            $('#btn-dislike').removeClass('is-loading').blur();
            if ($('#btn-dislike').hasClass('has-text-danger')) {
              $('#btn-dislike').removeClass('has-text-danger');
            } else {
              $('#btn-dislike').addClass('has-text-danger');
            }
            $('#btn-like .count').text(result.data.like);
            $('#btn-dislike .count').text(result.data.dislike);
            $('#btn-like').removeClass('has-text-primary');
            console.log(result);
          });
        @endif
      });

      @if (!isset($page))
        if (window.location.hash) {
          $(window.location.hash).addClass('bg-color-fading');
        }

        $('.button.is-copy').on('click', function() {
          $('#modal').addClass('is-active');
          let url = '{{ urlencode(url(config('path.post') . '/' . $post->slug)) }}';
          let html = 'Tekan ikon untuk menyalin tautan: <div class="field has-addons"><div class="control is-expanded"><input class="input is-fullwidth" type="text" value="'+decodeURIComponent(url)+'" readonly></div><div class="control"><a onclick="copy()" class="button"><i class="fad fa-copy"></i></a></div></div>';
          $('.modal-card-title').text('Salin Tautan');
          $('.modal-card-body').html(html);
          $('.modal-card-foot').hide();
        });
      @endif
    });

    function reply(comment_id, name) {
      @if (Auth::guest())
        window.top.location.href = "{{ route('web.login') }}";
      @else
        $('input[name=reply_to]').val(comment_id);
        $('.info-reply').removeClass('is-hidden');
        $('.info-reply .reply-name').text(name);
        /* $("html").scrollTop($('#comment-form').offset().top); */
        $('textarea[name=comment]').focus();
      @endif
    }

    function clear_reply() {
      $('input[name=reply_to]').val('');
      $('.info-reply').addClass('is-hidden');
      $('.info-reply .reply-name').text('');
    }

    function copy() {
      $('.modal-card-body input').select();
      try {
        setTimeout(function() {
          document.execCommand('copy');
          setTimeout(function() {
            alert('Tautan berhasil disalin!');
          }, 10);
        }, 10);
      } catch(e) {}
    }
  </script>
@endpush