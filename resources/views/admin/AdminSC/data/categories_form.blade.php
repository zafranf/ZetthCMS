@extends('admin.AdminSC.layouts.main')

@section('content')
  <div class="panel-body">
    <form class="form-horizontal" action="{{ url($current_url) }}{{ isset($data) ? '/' . $data->id : '' }}" method="post">
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">Kategori</label>
          <div class="col-sm-4">
            <input type="text" class="form-control autofocus" id="name" name="name" value="{{ isset($data) ? $data->name : '' }}" maxlength="30" placeholder="Nama kategori..">
          </div>
        </div>
        <div class="form-group">
          <label for="description" class="col-sm-2 control-label">Deskripsi</label>
          <div class="col-sm-4">
            <textarea id="description" name="description" class="form-control" placeholder="Penjelasan singkat kategori.." rows="4">{{ isset($data) ? $data->description : '' }}</textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="parent" class="col-sm-2 control-label">Induk</label>
          <div class="col-sm-4">
            <select name="parent" class="form-control custom-select2">
              <option value="">[Tidak ada]</option>
              @foreach (generateArrayLevel($categories, 'allSubcategory') as $category)
                @if (isset($data) && $data->id == $category->id)
                @else
                  <option value="{{ $category->id }}" {{ isset($data) && ($data->parent_id == $category->id) ? 'selected' : '' }}>{!! $category->name !!}</option>
                @endif
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
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
      $(".custom-select2").select2({
        minimumResultsForSearch: Infinity
      });
    });
  </script>
@endsection