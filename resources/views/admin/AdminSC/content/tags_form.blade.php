@extends('admin.layout')

@section('content')
    <div class="panel-body">
        <form class="form-horizontal" action="{{ url($current_url) }}{{ isset($tag->term_id)?'/'.$tag->term_id:'' }}" method="post">
            {{ isset($tag->term_id)?method_field('PUT'):'' }}
            {{ csrf_field() }}
            <div class="form-group">
                <label for="tag_name" class="col-sm-2 control-label">Tag Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="tag_name" value="{{ isset($tag->term_id)?$tag->term_name:'' }}" autofocus onfocus="this.value = this.value;" placeholder="Tag Name">
                </div>
            </div>
            <div class="form-group">
                <label for="tag_desc" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-4">
                    <textarea name="tag_desc" class="form-control" placeholder="Description">{{ isset($tag->term_id)?$tag->term_description:'' }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="tag_status" {{ (isset($tag->term_status) && $tag->term_status==0)?'':'checked' }}> Active
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