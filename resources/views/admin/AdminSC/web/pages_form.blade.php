@extends('admin.layout')

@section('styles')
<style>
	#mceu_14 {
		position: absolute;
		right: 10px;
	}
</style>
@endsection

@section('content')
	<div class="panel-body">
		<form class="form-horizontal" action="{{ url(Session::get('current_url')) }}{{ isset($post->post_id)?'/'.$post->post_id:'' }}" method="post">
			{{ isset($post->post_id)?method_field('PUT'):'' }}
			{{ csrf_field() }}
			<div class="form-group">
				<label for="post_title" class="col-sm-2 control-label">Title</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="post_title" name="post_title" value="{{ isset($post->post_id)?$post->post_title:'' }}" {{ isset($post->post_id)?'':'autofocus onfocus="this.value = this.value;"' }} maxlength="100" placeholder="Page Title">
				</div>
			</div>
			<div class="form-group">
				<label for="post_slug" class="col-sm-2 control-label">URL Name</label>
				<div class="col-sm-10">
					<div class="input-group">
						<span class="input-group-addon" id="post_slug_span">{{ url("/") }}/</span>
						<input type="text" id="post_slug" class="form-control" name="post_slug" placeholder="Friendly URL" value="{{ isset($post->post_id)?$post->post_slug:'' }}">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="post_content" class="col-sm-2 control-label">Content</label>
				<div class="col-sm-10">
					<textarea id="post_content" name="post_content" class="form-control" placeholder="Type your content here..">{{ isset($post->post_id)?$post->post_content:'' }}</textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="post_status" {{ (isset($post->post_status) && $post->post_status==0)?'':'checked' }}> Active
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
{!! _load_tinymce() !!}
<script>
$(document).ready(function(){
	$('#post_title').on('keyup blur', function(){
		var slug = _get_slug($(this).val());
		$('#post_slug').val(slug);
	});
	$('#post_slug').blur(function(){
		var slug = _get_slug($(this).val());
		$('#post_slug').val(slug);
	});
	tinymce.init({
		relative_urls: false,
		selector: '#post_content',
		skin: 'custom',
		height: 300,
		plugins: [
			 "advlist autolink link image lists charmap print preview hr anchor pagebreak",
			 "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
			 "table contextmenu directionality emoticons paste textcolor responsivefilemanager code",
			 "placeholder youtube fullscreen"
	   ],
	   toolbar1: "undo redo | bullist numlist blockquote | link unlink | youtube image table | styleselect fontselect | fontsizeselect code | fullscreen",
	   image_advtab: true,
	   image_caption: true,
	   menubar : false,
	   external_filemanager_path:"{{ url('assets/plugins/filemanager/') }}/",
	   filemanager_title:"Filemanager",
	   filemanager_folder: '{{ Session::get('template') }}/',
	   external_plugins: { "filemanager" : "{{ url('assets/plugins/filemanager/plugin.min.js') }}" }
	});
});
</script>
@endsection
