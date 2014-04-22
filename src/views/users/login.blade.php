@extends('chief::_layouts.master')

@section('content')

	<div class="focus-box">
		<h1>Let's get you in</h1>

		@include('chief::_partials.errors')	

		{{ Form::open(array('url'=>'chief/login')) }}

			<div class="form-group">
				{{ Form::label('email','Email') }}
				{{ Form::email('email',null,array('class'=>'form-control','autofocus'=>'true')) }}
			</div>
			
			<div class="form-group">
				{{ Form::label('password','Password') }}
				{{ Form::password('password',array('class'=>'form-control')) }}
			</div>
			
			<div class="form-group form-buttons">
				{{ Form::submit('Login',array('class'=>'btn btn-primary')) }}
				{{ link_to_route('chief.user.forgotpassword','Paswoord vergeten?',null,array('class'=>'btn')) }}
			</div>

		{{ Form::close() }}
	</div>

@stop