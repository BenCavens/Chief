<?php namespace Bencavens\Chief\Posts;

use Bencavens\Chief\Core\BaseRepository;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface{

	public function __construct( Comment $model )
	{
		$this->setModel( $model );
	}

	/**
	 * Fetch
	 *
	 * @return  Illuminate\Database\Eloquent\Collection
	 */
	public function fetch()
	{
		$this->model = $this->model->with('post','author');
		
		return parent::fetch();
	}

	/**
	 * Get all Approved articles
	 *
	 * @return  Collection
	 */
	public function getAllApproved()
	{
		return $this->getByStatus('approved');
	}

	/**
	 * Get all Denied articles
	 *
	 * @return  Collection
	 */
	public function getAllDenied()
	{
		return $this->getByStatus('denied');
	}

	/**
	 * Get all Pending articles
	 *
	 * @return  Collection
	 */
	public function getAllPending()
	{
		return $this->getByStatus('pending');
	}

	/**
	 * Get all (approved) comments by post
	 *
	 * @param 	int 	$post_id
	 * @param 	string 	$status
	 * @return  Collection
	 */
	public function getByPost( $post_id, $status = 'approved')
	{
		$this->model = $this->model->where('post_id',$post_id);

		return $this->getByStatus($status);
	}

	/**
	 * Get all comments by post
	 *
	 * @param 	int 	$post_id
	 * @return  Collection
	 */
	public function getAllByPost( $post_id )
	{
		$this->model = $this->model->where('post_id',$post_id);

		return $this->fetch();
	}

	/**
	 * Get comments by status
	 *
	 * @param 	string 	$status
	 * @return  Collection
	 */
	protected function getByStatus($status)
	{
		$this->model = $this->model->where('status',$status);

		return $this->fetch();
	}


}