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

				<div class="text-center">
					
					{{ Form::submit('save',array('class'=>'btn btn-lg btn-success btn-standalone')) }}
					<br>
					<a href="{{ URL::previous() }}" class="btn btn-default btn-xs">cancel</a>

					<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete-post-modal">
						<i class="glyphicon glyphicon-trash"></i> 
					</a>

					<hr class="post-divider">

					<div class="btn-group center" data-toggle="buttons">
				  
					  	@foreach(array('draft','published','archived') as $type )
					  		
					  		<label class="btn btn-default btn-checkable">
					  			{{ Form::radio('status',$type,null,array('id'=>'status'.$type)) }}
					  			{{ ucfirst($type) }}
					  		</label>
					  	
					  	@endforeach

					 </div>

					<br><br>
					<div id="post-slug">
						<label>Permalink</label>
						<span class="note">{{ Form::text('slug',null,array('class' => 'form-control','autocomplete' => 'off')) }}</span>
			 		</div>	

					<hr class="post-divider">

					<label>
						{{ Form::checkbox('allow_comments',1,null) }} Allow comments
					</label>

				</div>

				<hr class="post-divider" data-toggle="buttons">

				<div class="text-center">

					<h4 class="text-center">Categories</h4>

					@foreach($categories as $category)
						<label for="cat-{{$category->id}}" class="btn btn-xs btn-default">
							{{ Form::checkbox('category_ids[]',$category->id,null,array('id' => 'cat-'.$category->id)) }} {{ $category->name }}
						</label>
					@endforeach

				</div>

				<div class="text-center">

					<h4 class="text-center">Tags</h4>

					@foreach($tags as $tag)
						<label for="tag-{{$tag->id}}" class="btn btn-xs btn-default">
							{{ Form::checkbox('tag_ids[]',$tag->id,null,array('id' => 'tag-'.$tag->id)) }} {{ $tag->name }}
						</label>
					@endforeach

				</div>

				

			</div>

		</div>

	{{ Form::close() }}

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

@stop

@section('redactor')

	@include('chief::_partials.redactor')

@stop