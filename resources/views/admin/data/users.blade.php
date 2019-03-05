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
					@if ($isDesktop)
						<td width="100">Photo</td>
						<td width="200">Username</td>
						<td>Full Name</td>
						<td width="200">Email</td>
						<td width="80">Status</td>
					@else
						<td width="100%">User</td>
					@endif
					<td width="50">Action</td>
				</tr>
			</thead>
			<tbody>
				@if (count($users)>0)
					@foreach($users as $user)
						<tr>
							<td align="center">{{ $no++ }}</td>
							@if ($isDesktop)
								<td><img src="{{ _get_image_temp('assets/images/user/'.Session::get('template').'/'.$user->user_photo, [50]) }}" width="50"></td>
								<td>{{ $user->user_name }}</td>
								<td>{{ $user->user_fullname }}</td>
								<td>{{ $user->user_email }}</td>
								<td>{{ _get_status_text($user->user_status) }}</td>
							@else
								<td>
									{{ $user->user_name }}<br>
									<small>{{ _get_status_text($user->user_status) }}</small>
								</td>
							@endif
							<td>{{ _get_button_access($user->user_id) }}</td>
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
