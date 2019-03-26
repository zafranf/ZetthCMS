@extends('admin.AdminSC.layouts.main')

@section('content')
  <div class="panel-body">
    <form class="form-horizontal" action="{{ url($current_url) }}{{ isset($data) ? '/' . $data->id : '' }}" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Nama Menu</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="name" name="name" value="{{ isset($data) ? $data->name : '' }}" autofocus onfocus="_onfocus(this)" maxlength="100" placeholder="Nama menu..">
        </div>
      </div>
      <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Deskripsi</label>
        <div class="col-sm-4">
          <textarea id="description" name="description" class="form-control" placeholder="Penjelasan singkat menu.." rows="4">{{ isset($data) ? $data->description : '' }}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label for="url" class="col-sm-2 control-label">URL</label>
        <div class="col-sm-4">
          <select id="url" name="url" class="form-control select2">
            <option value="#">[Tidak ada]</option>
            <option value="external" {{ (isset($data) && $data->url_ext ) ? 'selected' : '' }}>[Tautan Luar]</option>
            <option value="/">Beranda</option>
            <option value="/articles">Artikel</option>
            <option value="/pages">Halaman</option>
            <option value="/albums">Album Foto</option>
            <option value="/videos">Video</option>
            {{-- @php $type = ''; @endphp
            @foreach($post_opt as $n => $post)
              @if ($type!=$post->post_type)
                {!! ($n>0) ? '</optgroup>' : '' !!}
                @php $type=($post->post_type=="video") ? "Video":$post->post_type; @endphp
                <optgroup label="{{ ucfirst($type) }}">
              @endif
              @if ($post->post_type=="video")
                <option value="{{ $post->post_slug }}" {{ $post->post_slug=="#" ? 'disabled' : '' }}  {{ (isset($data) && $post->post_slug==$data->url) ? 'selected' : '' }}>{{ $post->post_title }}</option>
              @endif
              @if ($post->post_type=="page")
                <option value="{{ $post->post_slug }}" {{ $post->post_slug=="#" ? 'disabled' : '' }}  {{ (isset($data) && $post->post_slug==$data->url) ? 'selected' : '' }}>{{ $post->post_title }}</option>
              @endif
              @if ($post->post_type=="article")
                <option value="{{ 'blog/'.$post->post_slug }}" {{ $post->post_slug=="# " ?'disabled' : '' }}  {{ (isset($data) && 'blog/'.$post->post_slug==$data->url) ? 'selected' : '' }}>{{ $post->post_title }}</option>
              @endif
              @php $type = $post->post_type; @endphp
            @endforeach --}}
          </select>
          <input type="text" class="form-control" id="url_external" name="url_external" value="{{ isset($data) ? (($data->url=="#") ? '' : $data->url) : '' }}" placeholder="http://example.com" {!! (isset($data) && ($data->url_external) ) ? 'style="margin-top:5px;"' : 'style="margin-top:5px;display:none;" disabled' !!}>
        </div>
      </div>
      {{-- <div class="form-group">
        <label for="url" class="col-sm-2 control-label">URL</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="url" name="url" placeholder="Alamat URL.." value="{{ isset($data) ? $data->url : '' }}">
        </div>
      </div> --}}
      <div class="form-group">
        <label for="target" class="col-sm-2 control-label">Target</label>
        <div class="col-sm-4">
          <select class="form-control custom-select2" name="target" id="target">
            <option value="_self" {{ isset($data) && ($data->target == "_self") ? 'selected' : '' }}>Tab Aktif</option>
            <option value="_blank" {{ isset($data) && ($data->target == "_blank") ? 'selected' : '' }}>Tab Baru</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="parent" class="col-sm-2 control-label">Cabang</label>
        <div class="col-sm-4">
          <select class="form-control select2" name="parent" id="parent">
              <option value="0">[Tidak ada]</option>
              @foreach (generateMenuArray($menus) as $menu)
                @if (isset($data) && $data->id == $menu->id)
                @else
                  <option value="{{ $menu->id }}" {{ isset($data) && ($data->parent_id == $menu->id) ? 'selected' : '' }}>{!! $menu->name !!}</option>
                @endif
              @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="is_crud" class="col-sm-2 control-label">Berikan Akses</label>
        <div class="col-sm-4">
          <div class="checkbox">
            <label>
              <input type="checkbox" id="is_crud" name="is_crud" {{ (isset($data) && $data->is_crud == 0) ? '' : 'checked' }}> Ya
            </label>
          </div>
        </div>
      </div>
      <div class="form-group" id="access-fields" {!! (isset($data) && $data->is_crud == 0) ? 'style="display:none;"' : '' !!}>
        <label for="status" class="col-sm-2 control-label">Akses</label>
        <div class="col-sm-4">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="index" {{ (isset($data) && $data->index == 0) ? '' : 'checked' }}> Indeks
            </label>
            <label>
              <input type="checkbox" name="create" {{ isset($data) && $data->create ? 'checked' : '' }}> Tambah
            </label>
            <label>
              <input type="checkbox" name="read" {{ isset($data) && $data->read ? 'checked' : '' }}> Detail
            </label>
            <label>
              <input type="checkbox" name="update" {{ isset($data) && $data->update ? 'checked' : '' }}> Edit
            </label>
            <label>
              <input type="checkbox" name="delete" {{ isset($data) && $data->delete ? 'checked' : '' }}> Hapus
            </label>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="status" {{ (isset($data) && $data->status == 0) ? '' : 'checked' }}> Aktif
            </label>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
          {{ isset($data) ? method_field('PUT') : '' }}
          {{ csrf_field() }}
          {{ _get_button_post($current_url, true, $data->id ?? '') }}
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

    $(document).ready(function(){
      $('#url').on('change', function(){
        if ($('#url').val() == "external"){
          $('#url_external').attr("disabled", false).show();
        } else {
          $('#url_external').attr("disabled", true).hide();
        }
      });
      $('#is_crud').on('click', function() {
        let checked = $('#is_crud').prop('checked');
        if (checked) {
          $('#access-fields').show();
        } else {
          $('#access-fields').hide();
        }
      })
    });
  </script>
@endsection