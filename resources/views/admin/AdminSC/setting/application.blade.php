@extends('admin.AdminSC.layouts.main')

@section('styles')
{!! _load_css('themes/admin/AdminSC/plugins/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css') !!}
{!! _load_css('themes/admin/AdminSC/plugins/bootstrap/tagsinput/0.8.0/css/bootstrap-tagsinput.css') !!}
{!! _load_css('themes/admin/AdminSC/plugins/bootstrap/datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css') !!}
{!! _load_css('themes/admin/AdminSC/plugins/select2/4.0.0/css/select2.min.css') !!}
<style>
	.group-socmed {
    width:125px;
    padding:3px 5px;
    text-align:left;
    font-size: 12px;
	}
</style>
@endsection

@section('content')
	<div class="panel-body">
		<form class="form-horizontal" action="{{ url($adminPath . '/' . $current_url) }}/{{ $data->id ?? '' }}" method="post" enctype="multipart/form-data">
			{{ isset($data->id) ? method_field('PUT') : '' }}
			{{ csrf_field() }}
			<div class="row">
				<div class="col-md-6">
					<h4>Main Information</h4>
					<hr>
					<div class="form-group">
						<label for="name" class="col-md-4 control-label"><abbr title="Max size 500x500 pixels">Logo</abbr></label>
						<div class="col-md-8">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail">
									<img src="{{ _get_image("assets/images/" . $data->logo, "/assets/images/logo.jpg") }}">
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail"></div>
								<div>
									<span class="btn btn-default btn-file">
										<span class="fileinput-new">Pilih</span>
										<span class="fileinput-exists">Ganti</span>
										<input name="logo" id="logo" type="file" accept="image/*">
									</span>
									<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Hapus</a>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="col-md-4 control-label"><abbr title="Max size 50x50 pixels">Ikon</abbr></label>
						<div class="col-md-8">
							<div class="fileinput fileinput-new input-group" data-provides="fileinput">
								<div class="form-control" data-trigger="fileinput">
									<i class="fa fa-image fileinput-exists"></i>
									<span class="fileinput-filename">
										<img style="width:20px;margin-top:-5px;margin-right:2px;" src="{{ _get_image("assets/images/" . $data->icon, "/assets/images/logo.jpg") }}">
									</span>
								</div>
								<span class="input-group-addon btn btn-file">
									<span class="fileinput-new">Pilih</span>
									<span class="fileinput-exists">Ganti</span>
									<input type="file" name="icon" id="icon" accept="image/*">
								</span>
								<a href="#" class="input-group-addon btn fileinput-exists" data-dismiss="fileinput">Hapus</a>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="col-md-4 control-label">Nama Situs</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="name" value="{{ $data->name ?? '' }}" placeholder="Nama situs" maxlength="50">
						</div>
					</div>
					<div class="form-group">
						<label for="slogan" class="col-md-4 control-label">Tagline</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="tagline" value="{{ $data->tagline ?? '' }}" placeholder="Site Tagline">
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-md-4 control-label">Email</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="email" value="{{ $data->email ?? '' }}" placeholder="email@domain.com">
						</div>
					</div>
					<div class="form-group">
						<label for="phone" class="col-md-4 control-label">Phone</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="phone" value="{{ $data->phone ?? '' }}" placeholder="(123) 12345678">
						</div>
					</div>
					{{-- <div class="form-group" {!! (Auth::user()->id != 1)?'style="display:none;"':'' !!}>
						<label for="max_login_failed" class="col-md-4 control-label">Max Login Failed</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="max_login_failed" value="{{ $data->max_login_failed ?? '' }}" maxlength="1">
							<span class="text-danger">{{ ($errors->has('max_login_failed'))?$errors->first('max_login_failed'):'' }}</span>
						</div>
					</div> --}}
					{{-- <div class="form-group" {!! (Auth::user()->id != 1)?'style="display:none;"':'' !!}>
						<label for="lockout_time" class="col-md-4 control-label">Lockout Time <small>(in minutes)</small></label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="lockout_time" value="{{ $data->lockout_time ?? '' }}" maxlength="2">
							<span class="text-danger">{{ ($errors->has('lockout_time'))?$errors->first('lockout_time'):'' }}</span>
						</div>
					</div> --}}
					<div class="form-group" {!! (Auth::user()->id != 1)?'style="display:none;"':'' !!}>
						<label for="perpage" class="col-md-4 control-label">Data Perhalaman</label>
						<div class="col-md-8">
							<input id="perpage" name="perpage" class="form-control" value="{{ $data->perpage ?? 0 }}" placeholder="Tampilkan data perhalaman">
						</div>
					</div>
					<div class="form-group">
						<label for="enable" class="col-md-4 control-label">Aktifkan</label>
						<div class="col-md-8">
							<div class="checkbox">
								<div class="col-xs-6 col-sm-3">
									<label>
										<input type="checkbox" name="enable_subscribe" {{ (!$data->enable_subscribe)?'':'checked' }}> Langganan
									</label>
								</div>
								<div class="col-xs-6 col-sm-3">
									<label>
										<input type="checkbox" name="enable_comment" {{ (!$data->enable_comment)?'':'checked' }}> Komentar
									</label>
								</div>
								<div class="col-xs-6 col-sm-3">
									<label>
										<input type="checkbox" name="enable_like" {{ (!$data->enable_like)?'':'checked' }}> Sukai
									</label>
								</div>
								<div class="col-xs-6 col-sm-3">
									<label>
										<input type="checkbox" name="enable_share" {{ (!$data->enable_share)?'':'checked' }}> Bagikan
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="status" class="col-md-4 control-label">Status</label>
						<div class="col-md-8">
							<select id="status" name="status" class="form-control pwd-select">
								<option value="1" {{ ($data->status == 1) ? 'selected' : '' }}>Active</option>
								<option value="0" {{ ($data->status == 0) ? 'selected' : '' }}>Coming Soon</option>
								<option value="2" {{ ($data->status == 2) ? 'selected' : '' }}>Maintenance</option>
							</select>
						</div>
					</div>
					<div class="form-group" {!! ($data->status == 1) ? 'style="display:none;"' : '' !!} id="d_active_at">
						<label for="active_at" class="col-md-4 control-label">Open at</label>
						<div class="col-md-8">
							<input type="text" class="form-control" id="i_active_at" name="active_at" value="{{ isset($data->id)?date("Y-m-d", strtotime($data->active_at)) : '' }}" {!! ($data->status == 1) ? 'readonly' : '' !!}>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<h4>Media Sosial <span class="btn btn-default btn-xs pull-right" id="btn-add-socmed"><i class="fa fa-plus"></i> Tambah</span></h4>
					<hr>
					<div class="form-group">
						<label for="label" class="col-md-4 control-label">Akun</label>
						<div class="col-md-8">
							@if (isset($socmed_data) && count($socmed_data)>0)
								@foreach($socmed_data as $key => $val)
								@php
									$rand = rand(111111111, 999999999);
								@endphp
								<div id="div-socmed-{{ $rand }}">
									<div class="col-md-3 col-xs-6 no-padding">
										<select name="socmed_id[]" class="form-control pwd-select">
                      <option value="">--Pilih--</option>
                      @if(isset($socmeds))
                        @foreach($socmeds as $socmed)
                          @php 
                            $sl = $socmed->socmed_id==$val->socmed->socmed_id?'selected':''
                          @endphp
                          <option value="{{ $socmed->socmed_id }}" {{ $sl }}>{{ $socmed->socmed_name }}</option>
                        @endforeach
                      @endif
										</select>
									</div>
									<div class="col-md-9 col-xs-6 no-padding">
										@if ($key > 0)
											<div class="input-group">
												<input type="text" class="form-control" name="socmed_uname[]" placeholder="Nama/ID akun" value="{{ $val->socmed_username }}">
												<span class="input-group-btn">
													<button type="button" class="btn" style="background:white;border:1px solid #ccc;" onclick="_remove('#div-socmed-{{ $rand }}')"><i class="fa fa-minus"></i></button
												</span>
											</div>
										@else
											<input type="text" class="form-control" name="socmed_uname[]" placeholder="Nama/ID akun" value="{{ $val->socmed_username }}">
										@endif
									</div>
								</div>
								@endforeach
							@else
								<div class="col-md-3 col-xs-6 no-padding">
									<select name="socmed_id[]" class="form-control pwd-select">
                    <option value="">--Pilih--</option>
                    @if (isset($socmeds))
                      @foreach($socmeds as $socmed)
                        <option value="{{ $socmed->socmed_id }}">{{ $socmed->socmed_name }}</option>
                      @endforeach
                    @endif
									</select>
								</div>
								<div class="col-md-9 col-xs-6 no-padding">
									<input type="text" class="form-control" name="socmed_uname[]" placeholder="Nama/ID akun">
								</div>
							@endif
							<div id="div-socmed"></div>
						</div>
					</div>
					<h4>Pengaturan SEO</h4>
					<hr>
					<div class="form-group">
						<label for="keyword" class="col-md-4 control-label">Kata Kunci</label>
						<div class="col-md-8">
							<input type="text" id="keyword" class="form-control" name="keyword" value="{{ $data->keyword ?? '' }}" placeholder="Enter untuk konfirmasi">
						</div>
					</div>
					<div class="form-group">
						<label for="description" class="col-md-4 control-label">Deskripsi</label>
						<div class="col-md-8">
							<textarea name="description" class="form-control" rows="5" placeholder="Your Site Deskripsi singkat mengenai situs">{{ $data->description ?? '' }}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="phone" class="col-md-4 control-label">Google Analytics</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="google_analytics" value="{{ $data->google_analytics ?? '' }}" placeholder="Kode Lacak Google Analytics">
						</div>
					</div>
					<h4>Lokasi</h4>
					<hr>
					<div class="form-group">
						<label for="address" class="col-md-4 control-label">Alamat</label>
						<div class="col-md-8">
							<textarea name="address" class="form-control" rows="5" placeholder="Alamat lengkap">{{ $data->address ?? '' }}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="location" class="col-md-4 control-label">Koordinat</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="location" value="{{ $data->location ?? '' }}" placeholder="Lintang, Bujur">
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-10">
				  {{-- {{ _get_button_post() }} --}}
				</div>
			</div>
		</form>
	</div>
@endsection

@section('scripts')
{!! _load_js('themes/admin/AdminSC/plugins/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js') !!}
{!! _load_js('themes/admin/AdminSC/plugins/bootstrap/tagsinput/0.8.0/js/bootstrap-tagsinput.js') !!}
{!! _load_js('themes/admin/AdminSC/plugins/moment/2.13.0/js/moment.min.js') !!}
{!! _load_js('themes/admin/AdminSC/plugins/bootstrap/datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js') !!}
{!! _load_js('themes/admin/AdminSC/plugins/select2/4.0.0/js/select2.min.js') !!}
<script>
$(function(){
	$('#i_active_at').datetimepicker({
		format: 'YYYY-MM-DD'
	});
	$(".pwd-select").select2({
		minimumResultsForSearch: Infinity
	});
});

$(document).ready(function(){
	$('#status').on("change", function(){
		if ($('#status').val()!=1){
			$('#d_active_at').show();
			$('#i_active_at').attr('readonly', false);
		}else{
			$('#d_active_at').hide();
			$('#i_active_at').attr('readonly', true);
		}
	});
	$('#keyword').tagsinput({
		tagClass: function(item){
			return 'label label-warning'
		}
	});
	$('#btn-add-socmed').on('click', function(){
		socmed_no = (Math.random() * 1000000000).toFixed(0);
		var html = '<div id="div-socmed-'+socmed_no+'"><div class="col-md-3 col-xs-6 no-padding">'+
						'<select name="socmed_id[]" class="form-control pwd-select">'+
              '<option value="">--Choose--</option>'+
              @if (isset($socmeds))
                @foreach($socmeds as $socmed)
                  '<option value="{{ $socmed->socmed_id }}">{{ $socmed->socmed_name }}</option>'+
                @endforeach
              @endif
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
