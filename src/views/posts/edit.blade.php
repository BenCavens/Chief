@extends('chief::_layouts.master')

@section('content')

	{{ Form::model($post,array('route' => array('chief.posts.update',$post->id),'method'=>'PUT')) }}

		@include('chief::_partials.errors')

		<h1 class="post-title">{{ Form::text('title',null,array('class' => 'form-control-post','autocomplete' => 'off','placeholder' => 'title')) }}</h1>
		
		<p class="post-subtitle">{{ Form::text('subtitle',null,array('class' => 'form-control-post','autocomplete' => 'off','placeholder' => 'subtitle')) }}</p>
		


		<div class="row">

			<div class="col-md-8">

				{{ Form::textarea('content',null,array('class'=>'form-control-post post-txtr','placeholder' => 'article content','id'=>'redactor_content')) }}
			
			</div>

			<div class="col-md-4">

				{{ Form::submit('submit',array('class'=>'btn btn-lg btn-success')) }}
				<a href="{{ URL::previous() }}">cancel</a>

				<div class="btn-group" data-toggle="buttons">
				  
				  	@foreach(array('draft','published','archived') as $type )
				  		
				  		<label class="btn btn-default btn-checkable">
				  			{{ Form::radio('status',$type,null,array('id'=>'status'.$type)) }}
				  			{{ ucfirst($type) }}
				  		</label>
				  	
				  	@endforeach

				 </div>

				 <span class="note">{{ Form::text('slug',null,array('class' => 'form-control-post','autocomplete' => 'off')) }}</span>

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

	{{ Form::open(array('route' => array('chief.posts.destroy',$post->id),'method'=>'DELETE')) }}

		{{ Form::submit('delete') }}

	{{ Form::close() }}

@stop

@section('redactor')

	@include('chief::_partials.redactor')

@stop