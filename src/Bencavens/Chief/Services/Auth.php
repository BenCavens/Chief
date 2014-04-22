<?php namespace Bencavens\Chief\Services;

// This facade cannot be injected as dependency
// causes unknown persistent session issue
use Bencavens\Chief\Services\ChiefSentryFacade as BaseAuth;

class Auth{
	
	public function __construct()
	{
		
	}

	/**
	 * Checks if the current visitor is logged in
	 *
	 * @return bool
	 */
	public function isLogged()
	{
		return BaseAuth::check();
	}

	/**
	 * Returns the usersdata off the current logged user
	 * 
	 * @return Eloquent Model
	 */
	public function getLogged()
	{
		//dd(BaseAuth::getUser()->toArray());
		return BaseAuth::getUser();
	}

	/**
	 * Authenticate the credentials and log the user into the application
	 *
	 * @param  	array 	$credentials
	 * @param   bool    $remember
	 * @return  bool
	 */
	public function login(array $credentials,$remember = false)
	{
		return BaseAuth::authenticate($credentials,$remember);
	}

	/**
	 * Log the user in the system
	 *
	 * @param  	int  	$userid
	 * @param   bool    $remember
	 * @return  bool
	 */
	public function loginById($userid,$remember = false)
	{
		$user = BaseAuth::getUserProvider()->findById($userid);
		
		return BaseAuth::login($user,$remember);
	}



	/**
	 * Log the current user out of session
	 *
	 */
	public function logout()
	{
		return BaseAuth::logout();
	}

	/**
	 * Register a new user
	 *
	 */
	public function register(array $credentials)
	{
		return BaseAuth::register($credentials);
	}

	/**
	 * Activate the user
	 *
	 * @param  	int  	$userid
	 * @param   string  $activationcode
	 * @return  bool
	 */
	public function activate($userid,$activationcode)
	{
		$user = BaseAuth::getUserProvider()->findById($userid);
		
		return $user->attemptActivation($activationcode);
	}

	/**
	 * Generate a new activation code
	 *
	 */
	public function generateActivationCode($userid)
	{
		$user = BaseAuth::getUserProvider()->findById($userid);

		return $user->getActivationCode();
	}

	/**
	 * Generate a new reset password code
	 *
	 */
	public function generateResetPasswordCode($userid)
	{
		$user = BaseAuth::getUserProvider()->findById($userid);

		return $user->getResetPasswordCode();
	}

	/**
	 * Check a reset password code against one in storage
	 *
	 */
	public function checkResetPasswordCode($userid,$resetcode)
	{
		$user = BaseAuth::getUserProvider()->findById($userid);

		return $user->checkResetPasswordCode($resetcode);
	}

	/**
	 * Reset user's password
	 *
	 * @param  	int  	$userid
	 * @param   string  $resetcode
	 * @param   string  $password (new one)
	 * @return  bool
	 */
	public function resetPassword($userid,$resetcode,$password)
	{
		$user = BaseAuth::getUserProvider()->findById($userid);
		
		return $user->attemptResetPassword($resetcode,$password);
	}

	/**
	 * Checks if the user is part of the Administrator group
	 *
	 * @return bool
	 */
	public function isAdministrator()
	{
		return $this->belongsTo('Administrator');
	}

	/**
	 * Checks if the user is part of a certain group
	 *
	 * @param  string   $groupname
	 * @return bool
	 */
	public function belongsTo($groupname)
	{
		// Get the admin group
		$admin = BaseAuth::getGroupProvider()->findByName($groupname);

    	// Get user based on userid
    	$user = $this->getLogged();

    	return !!($user->inGroup($admin));
	}
	
}