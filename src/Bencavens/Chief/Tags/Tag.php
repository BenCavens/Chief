<?php namespace Bencavens\Chief\Tags;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model{

	protected $table = 'chieftags';

	public function posts()
	{
		return $this->morphedByMany('Post','taggable');
	}

}