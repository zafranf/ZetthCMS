@php $no=1 @endphp
@extends('admin.layout')

@section('styles')
{!! _load_sweetalert('css') !!}
{!! _load_datatables('css') !!}
@endsection

@section('content')
	<div class="panel-body no-padding-right-left">
		<table id="table-data" class="row-border hover">
			<thead>
				<tr>
					<td width="25">No.</td>
					@if (Session::get('is_desktop'))
						<td width="50">Logo</td>
						<td width="300">Bank Name</td>
						<td width="300">Account Name</td>
						<td width="200">Number</td>
						<td width="300">Branch</td>
						<td width="80">Status</td>
					@else
						<td width="100%">Banner</td>
					@endif
					<td width="50">Action</td>
				</tr>
			</thead>
			<tbody>
				@if (count($banks)>0)
					@foreach($banks as $bank)
						<tr>
							<td align="center">{{ $no++ }}</td>
							@if (Session::get('is_desktop'))
	                            <td><img src="{{ _get_image_temp("/assets/images/upload/".$bank->bank_logo, [50,50]) }}" class="img-thumbnail" width="50"></td>
	                            <td>{{ $bank->bank_name }}</td>
	                            <td>{{ $bank->bank_owner }}</td>
	                            <td>{{ $bank->bank_number }}</td>
	                            <td>{{ $bank->bank_branch }}</td>
	                            <td>{{ _get_status_text($bank->bank_status) }}</td>
							@else
								<td>
									<img src="{{ _get_image_temp("/assets/images/upload/".$bank->bank_logo, [50,50]) }}" class="img-thumbnail" width="50"><br>
									<small>
										{{ $bank->bank_owner }}<br>
										<b>{{ $bank->bank_number }}</b><br>
										{{ _get_status_text($bank->bank_status) }}
									</small>
								</td>
							@endif
							<td>{{ _get_button_access($bank->bank_id) }}</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
@endsection

@section('scripts')
{!! _load_sweetalert('js') !!}
{!! _load_datatables('js') !!}
@endsection
