@extends('chief::_layouts.master')

@section('content')

	<h1>Your Posts 
		<a class="btn btn-default btn-xs" href="{{ route('chief.posts.create') }}"><i class="glyphicon glyphicon-pencil"></i> create new article</a>
	</h1>

	@foreach($posts as $post)
		
		<div class="post">

			
			<h3 class="post-title">{{ $post->title }}

				<span class="actionline">

					<a href="{{ route('chief.posts.edit',$post->id) }}"><i class="glyphicon glyphicon-pencil"></i></a>

				</span>

				<span class="label label-info">{{ $post->status }}</span>
				
				@if($post->comment_count > 0)
					<span class="">{{ $post->comment_count }} comments</span>
				@endif

			</h3>
			
			<p class="post-subtitle">{{ $post->subtitle }}</p>

			<p class="teaser">

				{{ $post->teaser( 300 ) }}

			</p>

		</div>

	@endforeach

	{{ $posts->links() }}
	

@stop