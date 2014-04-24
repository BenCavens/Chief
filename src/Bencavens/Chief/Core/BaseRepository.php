<?php namespace Bencavens\Chief\Core;

/**
 * -----------------------------------------------------------
 * Base Repository
 * -----------------------------------------------------------
 *
 * @version 0.2
 * @author 	Ben Cavens <cavensben@gmail.com>
 */

use Bencavens\Chief\Core\BaseModel;
use Exception;

abstract class BaseRepository{

	/**
	 * Model instance
	 *
	 * @var Model
	 */
	protected $model;

	/**
	 * Original Model instance
	 *
	 * @var Model
	 */
	protected $originalModel;

	/**
	 * Allowed Model Methods
	 *
	 * Whitelist of methods that can be invoked by the repository on the model
	 * These are methods that don't break the Open-closed principle of our repo philosophy. 
	 * Basically, it means that the returned result remains as excepted
	 *
	 * @var array
	 */
	protected $allowedModelMethods = array(

		'orderBy','limit'

	);

	/**
	 * Paginate our result set
	 *
	 * @var int
	 */
	protected $paginated = null;


	/**
	 * Get All records
	 *
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function getAll()
	{
		return $this->fetch();
	}

	/**
	 * Get record by ID
	 *
	 * @param 	int 	$id
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function getById( $id )
	{
		return $this->model->find( $id );
	}

	/**
	 * Create new post
	 *
	 * @param 	array 	$input
	 * @return 	Post
	 */
	public function create( array $input )
	{
		return $this->model->create( $input );
	}

	/**
	 * Update post
	 *
	 * @param 	int 	$resource_Id
	 * @param 	array 	$input
	 * @return 	resource
	 */
	public function update( $resource_id, array $input )
	{
		$resource = $this->model->find($resource_id);

		foreach($input as $column => $value)
		{
			$resource->$column = $value;
		}

		$resource->save();

		return $resource;
	}

	/**
	 * delete resource
	 *
	 * @param 	int 	$resource_id
	 * @return 	bool
	 */
	public function delete( $resource_id )
	{
		return $this->model->where('id',$resource_id)->delete();
	}

	/**
	 * Restore resource
	 *
	 * @param 	int 	$resource_id
	 * @return 	bool
	 */
	public function restore( $resource_id )
	{
		return $this->model->withTrashed()->where('id',$resource_id)->restore();
	}

	/**
	 * force delete resource
	 *
	 * @param 	int 	$resource_id
	 * @return 	bool
	 */
	public function forcedelete( $resource_id )
	{
		return $this->model->where('id',$resource_id)->forceDelete();
	}

	/**
	 * Base fetch for all repository returns
	 *
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function fetch()
	{
		$result = ($this->paginated and is_int($this->paginated)) ? $this->model->paginate($this->paginated) : $this->model->get();

		$this->reset();

		return $result;
	}

	/**
	 * Paginate the results
	 *
	 * @param 	int $limit
	 * @return 	Repository
	 */
	public function paginate( $paginated = 25 )
	{
		$this->paginated = $paginated;

		return $this;
	}

	/**
	 * Reset the Model to its original form
	 *
	 * @return void
	 */
	protected function reset()
	{
		$this->model = $this->originalModel;
	}

	/**
	 * Assign a model to our Repository
	 *
	 * This method must be called by the child class constructor at instantiating of the class
	 * @param 	Model 	$model
	 * @return 	void
	 */
	protected function setModel( BaseModel $model )
	{
		$this->model = $this->originalModel = $model;
	}

	/**
	 * Call to Eloquent model method
	 *
	 * @return Repository
	 */
	public function __call($method, $parameters)
	{
		if(in_array($method,$this->allowedModelMethods))
		{
			$this->model = call_user_func_array(array($this->model,$method), $parameters);
			return $this;
		}

		throw new Exception('Method ['.$method.'] does not exist on the model instance: ['.get_class($this->model).']');
	}

}