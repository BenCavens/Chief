<?php namespace Bencavens\Chief\Tags;

use Illuminate\Database\Eloquent\Model;

class Category extends Model{

	protected $table = 'chieftags';

	public function posts()
	{
		return $this->morphByMany('Bencavens\Chief\Posts\Post','taggable','chieftaggables','taggable_id','tag_id')->where('chieftags.cat',1);
	}

}