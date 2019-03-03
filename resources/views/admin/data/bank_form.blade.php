@extends('admin.layout')

@section('styles')
{!! _load_select2('css') !!}
{!! _load_fancybox('css') !!}
<style media="screen">
	.pwd-upload-exists {
		display: none;
	}
</style>
@endsection

@section('content')
	<div class="panel-body">
		<form class="form-horizontal" action="{{ url(Session::get('current_url')) }}{{ isset($bank->bank_id)?'/'.$bank->bank_id:'' }}" method="post" enctype="multipart/form-data">
			{{ isset($bank->bank_id)?method_field('PUT'):'' }}
			{{ csrf_field() }}
			<div class="form-group">
				<label for="bank_logo" class="col-sm-2 control-label">Logo</label>
				<div class="col-sm-4">
					<div class="pwd-upload">
						<div class="pwd-upload-new thumbnail">
							<img src="{!! _get_image_temp(isset($bank->bank_id)?"/assets/images/upload/".$bank->bank_logo:'', ['o']) !!}">
						</div>
						<div class="pwd-upload-exists thumbnail"></div>
						<div>
							<a href="{{ url('assets/plugins/filemanager/dialog.php?type=1&field_id=bank_logo&relative_url=1') }}" class="btn btn-default pwd-upload-new" id="btn-upload" type="button">Select</a>
							<a href="{{ url('assets/plugins/filemanager/dialog.php?type=1&field_id=bank_logo&relative_url=1') }}" class="btn btn-default pwd-upload-exists" id="btn-upload" type="button">Change</a>
							<a id="btn-remove" class="btn btn-default pwd-upload-exists" type="button">Remove</a>
							<input name="bank_logo" id="bank_logo" type="hidden">
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="bank_name" class="col-sm-2 control-label">Bank Name</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ isset($bank->bank_id)?$bank->bank_name:'' }}" autofocus onfocus="this.value = this.value;" maxlength="100" placeholder="Bank Name">
				</div>
			</div>
			<div class="form-group">
				<label for="bank_branch" class="col-sm-2 control-label">Branch</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="bank_branch" name="bank_branch" value="{{ isset($bank->bank_id)?$bank->bank_branch:'' }}" maxlength="100" placeholder="Branch">
				</div>
			</div>
			<div class="form-group">
				<label for="bank_number" class="col-sm-2 control-label">Account Number</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="bank_number" name="bank_number" value="{{ isset($bank->bank_id)?$bank->bank_number:'' }}" maxlength="100" placeholder="Account Number">
				</div>
			</div>
			<div class="form-group">
				<label for="bank_owner" class="col-sm-2 control-label">Account Name</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="bank_owner" name="bank_owner" value="{{ isset($bank->bank_id)?$bank->bank_owner:'' }}" maxlength="100" placeholder="Account Name">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-4">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="bank_status" {{ (isset($bank->bank_status) && $bank->bank_status==0)?'':'checked' }}> Active
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-4">
					{{ _get_button_post() }}
				</div>
			</div>
		</form>
	</div>
@endsection

@section('scripts')
{!! _load_select2('js') !!}
{!! _load_fancybox('js') !!}
<script>
$(function(){
	$(".select2").select2({
		placeholder: "[None]"
	});
	$(".pwd-select").select2({
		minimumResultsForSearch: Infinity
	});
});

function responsive_filemanager_callback(field_id){
	var url = $('#'+field_id).val().replace(SITE_URL, "");
	var img = '<img src="'+url+'">';
	$('.pwd-upload-new').hide();
	$('.pwd-upload-exists').show();
	$('.pwd-upload-exists.thumbnail').html(img);
}

$(document).ready(function(){
	var wFB = window.innerWidth - 30,
		hFB = window.innerHeight - 60;

	$('.select2').on('change',function(){
		if ($('#bank_url').val()=="external"){
			$('#bank_url_ext').attr("disabled", false).show();
		}else{
			$('#bank_url_ext').attr("disabled", true).hide();
		}
	});
	$('#btn-upload').fancybox({
		type      : 'iframe',
		autoScale : false,
		autoSize : false,
		beforeLoad : function() {
			this.width  = wFB;
			this.height = hFB;
		}
	});
	$('#btn-remove').on('click', function(){
		$('#post_cover').val('');
		$('.pwd-upload-new').show();
		$('.pwd-upload-exists').hide();
	});
});
</script>
@endsection
