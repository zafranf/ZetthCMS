@extends('admin.AdminSC.layouts.main')

@section('content')
  <div class="panel-body">
    <form class="form-horizontal" action="{{ url($current_url) }}{{ isset($menu->menu_id) ? '/' . $menu->menu_id : '' }}" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="menu_name" class="col-sm-2 control-label">Menu Name</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="menu_name" name="menu_name" value="{{ isset($menu->menu_id) ? $menu->menu_name : '' }}" autofocus onfocus="_autofocus(this)" maxlength="100" placeholder="Menu Name">
        </div>
      </div>
      <div class="form-group">
        <label for="menu_description" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-4">
          <textarea id="menu_description" name="menu_description" class="form-control" placeholder="Description">{{ isset($menu->menu_id) ? $menu->menu_description : '' }}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label for="menu_url" class="col-sm-2 control-label">URL</label>
        <div class="col-sm-4">
          <select id="menu_url" name="menu_url" class="form-control select2">
            <option value="#">[None]</option>
            <option value="/">Home</option>
            <option value="articles">Articles</option>
            <option value="pages">Pages</option>
            <option value="albums">Albums</option>
            <option value="videos">Videos</option>
            <option value="external" {{ (isset($menu->menu_id) && $menu->menu_url_ext ) ?'selected' : '' }}>External Link</option>
            @php $type = ''; @endphp
            @foreach($post_opt as $n => $post)
              @if ($type!=$post->post_type)
                {!! ($n>0) ? '</optgroup>' : '' !!}
                @php $type=($post->post_type=="video") ? "Video":$post->post_type; @endphp
                <optgroup label="{{ ucfirst($type) }}">
              @endif
              @if ($post->post_type=="video")
                <option value="{{ $post->post_slug }}" {{ $post->post_slug=="#" ? 'disabled' : '' }}  {{ (isset($menu->menu_id) && $post->post_slug==$menu->menu_url) ? 'selected' : '' }}>{{ $post->post_title }}</option>
              @endif
              @if ($post->post_type=="page")
                <option value="{{ $post->post_slug }}" {{ $post->post_slug=="#" ? 'disabled' : '' }}  {{ (isset($menu->menu_id) && $post->post_slug==$menu->menu_url) ? 'selected' : '' }}>{{ $post->post_title }}</option>
              @endif
              @if ($post->post_type=="article")
                <option value="{{ 'blog/'.$post->post_slug }}" {{ $post->post_slug=="# " ?'disabled' : '' }}  {{ (isset($menu->menu_id) && 'blog/'.$post->post_slug==$menu->menu_url) ? 'selected' : '' }}>{{ $post->post_title }}</option>
              @endif
              @php $type = $post->post_type; @endphp
            @endforeach
          </select>
          <input type="text" class="form-control" id="menu_url_ext" name="menu_url_ext" value="{{ isset($menu->menu_id) ? (($menu->menu_url=="#") ? '' : $menu->menu_url) : '' }}" placeholder="http://example.com" {!! (isset($menu->menu_id) && ($menu->menu_url_ext) ) ?'style="margin-top:5px;"':'style="margin-top:5px;display:none;" disabled' !!}>
        </div>
      </div>
      <div class="form-group">
        <label for="menu_target" class="col-sm-2 control-label">Target</label>
        <div class="col-sm-4">
          <select name="menu_target" class="form-control select2">
            @foreach(_option_target() as $key => $value)
              <option {{ (isset($menu->menu_id) && $value==$menu->menu_target) ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="menu_parent" class="col-sm-2 control-label">Parent</label>
        <div class="col-sm-4">
          <select name="menu_parent" class="form-control select2">
            <option value="0">[None]</option>
            @if (count($menus)>0)
              @php
                $par = [
                  'id'        => 'menu_id',
                  'parent'    => 'menu_parent',
                  'name'      => 'menu_name', 
                  'print'     => 'menu_tree',
                  'sl'        => isset($menu->menu_id) ? $menu->menu_parent:0
                ]
              @endphp
              {{ _build_tree($menus, $par) }}
            @endif
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="menu_status" {{ (isset($menu->menu_status) && $menu->menu_status==0) ? '':'checked' }}> Active
            </label>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
          {{ isset($menu->menu_id) ? method_field('PUT') : '' }}
          {{ csrf_field() }}
          {{ _get_button_post($current_url) }}
        </div>
      </div>
    </form>
  </div>
@endsection

@section('styles')
  {!! _load_select2('css') !!}
@endsection

@section('scripts')
  {!! _load_select2('js') !!}
  <script>
    $(function(){
        $(".select2").select2({
            placeholder: "[None]"
        });
        /*$(".pwd-select").select2({
            minimumResultsForSearch: Infinity
        });*/
    });

    $(document).ready(function(){
        $('.select2').on('change',function(){
            if ($('#menu_url').val()=="external"){
                $('#menu_url_ext').attr("disabled", false).show();
            }else{
                $('#menu_url_ext').attr("disabled", true).hide();
            }
        });
    });
  </script>
@endsection