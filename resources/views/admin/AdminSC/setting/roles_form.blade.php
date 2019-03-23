@extends('admin.AdminSC.layouts.main')

@section('content')
  <form class="form-horizontal" action="{{ url($current_url) }}{{ isset($data->id) ? '/'.$data->id : '' }}" method="post">
    <div class="panel-body">
      <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Nama Peran</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="name" name="name" value="{{ isset($data->id) ? $data->display_name : '' }}" autofocus onfocus="_onfocus(this)" maxlength="50" placeholder="Nama peran..">
        </div>
      </div>
      <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Deskripsi</label>
        <div class="col-sm-4">
          <textarea id="description" name="description" class="form-control" placeholder="Penjelasan singkat peran.." rows="4">{{ isset($data->id ) ?$data->description : '' }}</textarea>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="status" {{ (isset($data->status) && $data->status==0) ? '' : 'checked' }}> Active
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
    </div>

    {{-- close div first panel --}}
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        Akses
      </div>
      <div class="panel-body no-padding">
        <table class="table table-bordered table-hover" id="access-list" width="100%">
          <thead>
            <tr>
              <th>Menu</th>
              <th width="100px">Indeks</th>
              <th width="100px">Tambah</th>
              <th width="100px">Detail</th>
              <th width="100px">Edit</th>
              <th width="100px">Hapus</th>
            </tr>
          </thead>
          <tbody>
            @foreach (generateMenuArray($menus) as $menu)
              @php
                $routename = explode('.', $menu->route_name);
              @endphp
              <tr>
                <td>{!! $menu->name !!}</td>
                <td>
                  <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="access[{{ $routename[0] }}][index]" {{ !$menu->index ? 'disabled' : '' }} {{ isset($data) && $data->hasPermission('index-' . $routename[0]) ? 'checked' : '' }}>
                    <span class="custom-control-label"></span>
                  </label>
                </td>
                <td>
                  <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="access[{{ $routename[0] }}][create]" {{ !$menu->create ? 'disabled' : '' }} {{ isset($data) && $data->hasPermission('create-' . $routename[0]) ? 'checked' : '' }}>
                    <span class="custom-control-label"></span>
                  </label>
                </td>
                <td>
                  <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="access[{{ $routename[0] }}][read]" {{ !$menu->read ? 'disabled' : '' }} {{ isset($data) && $data->hasPermission('read-' . $routename[0]) ? 'checked' : '' }}>
                    <span class="custom-control-label"></span>
                  </label>
                </td>
                <td>
                  <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="access[{{ $routename[0] }}][update]" {{ !$menu->update ? 'disabled' : '' }} {{ isset($data) && $data->hasPermission('update-' . $routename[0]) ? 'checked' : '' }}>
                    <span class="custom-control-label"></span>
                  </label>
                </td>
                <td>
                  <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="access[{{ $routename[0] }}][delete]" {{ !$menu->delete ? 'disabled' : '' }} {{ isset($data) && $data->hasPermission('delete-' . $routename[0]) ? 'checked' : '' }}>
                    <span class="custom-control-label"></span>
                  </label>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </form>
@endsection

@section('styles')
  <style>
    #access-list {
      margin: 0;
    }
    #access-list th {
      font-weight: bold!important;
      color: #5d5d5d!important;
    }
    #access-list th:not(:first-child), #access-list td:not(:first-child) {
      text-align: center;
    }
    .table-bordered {
      border: 0;
    }
    .table-bordered tr {
      border-left: 0;
      border-right: 0;
    }
    .table-bordered th, .table-bordered td {
      border: 0;
    }
    .table-bordered tr td:first-child, .table-bordered tr th:first-child {
      border-left:0;
    }
    .table-bordered tr td:last-child, .table-bordered tr th:last-child {
      border-right:0;
    }
    .table-bordered tr:last-child  td{
      border-bottom: 0;
    }
    .table th, .text-wrap table th, .table td, .text-wrap table td {
      border-top: 1px solid #dee2e6;
    }
    /* label.custom-checkbox {
      margin-left: 50%;
      left: -8px;
    } */
  </style>
@endsection