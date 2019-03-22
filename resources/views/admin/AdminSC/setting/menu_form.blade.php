@extends('admin.AdminSC.layouts.main')

@section('content')
  <div class="panel-body">
    <form class="form-horizontal" action="{{ url($current_url) }}{{ isset($data->id) ? '/' . $data->id : '' }}" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Nama Menu</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="name" name="name" value="{{ isset($data->id) ? $data->name : '' }}" autofocus onfocus="_onfocus(this)" maxlength="100" placeholder="Nama menu..">
        </div>
      </div>
      <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Deskripsi</label>
        <div class="col-sm-4">
          <textarea id="description" name="description" class="form-control" placeholder="Penjelasan singkat menu.." rows="4">{{ isset($data->id) ? $data->description : '' }}</textarea>
        </div>
      </div>
      {{-- <div class="form-group">
        <label for="url" class="col-sm-2 control-label">URL</label>
        <div class="col-sm-4">
          <select id="url" name="url" class="form-control select2">
            <option value="#">[None]</option>
            <option value="/">Home</option>
            <option value="articles">Articles</option>
            <option value="pages">Pages</option>
            <option value="albums">Albums</option>
            <option value="videos">Videos</option>
            <option value="external" {{ (isset($data->id) && $data->url_ext ) ?'selected' : '' }}>External Link</option>
            @php $type = ''; @endphp
            @foreach($post_opt as $n => $post)
              @if ($type!=$post->post_type)
                {!! ($n>0) ? '</optgroup>' : '' !!}
                @php $type=($post->post_type=="video") ? "Video":$post->post_type; @endphp
                <optgroup label="{{ ucfirst($type) }}">
              @endif
              @if ($post->post_type=="video")
                <option value="{{ $post->post_slug }}" {{ $post->post_slug=="#" ? 'disabled' : '' }}  {{ (isset($data->id) && $post->post_slug==$data->url) ? 'selected' : '' }}>{{ $post->post_title }}</option>
              @endif
              @if ($post->post_type=="page")
                <option value="{{ $post->post_slug }}" {{ $post->post_slug=="#" ? 'disabled' : '' }}  {{ (isset($data->id) && $post->post_slug==$data->url) ? 'selected' : '' }}>{{ $post->post_title }}</option>
              @endif
              @if ($post->post_type=="article")
                <option value="{{ 'blog/'.$post->post_slug }}" {{ $post->post_slug=="# " ?'disabled' : '' }}  {{ (isset($data->id) && 'blog/'.$post->post_slug==$data->url) ? 'selected' : '' }}>{{ $post->post_title }}</option>
              @endif
              @php $type = $post->post_type; @endphp
            @endforeach
          </select>
          <input type="text" class="form-control" id="url_ext" name="url_ext" value="{{ isset($data->id) ? (($data->url=="#") ? '' : $data->url) : '' }}" placeholder="http://example.com" {!! (isset($data->id) && ($data->url_ext) ) ?'style="margin-top:5px;"':'style="margin-top:5px;display:none;" disabled' !!}>
        </div>
      </div> --}}
      <div class="form-group">
        <label for="url" class="col-sm-2 control-label">URL</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="url" name="url" placeholder="Alamat URL.." value="{{ isset($data->id) ? $data->url : '' }}">
        </div>
      </div>
      <div class="form-group">
        <label for="target" class="col-sm-2 control-label">Target</label>
        <div class="col-sm-4">
          <select class="form-control custom-select2" name="target" id="target">
            <option value="_self" {{ isset($data->id) && ($data->target == "_self") ? 'selected' : '' }}>Tab Sendiri</option>
            <option value="_blank" {{ isset($data->id) && ($data->target == "_blank") ? 'selected' : '' }}>Tab Baru</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="parent" class="col-sm-2 control-label">Cabang</label>
        <div class="col-sm-4">
          <select class="form-control select2" name="parent" id="parent">
              <option value="0">--Pilih--</option>
              @foreach (generateMenuArray($menus) as $menu)
                <option value="{{ $menu->id }}" {{ isset($data->id) && ($data->parent_id == $menu->id) ? 'selected' : '' }}>{!! $menu->name !!}</option>
              @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="status" {{ (isset($data->status) && $data->status==0) ? '':'checked' }}> Aktif
            </label>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
          {{ isset($data->id) ? method_field('PUT') : '' }}
          {{ csrf_field() }}
          {{ _get_button_post($current_url) }}
        </div>
      </div>
    </form>
  </div>
@endsection

@section('styles')
  {!! _load_css('themes/admin/AdminSC/plugins/select2/4.0.0/css/select2.min.css') !!}
@endsection

@section('scripts')
  {!! _load_js('themes/admin/AdminSC/plugins/select2/4.0.0/js/select2.min.js') !!}
  <script>
    $(function(){
      $(".select2").select2();
      $(".custom-select2").select2({
        minimumResultsForSearch: Infinity
      });
    });

    /* $(document).ready(function(){
      $('.select2').on('change',function(){
        if ($('#url').val()=="external"){
          $('#url_ext').attr("disabled", false).show();
        } else {
          $('#url_ext').attr("disabled", true).hide();
        }
      });
    }); */
  </script>
@endsection