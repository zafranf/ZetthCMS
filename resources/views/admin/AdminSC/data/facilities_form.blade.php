@extends('admin.layout')

@section('styles')
@endsection

@section('content')
    <div class="panel-body">
        <form class="form-horizontal" action="{{ url(Session::get('current_url')) }}{{ isset($facility->facility_id)?'/'.$facility->facility_id:'' }}" method="post">
            {{ isset($facility->facility_id)?method_field('PUT'):'' }}
            {{ csrf_field() }}
            <div class="form-group">
                <label for="facility_name" class="col-sm-2 control-label">Facility Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="facility_name" name="facility_name" value="{{ isset($facility->facility_id)?$facility->facility_name:'' }}" autofocus onfocus="this.value = this.value;" maxlength="50" placeholder="Facility Name">
                </div>
            </div>
            <div class="form-group">
                <label for="icon" class="col-sm-2 control-label">Icon</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon"><i id="i_icon" class="{{ isset($facility->facility_id)?$facility->facility_icon:'fa fa-check' }}"></i></div>
                        <input type="text" class="form-control" id="facility_icon" name="facility_icon" value="{{ isset($facility->facility_id)?str_replace('fa fa-', '', $facility->facility_icon):'check' }}" maxlength="20" placeholder="check">
                        <div class="input-group-addon"><i id="i_icon" class="fa fa-question-circle"></i></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-4">
                    <textarea id="facility_description" name="facility_description" class="form-control" placeholder="Description">{{ isset($facility->facility_id)?$facility->facility_description:'' }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="facility_status" {{ (isset($facility->facility_status) && $facility->facility_status==0)?'':'checked' }}> Active
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
<script>
$(document).ready(function(){
    $('#facility_icon').blur(function(){
        if($(this).val()!="")
            $('#i_icon').attr("class", "fa fa-"+$(this).val());
        else
            $('#i_icon').attr("class", "fa fa-check");
    });
});
</script>
@endsection