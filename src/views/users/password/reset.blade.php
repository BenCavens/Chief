@extends('chief::_layouts.master')

@section('content')
	
	<h1>Jouw nieuw paswoord</h1>
		
	@include('chief::_partials.errors')

	{{ Form::open(array('route'=>array('chief.user.resetpassword.store',$user->id,$resetcode),'method'=>'POST')) }}

		<div class="form-group">
			{{ Form::label('password','Paswoord') }}
			{{ Form::password('password',array('class'=>'form-control')) }}
		</div>
		<div class="form-group">
			{{ Form::label('password_confirm','Herhaal paswoord') }}
			{{ Form::password('password_confirm',array('class'=>'form-control')) }}
		</div>
		<div class="form-group form-buttons">
			{{ Form::submit('Save new password',array('class'=>'btn btn-large btn-success')) }}

		</div>

	{{  Form::close() }}

@stop

