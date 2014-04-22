@extends('chief::_layouts.master')

@section('content')
	
	<h1>Jouw paswoord is gereset</h1>
	<p>Je dient je wel even opnieuw aan te melden.</p>
		
	<div class="topspace text-center">
		<a href="{{ route('chief.user.login') }}" class="btn btn-default">Back to Login</a>
	</div>

@stop