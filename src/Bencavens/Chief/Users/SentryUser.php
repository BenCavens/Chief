<?php namespace Bencavens\Chief\Users;

/*
|--------------------------------------------------------------------------
| Authentication Usermodel
|--------------------------------------------------------------------------
|
| Custom model which extends the Sentry Usermodel
|
*/

use Cartalyst\Sentry\Users\Eloquent\User as BaseSentryUser;

class SentryUser extends BaseSentryUser {
	
	protected $table = 'chiefusers';

	protected $guarded = array('password');
	protected $hidden = array('password');

	public static $rules = array();

	public $softDelete = false;

}
