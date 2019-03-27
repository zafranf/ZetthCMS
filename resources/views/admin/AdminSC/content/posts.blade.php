@php $no=1 @endphp
@extends('admin.layout')

@section('styles')
{!! _load_sweetalert('css') !!}
{!! _load_datatables('css') !!}
<style>
	.twitter-share-button {
		position: relative;
		height: 20px;
		padding: 1px 8px 1px 6px;
		color: #fff;
		cursor: pointer;
		background-color: #1b95e0;
		border-radius: 3px;
		box-sizing: border-box;
		font-size: 12px;
	}
	.twitter-share-button:hover, .twitter-share-button:active, .twitter-share-button:focus {
		text-decoration: none;
		color: white;
	}
	.fb-share-button {
		position: relative;
		height: 20px;
		padding: 1px 8px 1px 6px;
		color: #fff;
		cursor: pointer;
		background-color: #4267b2;
		border-radius: 3px;
		box-sizing: border-box;
		font-size: 12px;
	}
	.fb-share-button:hover, .fb-share-button:active, .fb-share-button:focus {
		text-decoration: none;
		color: white;
	}
	.pwd-share-button {
		position: relative;
		height: 18px;
		margin-top: -2px;
		padding: 1px 8px 1px 6px;
		/*color: #fff;*/
		cursor: pointer;
		/*background-color: #1b95e0;*/
		border: 1px solid coral;
		border-radius: 3px;
		box-sizing: border-box;
		font-size: 12px;
		line-height: 1.2;
	}
	.pwd-share-button:hover, .pwd-share-button:active, .pwd-share-button:focus {
		text-decoration: none;
	}
	.pwd-stats {
		border: 1px solid coral;
		border-radius: 3px;
		width: 100%;
		display: block;
		padding: 0 5px;
		margin: 1px 0;
		overflow: hidden;
		text-align: center;
		font-size: 12px;
	}
	.pwd-stats .text {
		float: right;
		background: coral;
		color: white;
		padding: 0 3px;
		position: relative;
		right: -5px;
		overflow: hidden;
		width: 70%;
		text-align: right;
	}
	@media (max-width: 767px) {
		.pwd-stats {
			width: 40%;
			display: inline;
		}
	}
</style>
@endsection

@section('content')
	<div class="panel-body no-padding-right-left">
		<table id="table-data" class="row-border hover">
			<thead>
				<tr>
					<td width="25">No.</td>
					@if ($isDesktop)
						<td width="80">Cover</td>
						<td>Title</td>
						<td width="60">Stats</td>
						<td width="80">Status</td>
					@else
						<td width="300">Post</td>
					@endif
					<td width="80">Action</td>
				</tr>
			</thead>
			<tbody>
				@if (count($posts)>0)
					@foreach($posts as $post)
						@php $link=url('post/'.$post->post_slug) @endphp
						<tr>
							<td align="center">{{ $no++ }}</td>
							@if ($isDesktop)
								@php $cat=[] @endphp
								@foreach($post->categories as $category)
									@php $cat[]='<a style="text-decoration:none;">'.$category->term_name.'</a>' @endphp
								@endforeach
								<td><center><img src="{!! _get_image_temp($post->post_cover, [80]) !!}" width="80"></center></td>
								<td>
									{{ $post->post_title }}<br>
									<small>by <b>{{ $post->author->user_fullname }}</b> <br>
									in {!! implode($cat, ", ") !!}</small> <br>
									<a class="pwd-share-button" onclick="_open_window('https://www.facebook.com/sharer/sharer.php?u={{ $link }}&amp;src=sdkpreparse')"><i class="fa fa-facebook-square"></i> Share</a>
									<a class="pwd-share-button" onclick="_open_window('https://twitter.com/intent/tweet?text={{ $post->post_title.' '.$link }}')"><i class="fa fa-twitter"></i> Tweet</a>
									<a class="pwd-share-button" onclick="_open_window('https://plus.google.com/share?url={{ $link }}')"><i class="fa fa-google-plus"></i> Share</a>
									<a id="btn-short-url" class="pwd-share-button btn-short-url" data-toggle="modal" data-target="#pwd-modal"><i class="fa fa-link"></i> {{ $link }}</a>
								</td>
								<td>
									<span class="pwd-stats" title="Views"><i class="fa fa-eye"></i> <span class="text">{{ $post->post_visited }}</span></span>
									<span class="pwd-stats" title="Likes"><i class="fa fa-heart"></i> <span class="text">{{ $post->post_liked }}</span></span>
									<span class="pwd-stats" title="Shares"><i class="fa fa-share"></i> <span class="text">{{ $post->post_shared }}</span></span>
									<span class="pwd-stats" title="Comments"><i class="fa fa-comment-o"></i> <span class="text">{{ count($post->comments_all) }}</span></span>
								</td>
								<td>{{ _get_status_text($post->post_status) }}</td>
							@else
								<td>
									{{ str_limit($post->post_title, 50) }}<br>
									<span class="pwd-stats" title="Views"><i class="fa fa-eye"></i> {{ $post->post_visited }}</span>
									<span class="pwd-stats" title="Likes"><i class="fa fa-heart"></i> {{ $post->post_liked }}</span>
									<span class="pwd-stats" title="Shares"><i class="fa fa-share"></i> {{ $post->post_shared }}</span>
									<span class="pwd-stats" title="Comments"><i class="fa fa-comment-o"></i> {{ count($post->comments_all) }}</span>
									<br>
									<a class="pwd-share-button" onclick="_open_window('https://www.facebook.com/sharer/sharer.php?u={{ $link }}&amp;src=sdkpreparse')"><i class="fa fa-facebook-square"></i></a>
									<a class="pwd-share-button" onclick="_open_window('https://twitter.com/intent/tweet?text={{ $post->post_title.' '.$link }}')"><i class="fa fa-twitter"></i></a>
									<a class="pwd-share-button" onclick="_open_window('https://plus.google.com/share?url={{ $link }}')"><i class="fa fa-google-plus"></i></a>
									<a id="btn-short-url" class="pwd-share-button btn-short-url" data-toggle="modal" data-target="#pwd-modal"><i class="fa fa-link"></i> <span class="hide">{{ $link }}</span></a> &nbsp;<small>{{ _get_status_text($post->post_status) }}</small>
								</td>
							@endif
							<td>{{ _get_button_access($post->post_id) }}</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
@endsection

@section('scripts')
{!! _load_sweetalert('js') !!}
{!! _load_datatables('js') !!}
<script>
$(document).ready(function(){
	$('.btn-short-url').on('click', function(){
		url = $(this).text();
		html = 'Press <code>CTRL+C</code> to copy: <input id="pwd-short-url" type="text" class="form-control" readonly value="'+url+'" style="margin-top:10px;">';
		$('.modal-title').text('Share URL');
		$('.modal-body').html(html);
		$('.modal-footer').hide();
	});
	$('#pwd-modal').on('shown.bs.modal', function () {
		$('#pwd-short-url').select();
	})
});
</script>
@endsection
