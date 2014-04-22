<?php namespace Bencavens\Chief\Posts;

use Bencavens\Chief\Core\BaseRepository;
use Bencavens\Chief\Core\ChiefRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface,ChiefRepositoryInterface{

	public function __construct( Post $model )
	{
		$this->model = $model;
	}

	/**
	 * Fetch
	 *
	 * Don't include our versions by default
	 * 
	 * @param 	array 	$options
	 * @param 	int  	$paginated 
	 * @return  Illuminate\Database\Eloquent\Collection
	 *
	 */
	public function fetch( array $options = array(), $paginated = null )
	{
		// Defaults
		$options = array('whereParentId' => 0) + $options;

		return parent::fetch( $options, $paginated );
	}

	/**
	 * Create new version
	 *
	 * @param   int 	$post_id
	 * @param 	array 	$input
	 * @return 	Model
	 */
	 public function createVersion($post_id, array $input )
	 {
	 	// create version record with 'old' data
	 	$version = $this->getById($post_id);

	 	$created_at_original = $version->created_at;

	 	$version->id = null;
	 	$version->parent_id = $post_id;
	 	$version->created_at = null;
	 	$version->save();

	 	// update main record with new data
	 	$input['id'] = $post_id;
	 	$input['created_at'] = $created_at_original;
	 	$this->model->create( $input );

	 } 

	/**
	 * Get all published articles
	 *
	 * @param 	array 	$options
	 * @param 	int 	$paginated
	 * @return  Collection
	 */
	public function getAllPublished( array $options = array(), $paginated = null )
	{
		return $this->getByStatus('published', $options, $paginated );
	}

	/**
	 * Get all Archived articles
	 *
	 * @param 	array 	$options
	 * @param 	int 	$paginated
	 * @return  Collection
	 */
	public function getAllArchived( array $options = array(), $paginated = null )
	{
		return $this->getByStatus('archived', $options, $paginated );
	}

	/**
	 * Get all Draft articles
	 *
	 * @param 	array 	$options
	 * @param 	int 	$paginated
	 * @return  Collection
	 */
	public function getAllDraft( array $options = array(), $paginated = null )
	{
		return $this->getByStatus('draft', $options, $paginated );
	}

	/**
	 * Get posts by status
	 *
	 * @param 	string 	$status
	 * @param 	array 	$options
	 * @param 	int 	$paginated
	 * @return  Collection
	 */
	protected function getByStatus( $status, array $options = array(), $paginated = null )
	{
		$options = array('where'=> array('status',$status)) + $options;

		return $this->fetch( $options, $paginated );
	}

	/**
	 * Get posts by Author
	 *
	 * @param 	int 	$user_id
	 * @param 	int 	$paginated
	 * @return 	Collection
	 */
	public function getByAuthor( $author_id, $paginated = null )
	{
		$posts = $this->model->join('chiefauthors','chiefposts.id','=','chiefauthors.post_id')
						   ->where('chiefauthors.user_id',$author_id);

		return ($paginated) ? $posts->paginate($paginated) : $posts->get();
	}

	/**
	 * Get posts by popularity
	 *
	 * @param 	int 	$user_id
	 * @return 	Collection
	 */
	public function getPopular( array $options = array() )
	{
		$options = array('orderBy'=> array('views','DESC')) + $options;

		return $this->fetch( $options );
	}

	/**
	 * Get all versions for a post
	 *
	 * @param 	int 	$type_id
	 * @param 	array 	$options
	 * @return  Collection
	 */
	public function getVersionsById( $post_id, array $options = array('orderBy' => array('created_at','DESC')) )
	{
		$model = $this->extend( $options );

		return $model->where('parent_id',$post_id)->get();
	}

	/**
	 * Get posts by Tag
	 *
	 * @param 	int 	$tag_id
	 * @param 	array 	$options
	 * @return  Collection
	 */
	public function getByTag( $tag_id, array $options = array() )
	{
		$model = $this->extend( $options );

		return $model->join('chieftaggables','chiefposts.id','=','chieftaggables.taggable_id')
							 ->where('chieftaggables.taggable_type','=','Bencavens\Chief\Posts\Post')
							 ->where('chieftaggables.tag_id','=',$tag_id)
							 ->get();

	}

	/**
	 * Get posts by Tags
	 *
	 * @param 	array 	$tag_ids
	 * @param 	array 	$options
	 * @return  Collection
	 */
	public function getByTags( array $tag_ids, array $options = array() )
	{
		$model = $this->extend( $options );

		return $model->join('chieftaggables','chiefposts.id','=','chieftaggables.taggable_id')
							 ->where('chieftaggables.taggable_type','=','Bencavens\Chief\Posts\Post')
							 ->whereIn('chieftaggables.tag_id',$tag_ids)
							 ->get();
	}

	/**
	 * Get posts by category
	 *
	 * @param 	int 	$category_id
	 * @param 	array 	$options
	 * @return  Collection
	 */
	public function getByCategory( $category_id, array $options = array() )
	{
		return $this->getByTag( $category_id, $options );
	}

	/**
	 * Get posts by categories
	 *
	 * @param 	array 	$category_ids
	 * @param 	array 	$options
	 * @return  Collection
	 */
	public function getByCategories( array $category_ids, array $options = array() )
	{
		return $this->getByTags( $category_ids, $options );
	}

	/**
	 * Get posts without a category
	 *
	 * TODO: should refactor to a single SQL statement. 
	 * Now it is just an ugly three-part retrieval due to the difficult nature of a morphByMany relation
	 * 
	 * @param 	array 	$options
	 * @return  Collection
	 */
	public function getWithoutCategory( array $options = array() )
	{
		
		$categories = \Bencavens\Chief\Tags\Category::all();
		$category_ids = array_pair($categories->toArray(),'id');

		// Get all posts that have categories
		$postsCategorized = $this->getByCategories($category_ids);

		$model = $this->extend( $options );

		return $model->whereNotIn('id',array_pair($postsCategorized->toArray(),'id'));

	}

	

}