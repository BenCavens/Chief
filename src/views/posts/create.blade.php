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

				</div>

				<hr class="post-divider">

			</div>

		</div>

	{{ Form::close() }}

@stop

@section('redactor')

	@include('chief::_partials.redactor')

@stop