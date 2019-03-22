@extends('admin.AdminSC.layouts.main')

@section('styles')
@endsection

@section('content')
    <div class="panel-body">
        <form class="form-horizontal" action="{{ url($current_url) }}{{ isset($data->id) ? '/' . $data->id : '' }}" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Group Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="name" name="name" value="{{ isset($data->id) ? $data->name : '' }}" autofocus onfocus="_autofocus(this)" maxlength="100" placeholder="Group Menu Name">
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-4">
                    <textarea id="description" name="description" class="form-control" placeholder="Description">{{ isset($data->id) ? $data->description : '' }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="status" {{ (isset($data->status) && $data->status == 0) ? '' : 'checked' }}> Active
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    {{ isset($data->id) ? method_field('PUT') : '' }}
                    {{ csrf_field() }}
                    {{ _get_button_post($current_url) }}
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
@endsection