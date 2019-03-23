@extends('admin.AdminSC.layouts.main')

@section('content')
  <div class="panel-body">
    <form class="form-horizontal" action="{{ url($current_url) }}{{ isset($data->id) ? '/' . $data->id : '' }}" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Nama Grup Menu</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="name" name="name" value="{{ isset($data->id) ? $data->name : '' }}" autofocus onfocus="_onfocus(this)" maxlength="100" placeholder="Nama grup menu..">
        </div>
      </div>
      <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Deskripsi</label>
        <div class="col-sm-4">
          <textarea id="description" name="description" class="form-control" placeholder="Penjelasan singkat grup menu.." rows="4">{{ isset($data->id) ? $data->description : '' }}</textarea>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="status" {{ (isset($data->status) && $data->status == 0) ? '' : 'checked' }}> Aktif
            </label>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
          {{ isset($data->id) ? method_field('PUT') : '' }}
          {{ csrf_field() }}
          {{ _get_button_post($current_url, true, $data->id ?? '') }}
        </div>
      </div>
    </form>
  </div>
@endsection

@section('styles')
@endsection

@section('scripts')
@endsection