@extends('admin.layout')

@section('styles')
{!! _load_jasny('css') !!}
{!! _load_select2('css') !!}
@endsection

@section('content')
	<div class="panel-body">
		<form class="form-horizontal" action="{{ url(Session::get('current_url')) }}{{ isset($user->user_id)?'/'.$user->user_id:'' }}" method="post" enctype="multipart/form-data">
			{{ isset($user->user_id)?method_field('PUT'):'' }}
			{{ csrf_field() }}
			<div class="row">
				<div class="col-md-6">
					<h4>Main Info</h4>
					<hr>
					<div class="form-group">
						<label for="username" class="col-md-4 control-label">Username</label>
						<div class="col-md-8">
							<input type="text" class="form-control" id="username" name="username" value="{{ isset($user->user_id)?$user->user_name:'' }}" autofocus maxlength="20" placeholder="Username" {{ isset($user->user_id)?'readonly':'' }}>
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-md-4 control-label">Email</label>
						<div class="col-md-8">
							<input type="text" class="form-control" id="email" name="email" value="{{ isset($user->user_id)?$user->user_email:'' }}" maxlength="100" placeholder="Email">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-md-4 control-label">Password</label>
						<div class="col-md-8">
							<input type="password" class="form-control" id="password" name="password" placeholder="Password">
						</div>
					</div>
					<div class="form-group">
						<label for="password_confirmation" class="col-md-4 control-label">Retype Password</label>
						<div class="col-md-8">
							<input type="password" class="form-control" id="password_confirmation" name="password_confirmation"  placeholder="Retype Password">
						</div>
					</div>
					<div class="form-group">
						<label for="fullname" class="col-md-4 control-label">Fullname</label>
						<div class="col-md-8">
							<input type="text" class="form-control" id="fullname" name="fullname" value="{{ isset($user->user_id)?$user->user_fullname:'' }}" maxlength="50" placeholder="Full Name" }}>
						</div>
					</div>
					<div class="form-group">
						<label for="biography" class="col-md-4 control-label">Biography</label>
						<div class="col-md-8">
							<textarea id="biography" name="biography" class="form-control" placeholder="Biography">{{ isset($user->user_id)?$user->user_biography:'' }}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="photo" class="col-md-4 control-label">Photo</label>
						<div class="col-md-8">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail">
									<img src="{{ _get_image_temp('assets/images/user/'.Session::get('template').'/'.(isset($user->user_id)?$user->user_photo:''), ['o']) }}">
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail"></div>
								<div>
									<span class="btn btn-default btn-file">
										<span class="fileinput-new">Select</span>
										<span class="fileinput-exists">Change</span>
										<input name="photo" id="photo" type="file" accept="image/*">
									</span>
									<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-md-4 control-label">Group</label>
						<div class="col-md-8">
							<select name="group" id="group" class="form-control pwd-select">
								@foreach($groups as $group)
									<option value="{{ $group->group_id }}" {{ (isset($user->user_id) && $user->user_group==$group->group_id)?'selected':'' }} >{{ $group->group_name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-4 col-md-8">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="status" {{ (isset($user->user_status) && $user->user_status==0)?'':'checked' }}> Active
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<h4>Social Media <span class="btn btn-default btn-xs pull-right" id="btn-add-socmed"><i class="fa fa-plus"></i> Add</span></h4>
					<hr>
					<div class="form-group">
						<label for="label" class="col-md-4 control-label">Socmed</label>
						<div class="col-md-8">
							@if (isset($socmed_data) && count($socmed_data)>0)
								@foreach($socmed_data as $key => $val)
								@php
									$rand = rand(111111111, 999999999);
								@endphp
								<div id="div-socmed-{{ $rand }}">
									<div class="col-md-3 col-xs-6 no-padding">
										<select name="socmed_id[]" class="form-control pwd-select">
											<option value="">--Choose--</option>
											@foreach($socmeds as $socmed)
												@php
													$sl = $socmed->socmed_id==$val->socmed->socmed_id?'selected':'';
												@endphp
												<option value="{{ $socmed->socmed_id }}" {{ $sl }}>{{ $socmed->socmed_name }}</option>
											@endforeach
										</select>
									</div>
									<div class="col-md-9 col-xs-6 no-padding">
										@if ($key>0)
											<div class="input-group">
												<input type="text" class="form-control" name="socmed_uname[]" placeholder="Account Name" value="{{ $val->socmed_username }}">
												<span class="input-group-btn">
													<button type="button" class="btn" style="background:white;border:1px solid #ccc;" onclick="_remove('#div-socmed-{{ $rand }}')"><i class="fa fa-minus"></i></button
												</span>
											</div>
										@else
											<input type="text" class="form-control" name="socmed_uname[]" placeholder="Account Name" value="{{ $val->socmed_username }}">
										@endif
									</div>
								</div>
								@endforeach
							@else
								<div class="col-md-3 col-xs-6 no-padding">
									<select name="socmed_id[]" class="form-control pwd-select">
										<option value="">--Choose--</option>
										@foreach($socmeds as $socmed)
											<option value="{{ $socmed->socmed_id }}">{{ $socmed->socmed_name }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-9 col-xs-6 no-padding">
									<input type="text" class="form-control" name="socmed_uname[]" placeholder="Account Name">
								</div>
							@endif
							<div id="div-socmed"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-10">
					{{ _get_button_post() }}
				</div>
			</div>
		</form>
	</div>
@endsection

@section('scripts')
{!! _load_jasny('js') !!}
{!! _load_select2('js') !!}
<script>
$(function(){
	$(".pwd-select").select2({
		minimumResultsForSearch: Infinity
	});
});

$(document).ready(function(){
	$('#btn-add-socmed').on('click', function(){
		socmed_no = (Math.random() * 1000000000).toFixed(0);
		var html = '<div id="div-socmed-'+socmed_no+'"><div class="col-md-3 col-xs-6 no-padding">'+
						'<select name="socmed_id[]" class="form-control pwd-select">'+
							'<option value="">--Choose--</option>'+
							@foreach($socmeds as $socmed)
								'<option value="{{ $socmed->socmed_id }}">{{ $socmed->socmed_name }}</option>'+
							@endforeach
						'</select>'+
					'</div>'+
					'<div class="col-md-9 col-xs-6 no-padding">'+
						'<div class="input-group">'+
							'<input type="text" class="form-control" name="socmed_uname[]" placeholder="Account Name">'+
							'<span class="input-group-btn">'+
								'<button type="button" class="btn" style="background:white;border:1px solid #ccc;" onclick="_remove(\'#div-socmed-'+socmed_no+'\')"><i class="fa fa-minus"></i></button'+
							'</span>'+
						'</div>'+
					'</div></div>';

		$('#div-socmed').append(html);
		$(".pwd-select").select2({
			minimumResultsForSearch: Infinity
		});
	});
});
</script>
@endsection
