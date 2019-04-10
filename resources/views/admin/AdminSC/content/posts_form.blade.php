<?php
$categories_ = [];
$descriptions_ = [];
$parents_ = [];
$tags_ = [];
if (isset($post) ) {
	foreach($post->terms as $k => $term) {
		if ($term->type == "category"){
			$categories_[] = $term->name;
			$descriptions_[] = $term->description;
			$parents_[] = $term->parent;
		}
		if ($term->type=="tag")
			$tags_[] = $term->name;
	}
}
?>
@extends('admin.AdminSC.layouts.main')

@section('content')
<div class="panel-body no-padding-bottom">
	<div class="row" style="margin-top:-15px;">
		<form id="form-post" action="{{ url($current_url) }}{{ isset($post) ? '/' . $post->id : '' }}" method="post" enctype="multipart/form-data">
			{{ isset($post) ? method_field('PUT ' ):'' }}
			{{ csrf_field() }}
			<div class="col-sm-8 col-md-9 left-side no-padding">
				<input type="text" id="title" class="form-control {{ isset($post)   ? '' :   'autofocus' }} no-border-top-right no-border-left no-radius input-lg" name="title" placeholder="Title" maxlength="100" value="{{ isset($post) ? $post->title : '' }}">
				<div class="input-group">
					<span class="input-group-addon no-border-top-right no-border-left no-radius input-sm" id="url_span">{{ url('/post/') }}/</span>
					<input type="text" id="slug" class="form-control no-border-top-right no-radius input-sm" name="slug" placeholder="URL (double click to edit)" readonly value="{{ isset($post) ? $post->slug : '' }}">
				</div>
				<textarea id="excerpt" name="excerpt" class="form-control no-border-top-right no-border-left no-radius input-xlarge" placeholder="Add an excerpt?" rows="3">{{ isset($post) ? $post->excerpt : '' }}</textarea>
				<textarea id="content" name="content" class="form-control no-border-top-right no-border-bottom no-radius input-xlarge" placeholder="Type your content here...">{{ isset($post) ? $post->content : '' }}</textarea>
			</div>
			<div class="col-sm-4 col-md-3 right-side">
				<div class="form-group" style="padding-top:10px;">
					<label for="cover">Cover</label><br>
					<div class="pwd-upload">
						<div class="pwd-upload-new thumbnail">
							<img src="{!! _get_image(isset($post) ? $post->cover : '') !!}">
						</div>
						<div class="pwd-upload-exists thumbnail"></div>
						<div>
							<a href="{{ url('/themes/admin/AdminSC/plugins/filemanager/dialog.php?type=1&field_id=cover&lang=id&relative_url=1&fldr=/') }}" class="btn btn-default pwd-upload-new" id="btn-upload" type="button">Select</a>
							<a href="{{ url('/themes/admin/AdminSC/plugins/filemanager/dialog.php?type=1&field_id=cover&lang=id&relative_url=1&fldr=/') }}" class="btn btn-default pwd-upload-exists" id="btn-upload" type="button">Change</a>
							<a id="btn-remove" class="btn btn-default pwd-upload-exists" type="button">Remove</a>
							<input name="cover" id="cover" type="hidden">
							@if(isset($post->cover))
								<label class="pull-right">
									<input type="checkbox" name="cover_remove" id="cover_remove"> No Cover
								</label>
							@endif
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="featured_image">Featured Image</label>
					<a id="btn-add-featured-image" class="btn btn-default btn-xs pull-right" title="Add a Featured Image"><i class="fa fa-plus"></i></a>
					<div class="row">
						<div class="col-md-12" id="featured-images">
							@if (isset($post) ) 
								@foreach ($post->images as $key => $image)
									<div class="input-group" id="box-featured-image{{ $key+1 }}">
									  	<input type="text" class="form-control featured_images" name="featured_image[]" id="featured_image{{ $key+1 }}" readonly value="{{ $image->image_file }}">
									  	<a href="/assets/plugins/filemanager/dialog.php?type=1&field_id=featured_image{{ $key+1 }}&lang=id&relative_url=1&fldr=/" class="input-group-addon" id="btn-add-featured-image{{ $key+1 }}" style="display:none;"><i class="fa fa-search"></i></a>
										<a class="input-group-addon" onclick="_remove_featured({{ $key+1 }})" style="cursor:pointer;"><i class="fa fa-times"></i></a>
									</div>
								@endforeach
							@endif
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="category">Category*</label>
					<a id="btn-add-category" class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#pwd-modal" title="Add a New Category"><i class="fa fa-plus"></i></a>
					<ul id="category-list">
						@if (isset($post) ) 
							@foreach ($categories_ as $key => $value)
								<li style="width:98%;">
								{{ $value }}
								<span class="pull-right"><i class="fa fa-minus-square-o" style="cursor:pointer;" onclick="_remove_category(this)" title="Remove {{ $value }}"></i></span>
								<input type="hidden" name="categories[]" value="{{ $value }}">
								<input type="hidden" name="descriptions[]" value="{{ $descriptions_[$key] }}">
								<input type="hidden" name="parents[]" value="{{ $parents_[$key] }}">
								</li>
							@endforeach
						@endif
					</ul>
					<input type="text" class="form-control" id="category" name="category" placeholder="Set Category">
				</div>
				<div class="form-group">
					<label for="tags">Tag*</label>
					<div class="col-sm-12 no-padding">
						<input type="text" class="form-control" id="tags" name="tags" placeholder="Tag This Article" value="{{ isset($post) ? implode(",",$tags_ ) :'' }}">
					</div>
				</div>
				<div class="form-group">
					<label for="time">Time</label><br>
					<div class="col-sm-6 col-xs-6 no-padding">
						<input type="text" class="form-control" id="date" name="date" value="{{ isset($post) ? date("Y - m-d", strtotime($post->time)):date("Y-m-d") }}" placeholder="{{ isset($post) ? date("Y - m-d", strtotime($post->time)):date("Y-m-d") }}">
					</div>
					<div class="col-sm-6 col-xs-6 no-padding">
						<input type="text" class="form-control" id="time" name="time" value="{{ isset($post) ? date("H : i", strtotime($post->time)):date("H:i") }}" placeholder="{{ isset($post) ? date("H : i", strtotime($post->time)):date("H:i") }}">
					</div>
				</div>
				<div class="form-group">
					<label for="visitor">Visitor</label><br>
					<div class="col-sm-4 col-xs-4 no-padding">
						<label>
						  <input name="comment" type="checkbox" {{ (isset($post) && ($post->comment)) ? 'checked' : ($apps->enable_comment) ? 'checked' : '' }}> Comment
						</label>
					</div>
					<div class="col-sm-4 col-xs-4 no-padding">
						<label>
						  <input name="share" type="checkbox" {{ (isset($post) && ($post->share)) ? 'checked' : ($apps->enable_share) ? 'checked' : '' }}> Share
						</label>
					</div>
					<div class="col-sm-4 col-xs-4 no-padding">
						<label>
						  <input name="like" type="checkbox" {{ (isset($post) && ($post->like)) ? 'checked' : ($apps->enable_like) ? 'checked' : '' }}> Like
						</label>
					</div>
				</div>
				<div class="form-group">
					<label for="publish">Publish</label><br>
					<div class="col-sm-6 col-xs-6 no-padding">
						<label>
						  <input name="status" type="radio" value="1" {{ (isset($post) && (!$post->status)) ? '' : 'checked' }}> Yes
						</label>
					</div>
					<div class="col-sm-6 col-xs-6 no-padding">
						<label>
						  <input name="status" type="radio" value="0" {{ (isset($post) && (!$post->status)) ? 'checked' : '' }}> No
						</label>
					</div>
				</div>
				<div class="form-group btn-post">
					<br>
					<div class="btn-group btn-group-justified" role="group">
						<a onclick="$('#form-post').submit();" class="btn btn-warning"><i class="fa fa-edit"></i> SAVE</a>
						<a href="{{ url($current_url) }}" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection

@section('styles')
  {{-- {!! _load_css('themes/admin/AdminSC/plugins/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css') !!} --}}
	{!! _load_css('themes/admin/AdminSC/plugins/bootstrap/tagsinput/0.8.0/css/bootstrap-tagsinput.css') !!}
	{!! _load_css('themes/admin/AdminSC/plugins/bootstrap/datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css') !!}
  {!! _load_css('themes/admin/AdminSC/plugins/fancybox/2.1.5/css/jquery.fancybox.css') !!}
  <style>
    #mceu_15 {
      position: absolute;
      right: 10px;
    }
    /* @if ($isDesktop)
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

@section('scripts')
  {!! _load_js('themes/admin/AdminSC/plugins/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js') !!}
  {!! _load_js('themes/admin/AdminSC/plugins/bootstrap/tagsinput/0.8.0/js/bootstrap-tagsinput.js') !!}
  {!! _load_js('themes/admin/AdminSC/plugins/moment/2.13.0/js/moment.min.js') !!}
  {!! _load_js('themes/admin/AdminSC/plugins/bootstrap/datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js') !!}
  {!! _load_js('themes/admin/AdminSC/plugins/fancybox/2.1.5/js/jquery.fancybox.js') !!}
  {!! _load_js('themes/admin/AdminSC/plugins/typeahead/0.11.1/js/typeahead.bundle.min.js') !!}
  {!! _load_js('themes/admin/AdminSC/plugins/tinymce/4.3.2/tinymce.min.js') !!}

  <script>
    var selected = ['<?php echo isset($post) ? implode("','",$categories_ ) :'' ?>'];
    var lsH,tmH = 0;
    $(function () {
      $('#date').datetimepicker({
        format: 'YYYY-MM-DD'
      });
      $('#time').datetimepicker({
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
        $('#cover_remove').attr("checked", false);
      } else {
        url = url.replace('/assets/images/upload/', "");;
        $('#'+field_id).val(url);
      }
    }

    $(document).ready(function(){
      var wFB = window.innerWidth - 30;
      var hFB = window.innerHeight - 60;
      var fImage = <?php echo isset($post) ? count($post->images):1 ?>;
      
      $('input').on('keypress', function(e){
        key = e.keyCode;
        if (key==13) {
          e.preventDefault();
        }
      });

      $('#btn-upload').fancybox({
        type      : 'iframe',
        autoScale : false,
        autoSize : true,
        beforeLoad : function() {
          this.width  = wFB;
          this.height = hFB;
        }/*,
        afterClose : function(){
          alert('from iframe btn');
        }*/
      });
      $('#btn-remove').on('click', function(){
        $('#cover').val('');
        $('.pwd-upload-new').show();
        $('.pwd-upload-exists').hide();
      });
      tinymce.init({
        relative_urls: false,
        selector: '#content',
        /*codesample_dialog_height: 300,*/
        height: (lsH-190),
        skin: 'custom',
        language: 'id',
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
        external_filemanager_path:"{{ asset('/themes/admin/AdminSC/plugins/filemanager/') }}/",
        filemanager_title:"Filemanager",
        filemanager_folder: '/',
        filemanager_language: 'id',
        external_plugins: { "filemanager" : "{{ asset('/themes/admin/AdminSC/plugins/filemanager/plugin.min.js') }}" }
      });
      $('#btn-add-featured-image').on('click', function(){
        if ($('.featured_images').length>=5) {
          alert('Max 5 featured images');
          return false;
        }
        
        var html = '<div class="input-group" id="box-featured-image'+fImage+'">'+
                  '<input type="text" class="form-control featured_images" name="featured_image[]" id="featured_image'+fImage+'" readonly>'+
                  '<a href="/themes/admin/AdminSC/plugins/filemanager/dialog.php?type=1&field_id=featured_image'+fImage+'&lang=id&relative_url=1&fldr=/" class="input-group-addon" id="btn-add-featured-image'+fImage+'" style="display:none;"><i class="fa fa-search"></i></a>'+
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
            console.log('aaaa', this.width)
            console.log('aaaa', wFB)
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
      $('#btn-add-category').on('click', function() {
        @if (isset($categories) && count($categories) > 0)
          // var categories = {!! json_encode(generateArrayLevel($categories, 'allSubcategory', '&dash;')) !!};
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
      var title = $('#title');
      var slug = $('#slug');
      @if (!isset($post)) 
        $('#title').on('keyup blur', function(){
          ttl_val = title.val();
          if (ttl_val=="") {
            slug.val('');
          } else {
            url = _get_slug(ttl_val);
            slug.val(url);
          }
        });
        $('#slug').on('dblclick', function(){
          slug.focus();
          slug.attr("readonly", false);
        });
        $('#slug').on('blur', function(){
          ro = slug.attr('readonly');
          if (!ro){
            sl_val = slug.val();
            slug.val(_get_slug(sl_val));
            slug.attr("readonly", true);
          }
        });
      @endif
      $('#title').on('keydown', function(e){
        if (e.keyCode==9){
          setTimeout(function(){
            $('#excerpt').focus();
          },0);
        }
      });
      /*$('#excerpt').on('keydown', function(e){
        if (e.keyCode==9 && e.keyCode==16){
          setTimeout(function(){
            $('#title').focus();
          },0);
        }
      });*/
      /*categories typeahead*/
      var categories = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: {
          url: '{{ url($adminPath . '/ajax/data/categories') }}',
          cache: false,
          filter: function(list) {
            return $.map(list, function(category) {
              return { name: category };
            });
          }
        }
      });
      categories.initialize();
      $('#category').typeahead({
          minLength: 1
        }, {
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
        $('#category').typeahead('val', '');
      });
      /*tagsinput*/
      var tags = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: {
          url: '{{ url($adminPath . '/ajax/data/tags') }}',
          cache: false,
          filter: function(list) {
          return $.map(list, function(tag) {
            return { name: tag }; });
          }
        }
      });
      tags.initialize();
      $('#tags').tagsinput({
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
      /*$('#tags').on('itemAdded', function(){

      });*/
      /*resize tinymce height when remove tags*/
      /*$('#tags').on('itemRemoved', function(){

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
          +'<input type="hidden" name="categories[]" value="'+par.name+'">'
          +'<input type="hidden" name="descriptions[]" value="'+par.desc+'">'
          +'<input type="hidden" name="parents[]" value="'+par.parent+'">'
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
