@extends('admin.layout')

@section('styles')
{!! _load_select2('css') !!}
@endsection

@section('content')
    <div class="panel-body">
        <form class="form-horizontal" action="{{ url(Session::get('current_url')) }}{{ isset($point->point_id)?'/'.$point->point_id:'' }}" method="post">
            {{ isset($point->point_id)?method_field('PUT'):'' }}
            {{ csrf_field() }}
            <div class="form-group">
                <label for="point_name" class="col-sm-2 control-label">Meeting point</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="point_name" value="{{ isset($point->point_id)?$point->point_name:'' }}" autofocus onfocus="this.value = this.value;" maxlength="30" placeholder="Meeting point">
                </div>
            </div>
            <div class="form-group">
                <label for="point_desc" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-4">
                    <textarea name="point_description" class="form-control" placeholder="Description">{{ isset($point->point_id)?$point->point_description:'' }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="point_status" {{ (isset($point->point_status) && $point->point_status==0)?'':'checked' }}> Active
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  {{ _get_button_post() }}
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
{!! _load_select2('js') !!}
<script>
$(function(){
    $(".select2").select2();
});
</script>
@endsection