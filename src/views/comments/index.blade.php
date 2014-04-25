@extends('chief::_layouts.master')

@section('content')

	<h1>Your Comments 
	</h1>

	@foreach($comments as $comment)
		
		<div class="comment">
			
			<span class="comment-title">{{ showStatusDot($comment->status) }}
				{{ $comment->post ? $comment->post->title : '' }}
			</span>
			
			@if(false != $permissions->comment_edit)
				<span class="actionline">
					<a href="{{ route('chief.comments.edit',$comment->id) }}"><i class="glyphicon glyphicon-pencil"></i></a>
				</span>
			@endif
			

			<p class="post-teaser">

				{{ $comment->content }}

			</p>

			<span class="post-metadata">
				 {{ $comment->username }} wrote on {{ $comment->created_at->format('d F Y H:s') }}	
			</span>

		</div>

	@endforeach

	{{ $comments->links() }}
	

@stop