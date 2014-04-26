<?php namespace Bencavens\Chief\Posts;

use Bencavens\Chief\Services\ErrorManager;

use Str;

class CommentManager{
	
	public function __construct( CommentRepositoryInterface $repo,
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
	 	$commentInput = $this->sanitizeInput( $input );
	 	
	 	// Validate input
	 	$success = $this->validateInput( $commentInput );
	 	
		if($success)
		{
			$comment = $this->repo->create( $commentInput );
		
			return $comment;
		}

		return false;
	}

	/**
	 * Update a Resource
	 *
	 * @param 	int 	$comment_id
	 * @param 	array 	$input
	 * @return 	bool
	 */
	public function update( $comment_id, array $input )
	{
		$resource = $this->repo->getById( $comment_id );

		// Sanitize input
	 	$commentInput = $this->sanitizeInput( $input, $resource );
	 	
	 	// Validate input
	 	$success = $this->validateInput( $commentInput, $resource );
	 	
	 	if($success)
		{
			$comment = $this->repo->update( $comment_id, $commentInput );
		
			return $comment;
		}

		return false;

	}

	/**
	 * Sanitize a submitted form input
	 *
	 * @param 	array 	$input
	 * @param 	Comment 	$resource
	 * @return 	array
	 */
	public function sanitizeInput( array $input, Comment $resource = null )
	{
		// Filter out our comment columns
		$columns = array('content','status','username','email');

		foreach($input as $attribute => $val )
		{
			if(!in_array($attribute,$columns)) unset($input[$attribute]);
		}

		
		return $input;
	}

	/**
	 * Validate a submitted form input
	 *
	 * @param 	array 	$input
	 * @param 	Comment 	$resource
	 * @return 	bool
	 */
	public function validateInput( array $input, Comment $resource = null )
	{
		$required = array('content');

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
					$this->errorManager->trans('errors.comments.'.$require.'.required');
				}
			}

			else if(empty($input[$require]))
			{
				$this->errorManager->trans('errors.comments.'.$require.'.required');
			}
		}

		// Check unique slug
		// ....

		return ($this->errorManager->hasAny()) ? false : true;
	}

	/**
	 * Delete resource
	 *
	 * @param 	int 	$comment_id
	 * @return 	bool
	 */
	public function delete( $comment_id )
	{
		return $this->repo->delete( $comment_id );
	}	
	
}