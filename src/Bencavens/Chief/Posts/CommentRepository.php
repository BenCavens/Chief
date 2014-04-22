<?php namespace Bencavens\Chief\Posts;

use Bencavens\Chief\Core\BaseRepository;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface{

	public function __construct( Comment $model )
	{
		$this->model = $model;
	}

	/**
	 * Fetch
	 *
	 * 
	 * 
	 * @param 	array 	$options
	 * @param 	int  	$paginated 
	 * @return  Illuminate\Database\Eloquent\Collection
	 *
	 */
	public function fetch( array $options = array(), $paginated = null )
	{
		// Defaults
		$options = array('with' => array('post','author')) + $options;

		return parent::fetch( $options, $paginated );
	}

	/**
	 * Get all Approved articles
	 *
	 * @param 	array 	$options
	 * @return  Collection
	 */
	public function getAllApproved( array $options = array() )
	{
		return $this->getByStatus('approved', $options );
	}

	/**
	 * Get all Denied articles
	 *
	 * @param 	array 	$options
	 * @return  Collection
	 */
	public function getAllDenied( array $options = array() )
	{
		return $this->getByStatus('denied', $options );
	}

	/**
	 * Get all Pending articles
	 *
	 * @param 	array 	$options
	 * @return  Collection
	 */
	public function getAllPending( array $options = array() )
	{
		return $this->getByStatus('pending', $options );
	}

	/**
	 * Get all (approved) comments by post
	 *
	 * @param 	int 	$post_id
	 * @param 	string 	$status
	 * @param 	array 	$options
	 * @return  Collection
	 */
	public function getByPost( $post_id, $status = 'approved', array $options = array() )
	{
		$options = array('where'=> array('post_id',$post_id)) + $options;

		return $this->getByStatus($status, $options );
	}

	/**
	 * Get all comments by post
	 *
	 * @param 	int 	$post_id
	 * @param 	string 	$status
	 * @param 	array 	$options
	 * @return  Collection
	 */
	public function getAllByPost( $post_id, array $options = array() )
	{
		$options = array('where'=> array('post_id',$post_id)) + $options;

		return $this->getAll( $options );
	}

	/**
	 * Get posts by status
	 *
	 * @param 	string 	$status
	 * @param 	array 	$options
	 * @return  Collection
	 */
	protected function getByStatus($status, array $options = array() )
	{
		$options = array('where'=> array('status',$status)) + $options;

		return $this->getAll( $options );
	}


}