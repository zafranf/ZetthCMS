@php $no=1 @endphp
@extends('admin.AdminSC.layouts.main')

@section('styles')
{!! _load_css('themes/admin/AdminSC/plugins/DataTables/1.10.12/css/jquery.dataTables.min.css') !!}
@endsection

@section('content')
    <div class="panel-body no-padding-right-left">
        <table id="list" class="row-border hover">
            <thead>
                <tr>
                    <td width="25">No.</td>
                    <td>Menu</td>
                    <td>Deskripsi</td>
                    <td width="80">Status</td>
                    {{-- @if ($isDesktop)
                        <td>Menu Name</td>
                        <td>URL</td>
                        <td width="100">Target</td>
                        <td width="80">Status</td>
                    @else
                        <td width="200">Menu</td>
                    @endif --}}
                    <td width="50">Aksi</td>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('scripts')
{!! _load_js('themes/admin/AdminSC/plugins/DataTables/1.10.12/js/jquery.dataTables.min.js') !!}
<script>
  $(document).ready(function() {
    var table = $('#list').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": SITE_URL + "{{ $adminPath }}/setting/menus/data",
      "columns": [
          { "data": "no", "width": "30px" },
          { "data": "name", "width": "200px" },
          { "data": "description" },
          { "data": "status", "width": "50px" },
          { "width": "60px" },
      ],
      "lengthMenu": [ [20, 50, 100, -1], [20, 50, 100, "All"] ],
      "columnDefs": [{
        "targets": 4,
        "data": 'id',
        "render": function (data, type, row, meta) {
          var actions = '';
          var url = SITE_URL + "{{ $adminPath }}/setting/menus/" + data;
          var del = "_delete('" + url + "')";
          {!! _get_access_buttons() !!}
          return actions;
        }
      }, {
        "targets": 3,
        "data": 'status',
        "render": function (data, type, row, meta) {
          return _get_status_text(data);
        }
      }],
    });
  });
  </script>
@endsection