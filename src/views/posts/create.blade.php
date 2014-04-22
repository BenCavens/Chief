@extends('chief::_layouts.master')

@section('content')

	{{ Form::model($post,array('route' => array('chief.posts.store'),'method'=>'POST')) }}

		@include('chief::_partials.errors')

		<h1>{{ Form::text('title') }}</h1>
		<span class="note">{{ Form::text('slug') }}</span>

		<div class="row">

			<div class="col-md-8">

				{{ Form::textarea('content',null,array('class'=>'form-control')) }}

			</div>

			<div class="col-md-4">

				{{ Form::submit('submit',array('class'=>'btn btn-lg btn-success')) }}
				<a href="{{ URL::previous() }}">cancel</a>

				<div>

					<h4>Categories</h4>

					@foreach($categories as $category)
						{{ Form::checkbox('category_ids[]',$category->id) }} {{ $category->name }}<br>
					@endforeach

				</div>

				<div>

					<h4>Tags</h4>

					@foreach($tags as $tag)
						{{ Form::checkbox('tag_ids[]',$tag->id) }} {{ $tag->name }}<br>
					@endforeach

				</div>

			</div>

		</div>

	{{ Form::close() }}

@stop