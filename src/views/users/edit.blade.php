@extends('chief::_layouts.master')

@section('content')

	<h1 class="pagetitle">{{ $user->fullname }}</h1>

	{{ Form::model($user,array('route' => array('chief.users.update',$user->id),'method'=>'PUT')) }}

		@include('chief::_partials.errors')

	
		<div class="row">

			<div class="col-md-8">

				<div class="form-group">
					<label for="email">Email</label>
					{{ Form::email('email',null,array('class' => 'form-control','autocomplete' => 'off','placeholder' => 'email','id' => 'email')) }}

					<span class="note">Email will also be used as login</span>
				</div>

				<div class="form-group">
					<label>Role</label>
					{{ Form::select('groups',$groups,null,array('class' => 'form-control')) }}
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
				
				<br>

				<span class="note">
					<strong>Chief</strong> can manage posts, comments and users.<br>
					<strong>Writer</strong> can manage posts and comments.<br>
					<strong>Guest</strong> can only view posts but cannot edit them.  
				</span>
				
			</div>

			<div class="col-md-4">

				{{ Form::submit('save',array('class'=>'btn btn-lg btn-success btn-standalone')) }}
					<br>
					<a href="{{ URL::previous() }}" class="btn btn-default btn-xs">cancel</a>

					<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete-user-modal">
						<i class="glyphicon glyphicon-trash"></i> 
					</a>

			</div>

		</div>

	{{ Form::close() }}



	<!-- Modal -->
	<div class="modal fade" id="delete-user-modal" tabindex="-1" role="dialog" aria-labelledby="delete-user-modal-label" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				
				<div class="modal-body text-center">

					<p class="text-danger">Are you sure you want to remove this user entirely? <br>This will be permanent!</p>

						{{ Form::open(array('route' => array('chief.users.destroy',$user->id),'method'=>'DELETE')) }}

							<button type="submit" class="btn btn-danger btn-lg">
								<i class="glyphicon glyphicon-trash"></i> Yes, remove user
							</button>

						{{ Form::close() }}

					<br>
					<button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-default btn-sm">no, let 'm stay around</button>
						

				</div>

			</div>
		</div>
	</div>	

@stop

@section('redactor')
	@include('chief::_partials.redactor_air')
@stop