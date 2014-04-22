<?php namespace Bencavens\Chief\Users;

use Illuminate\Database\Eloquent\Model;

class User extends Model{

	protected $table = 'chiefusers';

	protected $fillable = array('first_name','last_name','slug','email','description','avatar');

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

}

