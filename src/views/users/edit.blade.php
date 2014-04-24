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
					<strong>Manager</strong> Manages users and posts.Only a manager can add or edit userprofiles.<br>
					<strong>Chief</strong>A chief can create and edit posts and can publish or archive them. <br>
				</span>
				<!-- <span class="note">
					<strong>Manager</strong> Manages users and posts. He can create and edit posts and only a manager can add or change userprofiles.<br>
					<strong>Chief</strong> Supervises all writers. A chief can create and edit posts and can publish or archive them. <br>
					<strong>Writer</strong> A writer can create and edit posts where he is the author from.<br>
					<strong>Co-writer</strong> A co-writer can edit posts where he is the (co-)author from. He cannot create posts. <br>
					<strong>Guest</strong> A guest can view all published and drafted posts, without edit rights.
				</span> -->

			</div>

			<div class="col-md-4">

				{{ Form::submit('submit',array('class'=>'btn btn-lg btn-success')) }}
				<a href="{{ URL::previous() }}">cancel</a>

			</div>

		</div>

	{{ Form::close() }}

	{{ Form::open(array('route' => array('chief.users.destroy',$user->id),'method'=>'DELETE')) }}

		{{ Form::submit('delete') }}

	{{ Form::close() }}

@stop

@section('redactor')
	@include('chief::_partials.redactor_air')
@stop