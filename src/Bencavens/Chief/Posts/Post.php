<?php namespace Bencavens\Chief\Posts;


use Bencavens\Chief\Core\BaseModel;

class Post extends BaseModel{

	protected $table = 'chiefposts';

	protected $fillable = array('title','subtitle','slug','content','status','allow_comments','comment_count','views','parent_id');

	protected $softDelete =true;

	public function authors()
	{
		return $this->belongsToMany('Bencavens\Chief\Users\User','chiefauthors','post_id','user_id')->withPivot('order')->orderBy('order','ASC');
	}

	public function comments()
	{
		return $this->hasMany('Bencavens\Chief\Posts\Comment','post_id');
	}

	public function tags()
    {
        return $this->morphToMany('Bencavens\Chief\Tags\Tag', 'taggable','chieftaggables')->where('chieftags.cat',0);
    }

    public function categories()
    {
        return $this->morphToMany('Bencavens\Chief\Tags\Category','taggable','chieftaggables','taggable_id','tag_id')->where('chieftags.cat',1);
        //return $this->morphToMany('Bencavens\Chief\Tags\Category', 'categorizable','chiefcategorizables');
    }

	/**
	 * Clean up HTML
	 * Protect our fortress
	 * 
	 * @param  string 	$value
	 */
	public function setContentAttribute( $value )
	{
		$this->attributes['content'] = cleanupHTML( $value );
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

	/**
	 * Bump view
	 *
	 * @param 	int 	$amount
	 * @return  $this
	 */
	public function bumpView( $amount = 1 )
	{
		$this->views += $amount;
		$this->save();
	}

	/**
	 * Bump Comment Count
	 *
	 * @param 	int 	$amount
	 * @return  $this
	 */
	public function bumpComment( $amount = 1 )
	{
		$this->comment_count += $amount;
		$this->save();
	}

	/**
	 * Synchronise tags and categories
	 * For synchro we need to collect tags and cats at once or else one might override the other sync
	 *
	 * @param 	array 	$tag_ids
	 * @return 	void
	 */
	public function synchroniseTags( array $tag_ids = array() )
	{
		$this->tags()->sync( $tag_ids );
	}

	/**
	 * Add an author
	 *
	 * @param 	int 	$user_id
	 * @param 	array 	$attributes
	 * @return 	void
	 */
	public function addAuthor( $user_id, array $attributes = array() )
	{
		$this->authors()->attach( $user_id, $attributes );
	}

	/**
	 * Remove an author
	 *
	 * @param 	int 	$user_id
	 * @return 	void
	 */
	public function removeAuthor( $user_id )
	{
		$this->authors()->detach( $user_id );
	}

	/**
	 * Creates a shortened version of input string
	 *
	 * @param   string   $value
	 * @param   string   $ending - how to end a cutted text. 
	 * @param 	bool 	 $clean - use cleanHTML on the value
	 * @return  string
	 */
	public function teaser($max = 210,$ending = null, $clean = true)
	{
		return teaser( $this->plaincontent,$max, $ending, $clean );
	}

	/**
	 * Allow comments?
	 *
	 * @return 	bool
	 */
	public function allowComments()
	{
		return !!$this->getAttribute('allow_comments');
	}

}