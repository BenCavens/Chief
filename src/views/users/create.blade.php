@extends('chief::_layouts.master')

@section('content')

	{{ Form::model($user,array('route' => array('chief.users.store'),'method'=>'POST')) }}

		@include('chief::_partials.errors')

	
		<div class="row">

			<div class="col-md-8">

				<label for="first_name">First name</label>
				{{ Form::text('first_name',null,array('class' => 'form-control','autocomplete' => 'off','placeholder' => 'first name','id' => 'first_name')) }}
				
				<label for="last_name">Name</label>
				{{ Form::text('last_name',null,array('class' => 'form-control','autocomplete' => 'off','placeholder' => 'Name','id' => 'last_name')) }}
				
				<label for="email">Email</label>
				{{ Form::email('email',null,array('class' => 'form-control','autocomplete' => 'off','placeholder' => 'email','id' => 'email')) }}
				<span class="note">Email will also be used as login</span>

				<label for="description">Author description</label>
				{{ Form::textarea('description',null,array('class' => 'form-control','autocomplete' => 'off','placeholder' => 'author description','id' => 'description')) }}
				
					
			</div>

			<div class="col-md-4">

				{{ Form::submit('create',array('class'=>'btn btn-lg btn-success')) }}
				<a href="{{ URL::previous() }}">cancel</a>

			</div>

		</div>

	{{ Form::close() }}

@stop