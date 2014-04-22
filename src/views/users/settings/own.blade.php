@extends('chief::_layouts.master')

@section('content')

	{{ Form::model($user,array('route' => array('chief.user.settings.own.update',$user->id),'method'=>'PUT')) }}

		@include('chief::_partials.errors')

		<div class="row">

			<div class="col-md-8">

				<label for="description">Author description</label>
				{{ Form::textarea('description',null,array('class' => 'form-control','autocomplete' => 'off','placeholder' => 'author description','id' => 'description')) }}
			
				

				email warnings,...<br>
				rights,...<br>
				avatar,...<br>

			</div>

			<div class="col-md-4">

				{{ Form::submit('submit',array('class'=>'btn btn-lg btn-success')) }}
				<a href="{{ URL::previous() }}">cancel</a>

			</div>

		</div>

	{{ Form::close() }}

@stop