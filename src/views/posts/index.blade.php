@extends('chief::_layouts.master')

@section('content')

	<h1>Your Posts 
		<a class="btn btn-default btn-xs" href="{{ route('chief.posts.create') }}"><i class="glyphicon glyphicon-pencil"></i> create new post</a>
	</h1>

	@foreach($posts as $post)
		
		<div class="post">

			
			<h3 class="post-title">{{ showStatusDot($post->status) }} {{ $post->title }}

				<span class="actionline">

					<a href="{{ route('chief.posts.edit',$post->id) }}"><i class="glyphicon glyphicon-pencil"></i></a>

				</span>

			</h3>
			
			<p class="post-subtitle">{{ $post->subtitle }}</p>

			<p class="teaser">

				{{ $post->teaser( 300 ) }}

			</p>

			<div class="post-metadata">

				{{ $post->created_at->format('F d, Y') }} (last updated on {{ $post->updated_at->format('F d, Y H:i') }})

				@if($post->comment_count > 0)

					{{ $post->comment_count }} comments
					
				@endif

			</div>

		</div>

		<hr class="post-divider">

	@endforeach

	{{ $posts->links() }}
	

@stop