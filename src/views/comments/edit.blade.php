@extends('chief::_layouts.master')

@section('content')

	{{ Form::model($comment,array('route' => array('chief.comments.update',$comment->id),'method'=>'PUT')) }}

		@include('chief::_partials.errors')

		<div class="row">

			<div class="col-md-8">

				{{ Form::text('username',null,array('class'=>'form-control','placeholder' => 'username')) }}
				{{ Form::email('email',null,array('class'=>'form-control','placeholder' => 'email')) }}

				{{ Form::textarea('content',null,array('class'=>'form-control-post post-txtr','placeholder' => 'comment','id' => 'redactor_air')) }}
			
			</div>

			<div class="col-md-4">

				{{ Form::submit('submit',array('class'=>'btn btn-lg btn-success')) }}
				<a href="{{ URL::previous() }}">cancel</a>

				<div class="btn-group" data-toggle="buttons">
				  
				  	@foreach(array('pending','approved','denied') as $type )
				  		
				  		<label class="btn btn-default btn-checkable">
				  			{{ Form::radio('status',$type,null,array('id'=>'status'.$type)) }}
				  			{{ ucfirst($type) }}
				  		</label>
				  	
				  	@endforeach

				 </div>

			
				

			</div>

		</div>

	{{ Form::close() }}

	{{ Form::open(array('route' => array('chief.comments.destroy',$comment->id),'method'=>'DELETE')) }}

		{{ Form::submit('delete') }}

	{{ Form::close() }}

@stop

@section('redactor')
	@include('chief::_partials.redactor_air')
@stop