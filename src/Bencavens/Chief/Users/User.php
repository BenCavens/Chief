<?php namespace Bencavens\Chief\Users;

use Bencavens\Chief\Core\BaseModel;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUser;

class User extends SentryUser{

	protected $table = 'chiefusers';

	protected $guarded = array('password');
	protected $hidden = array('password');

	public static $rules = array();

	protected $fillable = array('first_name','last_name','slug','email','activated','password','permissions','description','avatar');

	public function posts()
	{
		return $this->belongsToMany('Bencavens\Chief\Posts\Post','chiefauthors','user_id','post_id');
	}

	public function groups()
	{
		return $this->belongsToMany('Bencavens\Chief\Users\Group','chiefuser_group','user_id','group_id');
	}

	public function getFullnameAttribute()
	{
		return $this->getAttribute('first_name').' '.$this->getAttribute('last_name');
	}

	/**
	 * Extension of Laravel toArray
	 *
	 * toArray extension is normally part of the bencavens\Core\Models\BaseModel class 
	 * but since our User model inherits from the Sentry User class, our utilised 
	 * methods should be injected straight into our model class
	 * 
	 * @return  array
	 */
	public function toArray()
    {
        $array = parent::toArray();
        
        foreach ($this->getMutatedAttributes() as $key)
        {
            if ( ! array_key_exists($key, $array)) 
            {
                $array[$key] = $this->{$key};   
            }
        }

        return $array;
     }

}

