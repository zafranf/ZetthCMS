@extends('WebSC.layouts.main')

@section('content')
  {{-- <!-- START STATUS FEED --> --}}
  <section class="articles">
    <div class="column is-6 is-offset-3">
      {{-- <!-- START ARTICLE --> --}}
      <section class="hero is-danger is-bold is-small promo-block">
        <div class="hero-body">
          <div class="container">
            <h1 class="title">
              <span class="has-text-white">
                <i class="fal fa-exclamation-circle"></i> 
                  Terjadi kesalahan di server!
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
    </div>
  </section>
@endsection
