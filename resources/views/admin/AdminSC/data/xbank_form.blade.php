@extends('admin.layout')

@section('styles')
<link href="{{ url('plugins/jasny-bootstrap-3.1.3/css/jasny-bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ url('plugins/select2-4.0.0/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="panel-body">
        <form class="form-horizontal" action="{{ url(Session::get('current_url')) }}{{ isset($bank->bank_id)?'/'.$bank->bank_id:'' }}" method="post" enctype="multipart/form-data">
            {{ isset($bank->bank_id)?method_field('PUT'):'' }}
            {{ csrf_field() }}
            <div class="form-group">
                <label for="logo" class="col-sm-2 control-label">Logo</label>
                <div class="col-sm-4">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail">
                            <img src="{{ _get_image('images/bank/', isset($bank->bank_id)?$bank->bank_logo:'') }}">
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
                <label for="owner" class="col-sm-2 control-label">Nama Pemilik</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="owner" name="owner" value="{{ isset($bank->bank_id)?$bank->bank_owner:'' }}" maxlength="100" placeholder="Nama Pemilik">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Nama Bank</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="name" name="name" value="{{ isset($bank->bank_id)?$bank->bank_name:'' }}" maxlength="100" placeholder="Nama Bank">
                </div>
            </div>
            <div class="form-group">
                <label for="branch" class="col-sm-2 control-label">Cabang</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="branch" name="branch" value="{{ isset($bank->bank_id)?$bank->bank_branch:'' }}" maxlength="100" placeholder="Cabang">
                </div>
            </div>
            <div class="form-group">
                <label for="number" class="col-sm-2 control-label">Nomor Rekening</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="number" name="number" value="{{ isset($bank->bank_id)?$bank->bank_number:'' }}" maxlength="100" placeholder="Nomor Rekening">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="status" {{ (isset($bank->bank_id) && $bank->bank_status==0)?'':'checked' }}> Aktif
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
<script src="{{ url('plugins/jasny-bootstrap-3.1.3/js/jasny-bootstrap.min.js') }}"></script>
<script src="{{ url('plugins/select2-4.0.0/js/select2.min.js') }}"></script>
<script>
$(function(){
    $(".select2").select2({
        placeholder: "[None]"
    });
});

$(document).ready(function(){
    $('.select2').on('change',function(){
        if($('#bank_url').val()=="external"){
            $('#bank_url_ext').attr("disabled", false).show();
        }else{
            $('#bank_url_ext').attr("disabled", true).hide();
        }
    });
});
</script>
@endsection