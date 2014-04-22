<?php namespace Bencavens\Chief\Users;

use Bencavens\Chief\Core\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface{

	public function __construct( User $model )
	{
		$this->model = $model;
	}

	/**
	 * Find a user by Email (unique)
	 * 
	 * @param 	string  $email
	 * @return  User
	 */
	public function getByEmail( $email )
	{
		return $this->model->where('email',$email)->first();
	}

}