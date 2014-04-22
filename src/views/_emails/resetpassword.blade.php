@extends('chief::_layouts.mail')

@section('title')
	Paswoord reset
@stop

@section('content')

	Je hebt zonet via dit emailadres een wijziging van uw paswoord aangevraagd. 
	Klik op onderstaande link om een nieuw paswoord in te geven
	<br>
	<a href="{{ route('chief.user.resetpassword',array($user->id,$resetpasswordcode)) }}">Paswoord veranderen</a>
		
@stop


