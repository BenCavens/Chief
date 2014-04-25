@extends('chief::_layouts.master')

@section('content')

	{{ Form::model($comment,array('route' => array('chief.comments.update',$comment->id),'method'=>'PUT')) }}

		@include('chief::_partials.errors')

		<div class="row">

			<div class="col-md-8">

				{{ Form::text('username',null,array('class'=>'form-control','placeholder' => 'username')) }}
				{{ Form::email('email',null,array('class'=>'form-control','placeholder' => 'email')) }}

				{{ Form::textarea('content',null,array('class'=>'form-control-post post-txtr','placeholder' => 'comment','id' => 'redactor_air')) }}
			
			</div>

			<div class="col-md-4">

				{{ Form::submit('save',array('class'=>'btn btn-lg btn-success btn-standalone')) }}
				<br>
				<a href="{{ URL::previous() }}" class="btn btn-default btn-xs">cancel</a>

				@if(false != $permissions->comment_delete)
					<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete-comment-modal">
						<i class="glyphicon glyphicon-trash"></i> 
					</a>
				@endif

				<div class="btn-group" data-toggle="buttons">
				  
				  	@foreach(array('pending','approved','denied') as $type )
				  		
				  		<label class="btn btn-default btn-checkable">
				  			{{ Form::radio('status',$type,null,array('id'=>'status'.$type)) }}
				  			{{ ucfirst($type) }}
				  		</label>
				  	
				  	@endforeach

				 </div>

			
				

			</div>

		</div>

	{{ Form::close() }}

	@if(false != $permissions->comment_delete)
		<!-- Modal -->
		<div class="modal fade" id="delete-comment-modal" tabindex="-1" role="dialog" aria-labelledby="delete-comment-modal-label" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					
					<div class="modal-body text-center">

						<p class="text-danger">Permanently delete this comment?</p>

							{{ Form::open(array('route' => array('chief.comments.destroy',$comment->id),'method'=>'DELETE')) }}

								<button type="submit" class="btn btn-danger btn-lg">
									<i class="glyphicon glyphicon-trash"></i> Yes, delete comment
								</button>

							{{ Form::close() }}

						<br>
						<button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-default btn-sm">no, keep it unharmed</button>
							

					</div>

				</div>
			</div>
		</div>	
	@endif

@stop

@section('redactor')
	@include('chief::_partials.redactor_air')
@stop