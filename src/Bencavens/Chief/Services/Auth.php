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
		return BaseAuth::getUser();
	}

	/**
	 * Check if the user has permission access to certain defined area
	 * 
	 * @param 	string 	$permission
	 * @param 	int 	$user_id
	 * @return 	bool
	 */
	public function hasAccess( $permission, $user_id = null )
	{
		$user = !is_null($user_id) ? BaseAuth::findUserById($user_id) : $this->getLogged();

		if( is_null( $user ) or !$user->hasAccess( $permission )) return false;

		return true;
	}

	/**
	 * Check if user belongs to a certain group
	 *
	 * @param 	string 	$group
	 * @param 	int 	$user_id
	 * @return 	bool
	 */
	public function inGroup( $group, $user_id = null)
	{
		$user = !is_null($user_id) ? BaseAuth::findUserById($user_id) : $this->getLogged();

		$group = BaseAuth::findGroupByName( $group );

		if( is_null( $user ) or is_null($group) or !$user->inGroup( $group )) return false;

		return true;
	}

	/**
	 * Check if user has a managementrole
	 *
	 * @param 	int 	$user_id
	 * @return 	bool
	 */
	public function isManager( $user_id = null )
	{
		return !(false == $this->inGroup('admin',$user_id) and false == $this->inGroup('chief',$user_id));
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