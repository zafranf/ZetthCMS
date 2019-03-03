<?php
$categories_ = [];
$descriptions_ = [];
$parents_ = [];
$tags_ = [];
if (isset($post->post_id)){
	foreach($post->terms as $k => $term) {
		if ($term->term_type=="category"){
			$categories_[] = $term->term_name;
			$descriptions_[] = $term->term_description;
			$parents_[] = $term->term_parent;
		}
		if ($term->term_type=="tag")
			$tags_[] = $term->term_name;
	}
}
?>
@extends('admin.layout')

@section('styles')
{{-- {!! _load_jasny('css') !!} --}}
{!! _load_tagsinput('css') !!}
{!! _load_datetimepicker('css') !!}
{!! _load_fancybox('css') !!}
<style>
	#mceu_15 {
		position: absolute;
		right: 10px;
	}
	/* @if (Session::get('is_desktop'))
		textarea#mceu_34 {
			height: 458px!important;
		}
		#mceu_32, #mceu_32-body, #mceu_31-body {
			max-height: 548px!important;
		}
		#mceu_31 {
			height: 638px!important;
		}
	@else
		textarea#mceu_33 {
			height: 376px!important;
		}
		#mceu_31, #mceu_31-body, #mceu_30-body {
			height: 466px!important;
		}
		#mceu_30 {
			height: 556px!important;
		}
	@endif */
	.mce-tinymce {
		border: 0!important;
	}
	.mce-fullscreen {
		z-index: 9999!important;
	}
	.mce-toolbar-grp {
		padding-left: 5px!important;
	}
	#post_title {
		font-size: 24px;
	}
	#post_url, #post_url_span {
		height: 20px;
		padding-left: 5px;
	}
	#post_url_span {
		padding:3px 5px 2px 5px;
	}
	#post_content {
		font-size: 14px;
	}
	.left-side {
		border-right: 1px solid #ccc;
		min-height: 640px;
	}
	.pwd-upload-exists {
		display: none;
	}
	@media (max-width: 767px) {
		.left-side {
			border-right: 0;
			min-height: 200px;
		}
		#mceu_26 {
			border-bottom: 1px solid #ccc!important;
		}
	}
</style>
@endsection

@section('content')
<div class="panel-body no-padding-bottom">
	<div class="row" style="margin-top:-15px;">
		<form id="form-post" action="{{ url(Session::get('current_url')) }}{{ isset($post->post_id)?'/'.$post->post_id:'' }}" method="post" enctype="multipart/form-data">
			{{ isset($post->post_id)?method_field('PUT'):'' }}
			{{ csrf_field() }}
			<div class="col-sm-8 col-md-9 left-side no-padding">
				<input type="text" id="post_title" class="form-control no-border-top-right no-border-left no-radius input-lg" name="post_title" {{ isset($post->post_id)?'':'autofocus onfocus="this.value=this.value"' }} placeholder="Title" maxlength="100" value="{{ isset($post->post_id)?$post->post_title:'' }}">
				<div class="input-group">
					<span class="input-group-addon no-border-top-right no-border-left no-radius input-sm" id="post_url_span">{{ url('/post/') }}/</span>
					<input type="text" id="post_url" class="form-control no-border-top-right no-radius input-sm" name="post_url" placeholder="URL (double click to edit)" readonly value="{{ isset($post->post_id)?$post->post_slug:'' }}">
				</div>
				<textarea id="post_excerpt" name="post_excerpt" class="form-control no-border-top-right no-border-left no-radius input-xlarge" placeholder="Add an excerpt?" rows="3">{{ isset($post->post_id)?$post->post_excerpt:'' }}</textarea>
				<textarea id="post_content" name="post_content" class="form-control no-border-top-right no-border-bottom no-radius input-xlarge" placeholder="Type your content here...">{{ isset($post->post_id)?$post->post_content:'' }}</textarea>
			</div>
			<div class="col-sm-4 col-md-3 right-side">
				<div class="form-group" style="padding-top:10px;">
					<label for="post_cover">Cover</label><br>
					<div class="pwd-upload">
						<div class="pwd-upload-new thumbnail">
							<img src="{!! _get_image_temp(isset($post->post_id)?$post->post_cover:'', [300, 300]) !!}">
						</div>
						<div class="pwd-upload-exists thumbnail"></div>
						<div>
							<a href="{{ url('assets/plugins/filemanager/dialog.php?type=1&field_id=post_cover&relative_url=1&fldr=').Session::get('template') }}/" class="btn btn-default pwd-upload-new" id="btn-upload" type="button">Select</a>
							<a href="{{ url('assets/plugins/filemanager/dialog.php?type=1&field_id=post_cover&relative_url=1&fldr=').Session::get('template') }}/" class="btn btn-default pwd-upload-exists" id="btn-upload" type="button">Change</a>
							<a id="btn-remove" class="btn btn-default pwd-upload-exists" type="button">Remove</a>
							<input name="post_cover" id="post_cover" type="hidden">
							@if(isset($post->post_cover))
								<label class="pull-right">
									<input type="checkbox" name="post_cover_remove" id="post_cover_remove"> No Cover
								</label>
							@endif
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="post_featured_image">Featured Image</label>
					<a id="btn-add-featured-image" class="btn btn-default btn-xs pull-right" title="Add a Featured Image"><i class="fa fa-plus"></i></a>
					<div class="row">
						<div class="col-md-12" id="featured-images">
							@if (isset($post->post_id))
								@foreach ($post->images as $key => $image)
									<div class="input-group" id="box-featured-image{{ $key+1 }}">
									  	<input type="text" class="form-control featured_images" name="post_featured_image[]" id="featured_image{{ $key+1 }}" readonly value="{{ $image->image_file }}">
									  	<a href="/assets/plugins/filemanager/dialog.php?type=1&field_id=featured_image{{ $key+1 }}&relative_url=1&fldr={{ Session::get('template') }}/" class="input-group-addon" id="btn-add-featured-image{{ $key+1 }}" style="display:none;"><i class="fa fa-search"></i></a>
										<a class="input-group-addon" onclick="_remove_featured({{ $key+1 }})" style="cursor:pointer;"><i class="fa fa-times"></i></a>
									</div>
								@endforeach
							@endif
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="post_category">Category*</label>
					<a id="btn-add-category" class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#pwd-modal" title="Add a New Category"><i class="fa fa-plus"></i></a>
					<ul id="category-list">
						@if (isset($post->post_id))
							@foreach ($categories_ as $key => $value)
								<li style="width:98%;">
								{{ $value }}
								<span class="pull-right"><i class="fa fa-minus-square-o" style="cursor:pointer;" onclick="_remove_category(this)" title="Remove {{ $value }}"></i></span>
								<input type="hidden" name="post_categories[]" value="{{ $value }}">
								<input type="hidden" name="post_descriptions[]" value="{{ $descriptions_[$key] }}">
								<input type="hidden" name="post_parents[]" value="{{ $parents_[$key] }}">
								</li>
							@endforeach
						@endif
					</ul>
					<input type="text" class="form-control" id="post_category" name="post_category" placeholder="Set Category">
				</div>
				<div class="form-group">
					<label for="post_tags">Tag*</label>
					<div class="col-sm-12 no-padding">
						<input type="text" class="form-control" id="post_tags" name="post_tags" placeholder="Tag This Article" value="{{ isset($post->post_id)?implode(",",$tags_):'' }}">
					</div>
				</div>
				<div class="form-group">
					<label for="post_time">Time</label><br>
					<div class="col-sm-6 col-xs-6 no-padding">
						<input type="text" class="form-control" id="post_date" name="post_date" value="{{ isset($post->post_id)?date("Y-m-d", strtotime($post->post_time)):date("Y-m-d") }}" placeholder="{{ isset($post->post_id)?date("Y-m-d", strtotime($post->post_time)):date("Y-m-d") }}">
					</div>
					<div class="col-sm-6 col-xs-6 no-padding">
						<input type="text" class="form-control" id="post_time" name="post_time" value="{{ isset($post->post_id)?date("H:i", strtotime($post->post_time)):date("H:i") }}" placeholder="{{ isset($post->post_id)?date("H:i", strtotime($post->post_time)):date("H:i") }}">
					</div>
				</div>
				<div class="form-group">
					<label for="visitor">Visitor</label><br>
					<div class="col-sm-4 col-xs-4 no-padding">
						<label>
						  <input name="post_comment" type="checkbox" {{ (isset($post->post_id) && ($post->post_comment))?'checked':(Session::get('config')->config_enable_comment)?'checked':'' }}> Comment
						</label>
					</div>
					<div class="col-sm-4 col-xs-4 no-padding">
						<label>
						  <input name="post_share" type="checkbox" {{ (isset($post->post_id) && ($post->post_share))?'checked':(Session::get('config')->config_enable_share)?'checked':'' }}> Share
						</label>
					</div>
					<div class="col-sm-4 col-xs-4 no-padding">
						<label>
						  <input name="post_like" type="checkbox" {{ (isset($post->post_id) && ($post->post_like))?'checked':(Session::get('config')->config_enable_like)?'checked':'' }}> Like
						</label>
					</div>
				</div>
				<div class="form-group">
					<label for="publish">Publish</label><br>
					<div class="col-sm-6 col-xs-6 no-padding">
						<label>
						  <input name="post_status" type="radio" value="1" {{ (isset($post->post_id) && (!$post->post_status))?'':'checked' }}> Yes
						</label>
					</div>
					<div class="col-sm-6 col-xs-6 no-padding">
						<label>
						  <input name="post_status" type="radio" value="0" {{ (isset($post->post_id) && (!$post->post_status))?'checked':'' }}> No
						</label>
					</div>
				</div>
				<div class="form-group btn-post">
					<br>
					<div class="btn-group btn-group-justified" role="group">
						<a onclick="$('#form-post').submit();" class="btn btn-warning"><i class="fa fa-edit"></i> SAVE</a>
						<a href="{{ url(Session::get('current_url')) }}" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection

@section('scripts')
{{-- {!! _load_jasny('js') !!} --}}
{!! _load_tagsinput('js') !!}
{!! _load_momentjs() !!}
{!! _load_datetimepicker('js') !!}
{!! _load_fancybox('js') !!}
{!! _load_typeahead() !!}
{!! _load_tinymce() !!}

<script>
var selected = ['<?php echo isset($post->post_id)?implode("','",$categories_):'' ?>'];
var lsH,tmH = 0;
$(function () {
	$('#post_date').datetimepicker({
		format: 'YYYY-MM-DD'
	});
	$('#post_time').datetimepicker({
		format: 'HH:mm'
	});
	_resize_tinymce();
});
function responsive_filemanager_callback(field_id){
	var url = $('#'+field_id).val().replace(SITE_URL, "");
	var img = '<img src="'+url+'">';
	if (field_id.indexOf("featured")<0) {
		$('.pwd-upload-new').hide();
		$('.pwd-upload-exists').show();
		$('.pwd-upload-exists.thumbnail').html(img);
		$('#post_cover_remove').attr("checked", false);
	} else {
		url = url.replace('/assets/images/upload/', "");;
		$('#'+field_id).val(url);
	}
}
$(document).ready(function(){
	var wFB = window.innerWidth - 30,
		hFB = window.innerHeight - 60;
	var fImage = <?php echo isset($post->post_id)?count($post->images):1 ?>;
	$('input').on('keypress', function(e){
		key = e.keyCode;
		if (key==13) {
			e.preventDefault();
		}
	});
	$('#btn-upload').fancybox({
		type      : 'iframe',
		autoScale : false,
		autoSize : false,
		beforeLoad : function() {
			this.width  = wFB;
			this.height = hFB;
		}/*,
		afterClose : function(){
			alert('from iframe btn');
		}*/
	});
	$('#btn-remove').on('click', function(){
		$('#post_cover').val('');
		$('.pwd-upload-new').show();
		$('.pwd-upload-exists').hide();
	});
	tinymce.init({
		relative_urls: false,
		selector: '#post_content',
		/*codesample_dialog_height: 300,*/
		height: (lsH-190),
		skin: 'custom',
		plugins: [
			 "advlist autolink link image lists charmap print preview hr anchor pagebreak",
			 "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
			 "table contextmenu directionality emoticons paste textcolor code codesample",
			 "placeholder youtube fullscreen"
	   ],
	   toolbar: "undo redo | bullist numlist blockquote | link unlink | youtube image table | styleselect fontselect | fontsizeselect codesample code fullscreen",
	   image_advtab: true,
	   image_caption: true,
	   menubar: false,
	   external_filemanager_path: "{{ url('assets/plugins/filemanager') }}/",
	   filemanager_title: "File Manager",
	   filemanager_folder: '{{ Session::get('template') }}/',
	   external_plugins: { "filemanager" : "{{ url('assets/plugins/filemanager/plugin.min.js') }}" }
	 });
	$('#btn-add-featured-image').on('click', function(){
		if ($('.featured_images').length>=5) {
			alert('Max 5 featured images');
			return false;
		}
		
		var html = '<div class="input-group" id="box-featured-image'+fImage+'">'+
					  	'<input type="text" class="form-control featured_images" name="post_featured_image[]" id="featured_image'+fImage+'" readonly>'+
					  	'<a href="/assets/plugins/filemanager/dialog.php?type=1&field_id=featured_image'+fImage+'&relative_url=1&fldr={{ Session::get('template') }}/" class="input-group-addon" id="btn-add-featured-image'+fImage+'" style="display:none;"><i class="fa fa-search"></i></a>'+
						'<a class="input-group-addon" onclick="_remove_featured('+fImage+')" style="cursor:pointer;"><i class="fa fa-times"></i></a>'+
					'</div>';
		$('#featured-images').append(html);

		$('#btn-add-featured-image'+fImage).fancybox({
			type      : 'iframe',
			autoScale : false,
			autoSize : false,
			beforeLoad : function() {
				this.width  = wFB;
				this.height = hFB;
			},
			afterClose : function(){
				fimg = fImage-1;
				if ($('#featured_image'+fimg).val()=="") {
					_remove_featured(fimg);
				}
			}
		});

		$('#btn-add-featured-image'+fImage).click();
		fImage++;
	});
	$('#btn-add-category').on('click', function(){
		@if (count($categories)>0)
			@php(
				$par = [
					'id'        => 'term_id',
					'parent'    => 'term_parent',
					'name'      => 'term_name',
					'print'     => 'term_tree',
					'sl'        => isset($category->term_id)?$category->term_parent:0
				]
			)
			var categories = "{{ _build_tree($categories, $par) }}";
		@else
			var categories = "";
		@endif
		var inp = '<form class="form-horizontal" role="form">';
			inp+= '<div class="form-group"><label class="control-label col-sm-4" for="category_name">Name</label><div class="col-sm-6"><input type="text" class="form-control" id="category_name" placeholder="Category Name" maxlength="30"></div></div>';
			inp+= '<div class="form-group"><label class="control-label col-sm-4" for="category_desc">Description</label><div class="col-sm-6"><textarea id="category_desc" name="category_desc" class="form-control" placeholder="Category Description"></textarea></div></div>';
			inp+= '<div class="form-group"><label class="control-label col-sm-4" for="category_parent">Parent</label><div class="col-sm-6"><select id="category_parent" name="category_parent" class="form-control"><option value="">--Choose--</option>'+categories+'</select></div></div>';
			inp+= '</form>';
		var btn = '<button type="button" class="btn btn-default" data-dismiss="modal" id="btn-modal-cancel">Cancel</button> <button type="button" class="btn btn-warning" data-dismiss="modal" id="btn-modal-add">Add</button>';
		$('.modal-title').text('Add a new category');
		$('.modal-body').html(inp);
		$('.modal-footer').html(btn);
		$('#pwd-modal').on('shown.bs.modal', function () {
			$('#category_name').select();
		});
		$('#btn-modal-add').on('click', function(){
			var par = {
				name: $('#category_name').val(),
				desc: $('#category_desc').val(),
				parent: $('#category_parent').val()
			};
			_insert_new_category(par);

		});
		$('input').on('keypress', function(e){
			key = e.keyCode;
			if (key==13) {
				e.preventDefault();
			}
		});
	});
	var title = $('#post_title');
	var slug = $('#post_url');
	@if (!isset($post->post_id))
		$('#post_title').on('keyup blur', function(){
			ttl_val = title.val();
			if (ttl_val==""){
				slug.val('');
			}else{
				url = _get_slug(ttl_val);
				slug.val(url);
			}
		});
		$('#post_url').on('dblclick', function(){
			slug.focus();
			slug.attr("readonly", false);
		});
		$('#post_url').on('blur', function(){
			ro = slug.attr('readonly');
			if (!ro){
				sl_val = slug.val();
				slug.val(_get_slug(sl_val));
				slug.attr("readonly", true);
			}
		});
	@endif
	$('#post_title').on('keydown', function(e){
		if (e.keyCode==9){
			setTimeout(function(){
				$('#post_excerpt').focus();
			},0);
		}
	});
	/*$('#post_excerpt').on('keydown', function(e){
		if (e.keyCode==9 && e.keyCode==16){
			setTimeout(function(){
				$('#post_title').focus();
			},0);
		}
	});*/
	/*categories typeahead*/
	var categories = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		prefetch: {
			url: '{{ url('ajax/data/categories') }}',
			cache: false,
			filter: function(list) {
				return $.map(list, function(category) {
					return { name: category };
				});
			}
		}
	});
	categories.initialize();
	$('#post_category').typeahead({
		  minLength: 1
		},
		{
		name: 'categories',
		displayKey: 'name',
		valueKey: 'name',
		source: categories.ttAdapter(),
		/*templates: {
			empty: '<div class="empty-message" style="padding-left:10px;">No matches.</div>'
		}*/
	}).on('typeahead:selected typeahead:autocompleted', function(e, val) {
		if ($.inArray(val.name, selected)<0){
			var par = {
				name: val.name,
				desc: '',
				parent: '',
			};
			_insert_new_category(par);
			selected.push(val.name);
		}
		$('#post_category').typeahead('val', '');

	});
	/*tagsinput*/
	var tags = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		prefetch: {
			url: '{{ url('ajax/data/tags') }}',
			cache: false,
			filter: function(list) {
			return $.map(list, function(tag) {
				return { name: tag }; });
			}
		}
	});
	tags.initialize();
	$('#post_tags').tagsinput({
		tagClass: function(item){
			return 'label label-warning'
		},
		typeaheadjs: {
			name: 'tags',
			displayKey: 'name',
			valueKey: 'name',
			source: tags.ttAdapter(),
			/*templates: {
				empty: '<div class="empty-message" style="padding-left:10px;">No matches.</div>'
			}*/
		}
	});
	/*resize tinymce height when add tags*/
	/*$('#post_tags').on('itemAdded', function(){

	});*/
	/*resize tinymce height when remove tags*/
	/*$('#post_tags').on('itemRemoved', function(){

	});*/
	/*resize tinymce height when change cover*/
	/*$('.fileinput').on('change.bs.fileinput', function(){

	});*/
	/*resize tinymce height when remove cover*/
	/*$('a.fileinput-exists').on('click', function(){
		setTimeout(function(){

		}, 0);
	});*/
});

function _insert_new_category(par) {
	var cat = '<li style="width:98%;">'+par.name+'<span class="pull-right"><i class="fa fa-minus-square-o" style="cursor:pointer;" onclick="_remove_category(this)" title="Remove '+par.name+'"></i></span>'
			+'<input type="hidden" name="post_categories[]" value="'+par.name+'">'
			+'<input type="hidden" name="post_descriptions[]" value="'+par.desc+'">'
			+'<input type="hidden" name="post_parents[]" value="'+par.parent+'">'
			+'</li>';
	$('#category-list').append(cat);
}

function _resize_tinymce(){
	setTimeout(function(){
		_resize_tinymce();
	}, 0);
	lsH = $('.right-side').height();
	tmH = lsH - 210;
	$('#mceu_25 iframe').height(tmH);
}

function _remove_category(el){
	txt = $(el).closest('li').text();
	slIdx = selected.indexOf(txt);
	if (slIdx > -1) {
		selected.splice(slIdx, 1);
	}
	$(el).closest('li').remove();
}

function _remove_featured(el){
	$('#box-featured-image'+el).remove();
}
</script>
@endsection
