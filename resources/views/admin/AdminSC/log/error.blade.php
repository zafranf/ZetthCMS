@extends('admin.AdminSC.layouts.main')

@section('content')
	<div class="panel-body no-padding-right-left">
		<table id="table-data" class="row-border hover">
			<thead>
				<tr>
          <td width="200">Date</td>
          <td>Message</td>
          <td>File</td>
          <td>Line</td>
          <td>Count</td>
				</tr>
			</thead>
		</table>
	</div>
@endsection

@section('styles')
  {!! _load_css('themes/admin/AdminSC/plugins/DataTables/1.10.12/css/jquery.dataTables.min.css') !!}
@endsection

@section('scripts')
  {!! _load_js('themes/admin/AdminSC/plugins/DataTables/1.10.12/js/jquery.dataTables.min.js') !!}
  <script>
    $(document).ready(function() {
      var table = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": SITE_URL + "{{ $adminPath }}/log/errors/data",
        "pageLength": 20,
        "lengthMenu": [
          [10, 20, 50, 100, -1], 
          [10, 20, 50, 100, "All"]
        ],
        "order": [[ 0, "desc" ]],
        "columns": [
          { "data": "updated_at", "width": "200px" },
          { "data": "message" },
          { "data": "file" },
          { "data": "line" },
          { "data": "count" },
        ],
      });
    });
  </script>
@endsection
