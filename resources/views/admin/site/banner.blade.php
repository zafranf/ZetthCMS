@extends('admin.layouts.main')

@section('menu-sort')
  @if (\Auth::user()->can('update-menus'))
    <a href="{{ url('/site/banners/sort') }}" class="btn btn-info" data-toggle="tooltip" data-original-title="Urutkan"><i class="fa fa-sort"></i></a>
  @endif
@endsection

@section('content')
  <div class="card-body">
    <table id="list">
      <thead>
        <tr>
            <th>No.</th>
            <th>Gambar</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Urutan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
      </thead>
    </table>
  </div>
@endsection

{{-- include css --}}
@section('css')
{!! _load_css('/admin/plugins/DataTables/datatables.min.css') !!}
@endsection

{{-- include js --}}
@section('js')
{!! _load_js('/admin/plugins/DataTables/datatables.min.js') !!}
<script>
  $(document).ready(function() {
    var table = $('#list').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": SITE_URL + "/site/banners/data",
      "columns": [
          { "data": "no", "width": "30px" },
          { "data": "image", "width": "80px" },
          { "data": "title", "width": "200px" },
          { "data": "description" },
          { "data": "order", "width": "30px" },
          { "data": "status", "width": "50px" },
          { "width": "100px" },
      ],
      "lengthMenu": [ [20, 50, 100, -1], [20, 50, 100, "All"] ],
      "columnDefs": [{
        "targets": 6,
        "data": 'id',
        "render": function (data, type, row, meta) {
          var actions = '';
          var url = SITE_URL + '/site/banners/' + data;
          var del = "_delete('" + url + "')";
          {!! _get_access_buttons() !!}
          $('[data-toggle="tooltip"]').tooltip();
          return actions;
        }
      }, {
        "targets": 5,
        "data": 'status',
        "render": function (data, type, row, meta) {
          return _get_status_text(data);
        }
      }],
    });
  });
</script>
@endsection