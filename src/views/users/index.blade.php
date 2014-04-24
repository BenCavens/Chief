@extends('chief::_layouts.master')

@section('content')

	<h1>Your Users 
		<a class="btn btn-default btn-xs" href="{{ route('chief.users.create') }}"><i class="glyphicon glyphicon-pencil"></i> add another user</a>
	</h1>

	<div class="users-cards clearfix">

		@foreach($users as $user)
			
			<div class="user-card">
				
				<h3>{{ $user->fullname }}

					<span class="actionline">

						<a href="{{ route('chief.users.edit',$user->id) }}"><i class="glyphicon glyphicon-cog"></i></a>

					</span>

					<span class="label label-info">{{ $user->status }}</span>

				</h3>

			</div>

		@endforeach

	</div>

	{{ $users->links() }}
	

@stop