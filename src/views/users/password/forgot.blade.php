@extends('chief::_layouts.master')

@section('content')

	<div class="focus-box">
		<h1>Jouw paswoord vergeten?</h1>
		<p>
			
			Geen probleem. 
			Geef jouw emailadres op en wij sturen je een link door om een nieuw paswoord in te geven.

		</p>
		
		@include('chief::_partials.errors')

		{{ Form::open(array('route'=>'chief.user.forgotpassword.store','method'=>'POST')) }}

			<div class="form-group">
				{{ Form::label('email','Email') }}
				{{ Form::email('email',null,array('class'=>'form-control','autofocus'=>'true')) }}
			</div>
			<div class="form-buttons">
				{{ Form::submit('Send reset password',array('class'=>'btn btn-large btn-default')) }}

			</div>

		{{  Form::close() }}

	</div>

@stop