<?php namespace Bencavens\Chief\Posts;

use Bencavens\Chief\Core\BaseRepository;
use Bencavens\Chief\Core\ChiefRepositoryInterface;
use Bencavens\Core\Traits\Filterable;
use Bencavens\Core\Traits\Sortable;

class PostRepository extends BaseRepository implements PostRepositoryInterface,ChiefRepositoryInterface{

	use Filterable,Sortable;

	/**
	 * List of allowed filters in the query payload
	 *
	 * @var array
	 */
	public $filterables = array('title','search');


	public function __construct( Post $model )
	{
		$this->setModel( $model );
	}

	/**
	 * Fetch
	 *
	 * Override the fetch metdho so we don't include article versions. 
	 * 
	 * @return  Illuminate\Database\Eloquent\Collection
	 *
	 */
	public function fetch()
	{
		$this->model = $this->model->where('parent_id',0);
		
		return parent::fetch();
	}

	/**
	 * Get Post by Slug
	 *
	 * Since this method is part of the frontend API
	 * 
	 * @param 	string $slug
	 * @return 	Post
	 */
	public function getBySlug( $slug )
	{
		return $this->model->where('status','published')
						   ->where('slug',$slug)
						   ->first();
	}

	/**
	 * Get all published articles
	 *
	 * @return  Collection
	 */
	public function getAllPublished()
	{
		return $this->getByStatus('published');
	}

	/**
	 * Get all Archived articles
	 *
	 * @return  Collection
	 */
	public function getAllArchived()
	{
		return $this->getByStatus('archived');
	}

	/**
	 * Get all Draft articles
	 *
	 * @return  Collection
	 */
	public function getAllDraft()
	{
		return $this->getByStatus('draft');
	}

	/**
	 * Get posts by status
	 *
	 * @param 	string 	$status
	 * @return  Collection
	 */
	protected function getByStatus( $status )
	{
		$this->model = $this->model->where('status',$status);
		
		return $this->fetch();
	}

	/**
	 * Get posts by Author
	 *
	 * @param 	int 	$user_id
	 * @return 	Collection
	 */
	public function getByAuthor( $author_id )
	{
		$this->model = $this->model->join('chiefauthors','chiefposts.id','=','chiefauthors.post_id')
						     	   ->where('chiefauthors.user_id',$author_id);

		return $this->fetch();
	}

	/**
	 * Get posts by popularity
	 *
	 * @return 	Collection
	 */
	public function getPopular()
	{
		$this->model = $this->model->orderBy('views','DESC');
		
		return $this->fetch();
	}

	/**
	 * Get all versions for a post
	 *
	 * @param 	int 	$type_id
	 * @return  Collection
	 */
	public function getVersionsById( $post_id )
	{
		$this->model = $this->model->where('parent_id',$post_id)->orderBy('created_at','DESC');
		
		return parent::fetch();
	}

	/**
	 * Create new version
	 *
	 * @param   int 	$post_id
	 * @param 	array 	$input
	 * @return 	Model
	 */
	 public function createVersion(Post $post, array $input )
	 {
	 	$version = $post;

	 	//$created_at_original = $version->created_at;

	 	$version->id = null;
	 	$version->parent_id = $post->id;
	 	$version->created_at = null;
	 	$version->save();

	 	dd($input);

	 	return $post->update($input);
	 	// update main record with new data
	 	// $input['id'] = $post_id;
	 	// $input['created_at'] = $created_at_original;

	 	// $this->model->create( $input );
	 } 

	

	/**
	 * Get posts by Tag
	 *
	 * @param 	int 	$tag_id
	 * @return  Collection
	 */
	public function getByTag( $tag_id )
	{
		$this->model = $this->model->join('chieftaggables','chiefposts.id','=','chieftaggables.taggable_id')
							 		->where('chieftaggables.taggable_type','=','Bencavens\Chief\Posts\Post')
							 		->where('chieftaggables.tag_id','=',$tag_id);

		return $this->fetch();

	}

	/**
	 * Get posts by Tags
	 *
	 * @param 	array 	$tag_ids
	 * @return  Collection
	 */
	public function getByTags( array $tag_ids )
	{
		$this->model = $this->model->join('chieftaggables','chiefposts.id','=','chieftaggables.taggable_id')
								   ->where('chieftaggables.taggable_type','=','Bencavens\Chief\Posts\Post')
								   ->whereIn('chieftaggables.tag_id',$tag_ids);

		return $this->fetch();
	}

	/**
	 * Get posts by category
	 *
	 * @param 	int 	$category_id
	 * @return  Collection
	 */
	public function getByCategory( $category_id )
	{
		return $this->getByTag( $category_id );
	}

	/**
	 * Get posts by categories
	 *
	 * @param 	array 	$category_ids
	 * @return  Collection
	 */
	public function getByCategories( array $category_ids )
	{
		return $this->getByTags( $category_ids );
	}

	/**
	 * Get posts without a category
	 *
	 * [TODO] 	should refactor to a single SQL statement. 
	 * 			Now it is just an ugly three-part retrieval due to the difficult nature of a morphByMany relation
	 * 
	 * @return  Collection
	 */
	public function getWithoutCategory()
	{
		$categories = \Bencavens\Chief\Tags\Category::all();
		$category_ids = array_pair($categories->toArray(),'id');

		// Get all posts that have categories
		$postsCategorized = $this->getByCategories($category_ids);

		$this->model = $this->model->whereNotIn('id',array_pair($postsCategorized->toArray(),'id'));

		return $this->fetch();

	}

	/**
	 * Custom global Text search
	 *
	 * @param 	string 	$value
	 * @return 	void
	 */
	public function filterBySearch( $value )
	{
		$this->model = $this->model->where('title','LIKE','%'.$value.'%')
								   ->orWhere('content','LIKE','%'.$value.'%');
	}

	

}