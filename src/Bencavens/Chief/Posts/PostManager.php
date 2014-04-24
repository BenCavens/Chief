<?php namespace Bencavens\Chief\Posts;

use Bencavens\Chief\Services\ErrorManager;

use Str;

class PostManager{
	
	public function __construct( PostRepositoryInterface $repo,
								 ErrorManager $errorManager )
	{
		$this->repo = $repo;
		$this->errorManager = $errorManager;
	}

	/**
	 * Create a new Resource
	 *
	 * @param 	array 	$input
	 * @return 	int 	$inserted id
	 */
	public function create( array $input )
	{
		// Sanitize input
	 	$postInput = $this->sanitizeInput( $input );
	 	
	 	// Validate input
	 	$success = $this->validateInput( $postInput );
	 	
		if($success)
		{
			$post = $this->repo->create( $postInput );
		
			$tag_ids = isset($input['tag_ids']) ? $input['tag_ids'] : array();
			$category_ids = isset($input['category_ids']) ? $input['category_ids'] : array();
			
			// Synchronise tags and categories
			$post->synchroniseTags( array_merge( $tag_ids, $category_ids) );

			return $post;
		}

		return false;
	}

	/**
	 * Update a Resource
	 *
	 * @param 	int 	$post_id
	 * @param 	array 	$input
	 * @return 	bool
	 */
	public function update( $post_id, array $input )
	{
		$resource = $this->repo->getById( $post_id );

		// Sanitize input
	 	$postInput = $this->sanitizeInput( $input, $resource );
	 	
	 	// Validate input
	 	$success = $this->validateInput( $postInput, $resource );
	 	
	 	if($success)
		{
			$post = $this->repo->update( $post_id, $postInput );
		
			$tag_ids = isset($input['tag_ids']) ? $input['tag_ids'] : array();
			$category_ids = isset($input['category_ids']) ? $input['category_ids'] : array();
			
			// Synchronise tags and categories
			$post->synchroniseTags( array_merge( $tag_ids, $category_ids) );
			//$post->synchroniseCategories( $category_ids );

			return $post;
		}

		return false;

	}

	/**
	 * Sanitize a submitted form input
	 *
	 * @param 	array 	$input
	 * @param 	Post 	$resource
	 * @return 	array
	 */
	public function sanitizeInput( array $input, Post $resource = null )
	{
		// Filter out our post columns
		$columns = array('title','subtitle','slug','content','status','allow_comments');

		foreach($input as $attribute => $val )
		{
			if(!in_array($attribute,$columns)) unset($input[$attribute]);
		}

		if(is_null($resource) or empty($resource->slug))
		{
			// Default slug
			if(isset($input['title']) and !empty($input['title']) and (!isset($input['slug']) or empty($input['slug'])))
			{
				$input['slug'] = $input['title'];
			}
		}

		// Slug
		if(isset($input['slug']))
		{
			$input['slug'] = Str::slug($input['slug']);
		}
		
		// unique slug
		// ....
		
		// Allow comments check
		if(!isset($input['allow_comments'])) $input['allow_comments'] = 0;

		return $input;
	}

	/**
	 * Validate a submitted form input
	 *
	 * @param 	array 	$input
	 * @param 	Post 	$resource
	 * @return 	bool
	 */
	public function validateInput( array $input, Post $resource = null )
	{
		$required = array('title','slug');

		foreach($required as $require)
		{
			/**
			 * If specified attribute is not passed as input
			 * The resource must hold a value for this required as existing value
			 */
			if(!array_key_exists($require,$input))
			{
				if(is_null($resource) or empty($resource->$require))
				{
					$this->errorManager->trans('errors.posts.'.$require.'.required');
				}
			}

			else if(empty($input[$require]))
			{
				$this->errorManager->trans('errors.posts.'.$require.'.required');
			}
		}

		// Check unique slug
		// ....

		return ($this->errorManager->hasAny()) ? false : true;
	}

	/**
	 * (Soft)delete resource
	 *
	 * @param 	int 	$post_id
	 * @return 	bool
	 */
	public function delete( $post_id )
	{
		return $this->repo->delete( $post_id );
	}

	/**
	 * Restore Softdeleted resource
	 *
	 * @param 	int 	$post_id
	 * @return 	bool
	 */
	public function restore( $post_id )
	{
		return $this->repo->restore( $post_id );
	}

	/**
	 * Remove a resource
	 *
	 * @param 	int 	$post_id
	 * @return 	bool
	 */
	public function forcedelete( $post_id )
	{
		return $this->repo->forcedelete( $post_id );
	}	
	
}