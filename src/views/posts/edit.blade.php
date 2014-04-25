@extends('chief::_layouts.master')

@section('content')

	{{ Form::model($post,array('route' => array('chief.posts.update',$post->id),'method'=>'PUT')) }}

		@include('chief::_partials.errors')

		<h1 class="post-title">
			{{ Form::text('title',null,array('class' => 'form-control-post','autocomplete' => 'off','placeholder' => 'title')) }}

		</h1>
		
		<p class="post-subtitle">{{ Form::text('subtitle',null,array('class' => 'form-control-post','autocomplete' => 'off','placeholder' => 'subtitle')) }}</p>
		

		<div class="row">

			<div class="col-md-8">

				{{ Form::textarea('content',null,array('class'=>'form-control-post post-txtr','placeholder' => 'article content','id'=>'redactor_content')) }}
			
			</div>

			<div class="col-md-4 sidebar">

				<div>
					
					{{ Form::submit('save',array('class'=>'btn btn-lg btn-success btn-standalone')) }}
					<br>
					<a href="{{ URL::previous() }}" class="btn btn-default btn-xs">cancel</a>

					@if(false != $permissions->post_delete)
						<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete-post-modal">
							<i class="glyphicon glyphicon-trash"></i> 
						</a>
					@endif

					<hr>

					<div class="btn-group btn-group-sm" data-toggle="buttons">

						<label for="status-draft" class="btn btn-checkable btn-default">
				  			{{ Form::radio('status','draft',null,array('id'=>'status-draft')) }} Draft
				  		</label>

				  		<label for="status-published" class="btn btn-checkable btn-default">
				  			{{ Form::radio('status','published',null,array('id'=>'status-published')) }} <span class="text-success">Publish</span>
				  		</label>

					  	<label for="status-archived" class="btn btn-checkable btn-default">
				  			{{ Form::radio('status','archived',null,array('id'=>'status-archived')) }} <span class="text-danger">Archive</span>
				  		</label>

					</div>

					<hr>

					<div id="post-slug">
						<label>Permalink</label>
						<span class="note">{{ Form::text('slug',null,array('class' => 'form-control','autocomplete' => 'off')) }}</span>
			 		</div>	
			 		<br>
					<label>
						{{ Form::checkbox('allow_comments',1,null) }} Allow comments
					</label>

				</div>

				<hr>

				<div>

					<h4>Categories</h4>

					<div data-toggle="buttons">

						@foreach($categories as $category)
							<label for="cat-{{$category->id}}" class="btn btn-xs btn-default btn-standalone btn-checkable">
								{{ Form::checkbox('category_ids[]',$category->id,null,array('id' => 'cat-'.$category->id)) }} {{ $category->name }}
							</label>
						@endforeach

					</div>

				</div>

				<div>

					<h4>Tags</h4>

					<div data-toggle="buttons">

						@foreach($tags as $tag)
							<label for="tag-{{$tag->id}}" class="btn btn-xs btn-default btn-standalone btn-checkable">
								{{ Form::checkbox('tag_ids[]',$tag->id,null,array('id' => 'tag-'.$tag->id)) }} {{ $tag->name }}
							</label>
						@endforeach

					</div>

				</div>

				

			</div>

		</div>

	{{ Form::close() }}

	@if(false != $permissions->post_delete)
		<!-- Modal -->
		<div class="modal fade" id="delete-post-modal" tabindex="-1" role="dialog" aria-labelledby="delete-post-modal-label" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					
					<div class="modal-body text-center">

						<p class="text-danger">You are about to delete this post. <br>This will be permanent. No way back</p>

							{{ Form::open(array('route' => array('chief.posts.destroy',$post->id),'method'=>'DELETE')) }}

								<button type="submit" class="btn btn-danger btn-lg">
									<i class="glyphicon glyphicon-trash"></i> Yes, delete post
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

	@include('chief::_partials.redactor')

@stop