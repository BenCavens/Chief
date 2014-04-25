<?php namespace Bencavens\Chief\Users;

use Cartalyst\Sentry\Groups\Eloquent\Group as SentryGroup;
use Illuminate\Database\Eloquent\Model;

class Group extends SentryGroup {
	
	protected $table = 'chiefgroups';

	protected $guarded = array();
	protected $hidden = array();

	public static $rules = array();

	public $softDelete = false;

	/**
	 * group related to an user
	 *
	 */
	public function users()
    {
        return $this->belongsToMany('Bencavens\Chief\Users\User','chiefuser_group','group_id','user_id');
    }

	
}
