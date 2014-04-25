<?php namespace Bencavens\Chief\Users;

use Bencavens\Chief\Services\ErrorManager;

use Session,Str,Hash;

class UserManager{
	
	public function __construct( UserRepositoryInterface $repo,
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
		// Set activated to default
		if(!isset($input['activated'])) $input['activated'] = 1;

		// Password Creation
		if(!isset($input['password'])) $input['password'] = Str::random(8);

		// Keep password for notification to the admin
		Session::flash('user_password',$input['password']);

		// Sanitize input
	 	$userInput = $this->sanitizeInput( $input );
	 	
	 	// Validate input
	 	$success = $this->validateInput( $userInput );
	 	
		if($success)
		{
			$user = $this->repo->create( $userInput );
		
			// Update groups
			if(isset($input['groups']))
			{
				$user->groups()->sync((array)$input['groups']);
			}

			return $user;
		}

		return false;
	}

	/**
	 * Update a Resource
	 *
	 * @param 	int 	$user_id
	 * @param 	array 	$input
	 * @return 	bool
	 */
	public function update( $user_id, array $input )
	{
		$resource = $this->repo->getById( $user_id );

		// Sanitize input
	 	$userInput = $this->sanitizeInput( $input, $resource );
	 	
	 	// Validate input
	 	$success = $this->validateInput( $userInput, $resource );
	 	
	 	if($success)
		{
			$user = $this->repo->update( $user_id, $userInput );
		
			// Update groups
			if(isset($input['groups']))
			{
				$user->groups()->sync((array)$input['groups']);
			}

			return $user;
		}

		return false;

	}

	/**
	 * Sanitize a submitted form input
	 *
	 * @param 	array 	$input
	 * @param 	User 	$resource
	 * @return 	array
	 */
	public function sanitizeInput( array $input, User $resource = null )
	{
		// Filter out our user columns
		$columns = array('first_name','last_name','slug','email','description','activated','password');

		foreach($input as $attribute => $val )
		{
			if(!in_array($attribute,$columns)) unset($input[$attribute]);
		}

		// Hash the password
		if(isset($input['password'])) $input['password'] = Hash::make($input['password']);

		if(is_null($resource) or empty($resource->slug))
		{
			if((!isset($input['slug']) or empty($input['slug'])))
			{
				$input['slug'] = $input['first_name'].$input['last_name'];
			}
		}

		// Sluggify
		if(isset($input['slug']))
		{
		 	$input['slug'] = unique_slug(Str::slug($input['slug']),$this->repo,$resource); 
		}
		
		return $input;
	}

	/**
	 * Validate a submitted form input
	 *
	 * @param 	array 	$input
	 * @param 	User 	$resource
	 * @return 	bool
	 */
	public function validateInput( array $input, User $resource = null )
	{
		$required = array('first_name','last_name','email');

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
					$this->errorManager->trans('errors.users.'.$require.'.required');
				}
			}

			else if(empty($input[$require]))
			{
				$this->errorManager->trans('errors.users.'.$require.'.required');
			}
		}

		// Unique email
		$user = $this->repo->getByEmail( $input['email'] );

		if(is_null($resource) or $user->id != $resource->id)
		{
			$this->errorManager->trans('errors.users.email.unique');
		}

		return ($this->errorManager->hasAny()) ? false : true;
	}

	/**
	 * (Soft)delete resource
	 *
	 * @param 	int 	$user_id
	 * @return 	bool
	 */
	public function delete( $user_id )
	{
		return $this->repo->delete( $user_id );
	}

	/**
	 * Restore Softdeleted resource
	 *
	 * @param 	int 	$user_id
	 * @return 	bool
	 */
	public function restore( $user_id )
	{
		return $this->repo->restore( $user_id );
	}

	/**
	 * Remove a resource
	 *
	 * @param 	int 	$user_id
	 * @return 	bool
	 */
	public function forcedelete( $user_id )
	{
		return $this->repo->forcedelete( $user_id );
	}	
	
}