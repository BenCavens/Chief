<?php namespace Bencavens\Chief\Posts;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model{

	protected $table = 'chiefcomments';

	public function author()
	{
		return $this->belongsTo('Bencavens\Chief\Users\User','user_id');
	}

	public function post()
	{
		return $this->belongsTo('Bencavens\Chief\Posts\Post','post_id');
	}

	public function replies()
	{
		return $this->hasMany('Bencavens\Chief\Posts\Comment','parent_id');
	}

	/**
	 * Clean up HTML
	 * Protect our fortress
	 * 
	 * @param  string 	$value
	 */
	public function setContentAttribute( $value )
	{
		$value = cleanupHTML( $value );

		// Comment are only allowed to have specific html tags
		// We will whitelist them in advance
		$this->attributes['content'] = strip_tags($value,'<a><br><p><b><i><em><strong>');

		
	}

	/**
	 * Custom attribute: plaincontent
	 *
	 */
	public function getPlaincontentAttribute()
	{
		$content = $this->getAttribute('content');
		
		// Strip tags
		$content = strip_tags($content);

		// ...

		return $content;
	}

}