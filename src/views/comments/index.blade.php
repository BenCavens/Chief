@extends('chief::_layouts.master')

@section('content')

	<h1>Your Comments 
	</h1>

	@foreach($comments as $comment)
		
		<div class="comment">
			
			<span class="comment-title">{{ $comment->title }}

				{{ $comment->username }} wrote on {{ $comment->created_at }} in {{ $comment->post ? $comment->post->title : '' }}	

			</span>

			<span class="actionline">

					<a href="{{ route('chief.comments.edit',$comment->id) }}"><i class="glyphicon glyphicon-pencil"></i></a>

				</span>

				<span class="label label-info">{{ $comment->status }}</span>
				
			
			<p class="teaser">

				{{ $comment->content }}

			</p>

		</div>

	@endforeach

	{{ $comments->links() }}
	

@stop