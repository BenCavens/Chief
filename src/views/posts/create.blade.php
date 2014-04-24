@extends('chief::_layouts.master')

@section('content')

	{{ Form::model($post,array('route' => array('chief.posts.store'),'method'=>'POST')) }}

		@include('chief::_partials.errors')

		<h1 class="post-title">
			{{ Form::text('title',null,array('class' => 'form-control-post','autocomplete' => 'off','placeholder' => 'title')) }}

		</h1>
		
		<p class="post-subtitle">{{ Form::text('subtitle',null,array('class' => 'form-control-post','autocomplete' => 'off','placeholder' => 'subtitle')) }}</p>
		

		<div class="row">

			<div class="col-md-8">

				{{ Form::textarea('content',null,array('class'=>'form-control-post post-txtr','placeholder' => 'article content','id'=>'redactor_content')) }}
			
			</div>

			<div class="col-md-4 sidebar">

				<div class="text-center">
					
					{{ Form::submit('save',array('class'=>'btn btn-lg btn-success btn-standalone')) }}
					<br>
					<a href="{{ URL::previous() }}" class="btn btn-default btn-xs">cancel</a>

					<hr class="post-divider">

					<label>
						{{ Form::checkbox('allow_comments',1,null) }} Allow comments
					</label>

				</div>

				<hr class="post-divider" data-toggle="buttons">

				<div class="text-center">

					<h4 class="text-center">Categories</h4>

					@foreach($categories as $category)
						<label for="cat-{{$category->id}}" class="btn btn-xs btn-default">
							{{ Form::checkbox('category_ids[]',$category->id,null,array('id' => 'cat-'.$category->id)) }} {{ $category->name }}
						</label>
					@endforeach

				</div>

				<div class="text-center">

					<h4 class="text-center">Tags</h4>

					@foreach($tags as $tag)
						<label for="tag-{{$tag->id}}" class="btn btn-xs btn-default">
							{{ Form::checkbox('tag_ids[]',$tag->id,null,array('id' => 'tag-'.$tag->id)) }} {{ $tag->name }}
						</label>
					@endforeach

				</div>

				

			</div>

		</div>

	{{ Form::close() }}

@stop

@section('redactor')

	@include('chief::_partials.redactor')

@stop