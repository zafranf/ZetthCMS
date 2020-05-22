@php
  $height = app('is_desktop') ? 'height:400px;' : 'height:110px;';
  $banner_style = 'style="margin-bottom:50px;background:white url(\''.getImage('assets/images/banners/'.$banners->image).'\') no-repeat center!important;border-bottom:1px solid #f1f1f1;';
  // if (app('is_mobile')) {
    $banner_style .= 'background-size:contain!important;';
  // }
  $banner_style .= $height;
@endphp
@if ($banners->url!='#')
  @php
    $banner_link = ' onclick="window.top.location=\''. _url($banners->url) .'\'"';
    $banner_style .= 'cursor:pointer;';  
  @endphp
@endif
@php
  $banner_style .= '"';
@endphp
<section class="hero is-info is-medium is-bold" {!! $banner_style . ($banner_link ?? '') !!}>
  @if (!bool($banners->only_image))
    <div class="hero-body">
      <div class="container has-text-centered">
        <h1 class="title">{{ $banners->title }}</h1>
        <p>{{ $banners->description }}</p>
      </div>
    </div>
  @endif
</section>