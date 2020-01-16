<div class="banner" style="background-image:url('{{ $banners->image ?? '' }}')" {!! isset($banners->url) && $banners->url ? 'onclick="window.top.location=\''. url(($banners->url ?? '')) .'\'" style="cursor:pointer;"' : '' !!}>
  @if (isset($banners->only_image) && !$banners->only_image)
    <div class="container">
      <h2>{{ $banners->title }}</h2>
      <p>{{ $banners->description }}</p>
      {{-- <a href="{{ url($banners->url) }}">Selengkapnya</a> --}}
    </div>
  @endif
</div>