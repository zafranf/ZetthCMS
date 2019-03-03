@extends('admin.layout')

@section('content')
    <div class="panel-body">
        <form class="form-horizontal" action="{{ url(Session::get('current_url')) }}{{ isset($group->group_id)?'/'.$group->group_id:'' }}" method="post">
            {{ isset($group->group_id)?method_field('PUT'):'' }}
            {{ csrf_field() }}
            <div class="form-group">
                <label for="group_name" class="col-sm-2 control-label">Group Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="group_name" name="group_name" value="{{ isset($group->group_id)?$group->group_name:'' }}" autofocus onfocus="this.value = this.value;" maxlength="50" placeholder="Group Name">
                </div>
            </div>
            <div class="form-group">
                <label for="group_description" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-4">
                    <textarea id="group_description" name="group_description" class="form-control" placeholder="Type the description here..">{{ isset($group->group_id)?$group->group_description:'' }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="group_status" {{ (isset($group->group_status) && $group->group_status==0)?'':'checked' }}> Active
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