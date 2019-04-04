@extends('admin.layout')

@section('styles')
{!! _load_select2('css') !!}
@endsection

@section('content')
    <div class="panel-body">
        <form class="form-horizontal" action="{{ url($current_url) }}{{ isset($category->term_id)?'/'.$category->term_id:'' }}" method="post">
            {{ isset($category->term_id)?method_field('PUT'):'' }}
            {{ csrf_field() }}
            <div class="form-group">
                <label for="category_name" class="col-sm-2 control-label">Category Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control autofocus" name="category_name" value="{{ isset($category->term_id)?$category->term_name:'' }}" maxlength="30" placeholder="Category Name">
                </div>
            </div>
            <div class="form-group">
                <label for="category_desc" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-4">
                    <textarea name="category_desc" class="form-control" placeholder="Description">{{ isset($category->term_id)?$category->term_description:'' }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="category_parent" class="col-sm-2 control-label">Parent</label>
                <div class="col-sm-4">
                    <select name="category_parent" class="form-control select2">
                        <option value="">--Choose--</option>
                        @if (count($categories)>0)
                            @php
                                $par = [
                                    'id'        => 'term_id',
                                    'parent'    => 'term_parent',
                                    'name'      => 'term_name', 
                                    'print'     => 'term_tree',
                                    'sl'        => isset($category->term_id)?$category->term_parent:0
                                ]
                            @endphp
                            {{ _build_tree($categories, $par) }}
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="category_status" {{ (isset($category->term_status) && $category->term_status==0)?'':'checked' }}> Active
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