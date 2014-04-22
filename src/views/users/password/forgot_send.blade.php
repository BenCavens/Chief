@extends('chief::_layouts.master')

@section('content')
	
	<h1>Resetmail verzonden</h1>
	<p>
		
		Wij hebben je een mailtje verzonden met daarin de link om jouw paswoord te resetten.
		Klik in de mail op deze link om een nieuw paswoord in te geven.

		<div class="topspace text-center">
			<a href="{{ route('chief.user.login') }}" class="btn btn-default">Back to Login</a>
		</div>
	</p>
	
	

	
	
	
@stop

