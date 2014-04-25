@extends('chief::_layouts.master')

@section('content')

	<h1 class="pagetitle">{{ $user->fullname }}</h1>

	{{ Form::model($user,array('route' => array('chief.user.settings.update'),'method'=>'PUT')) }}

		@include('chief::_partials.errors')
	
		<div class="row">

			<div class="col-md-8">

				<div class="form-group">
					<label for="email">Email</label>
					{{ Form::email('email',null,array('class' => 'form-control','autocomplete' => 'off','placeholder' => 'email','id' => 'email')) }}

					<span class="note">Email will also be used as login</span>
				</div>

				<div class="form-group">
					
					<div class="md-col-6">
						<label for="first_name">First name</label>
						{{ Form::text('first_name',null,array('class' => 'form-control','autocomplete' => 'off','placeholder' => 'first name','id' => 'first_name')) }}
					</div>
					<div class="md-col-6">
						<label for="last_name">Name</label>
						{{ Form::text('last_name',null,array('class' => 'form-control','autocomplete' => 'off','placeholder' => 'Name','id' => 'last_name')) }}
					</div>

				</div>

				<div class="form-group">

					<label for="redactor_air">Author description</label>
					{{ Form::textarea('description',null,array('class' => 'form-control','autocomplete' => 'off','placeholder' => 'author description','id' => 'redactor_air')) }}
				
				</div>
				
			
				

			</div>

			<div class="col-md-4">

				{{ Form::submit('save',array('class'=>'btn btn-lg btn-success btn-standalone')) }}
					<br>
					<a href="{{ URL::previous() }}" class="btn btn-default btn-xs">cancel</a>

			</div>

		</div>

	{{ Form::close() }}

@stop

@section('redactor')
	@include('chief::_partials.redactor_air')
@stop