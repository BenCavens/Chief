<?php namespace Bencavens\Chief\Core;

abstract class BaseRepository{

	/**
	 * Base fetch for array / non-unique returns
	 *
	 * Override this method if you want all queries to contain certain SQL
	 * 
	 * @param 	array 	$options
	 * @param 	int  	$paginated 
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function fetch( array $options = array(), $paginated = null )
	{
		$model = $this->extend( $options );

		return ($paginated and is_int($paginated)) ? $model->paginate($paginated) : $model->get();
	}

	/**
	 * Get All records
	 *
	 * @param 	array 	$options
	 * @param 	int  	$paginated 
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function getAll( array $options = array(), $paginated = null )
	{
		return $this->fetch( $options, $paginated );
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
	 * Base Model extended Setup
	 *
	 * Takes our options and deliver it to our model
	 * @param 	array 	$options
	 * @return 	Model
	 */
	protected function extend( array $options = array() )
	{
		$model = $this->model;
		
		foreach($options as $method => $parameters)
		{
			$model = call_user_func_array(array($model,$method), (array)$parameters);
		}

		return $model;
	}

	/**
	 * Expand options to a uniform array
	 *
	 * @param 	array 	$options
	 * @return 	array 	$options
	 */
	// public function expandOptions( array $options = array() )
	// {
	// 	$expandedOptions = array();

	// 	/**
	// 	 * Default way of delivering options is: array('where' => array('status',1))
	// 	 * This way the user can override default options
	// 	 *
	// 	 * Alternative for providing additional options: array('where' => array( array('status',1) , array('parent_id', 0) ))
	// 	 */
	// 	foreach($options as $method => $option)
	// 	{
	// 		if(!is_array($option))
	// 		{
	// 			$expandedOptions[$method][] = array($option); 
	// 		}

	// 		elseif(!is_array(reset($option)))
	// 		{
	// 			$expandedOptions[$method][] = $option;
	// 		}

	// 		else
	// 		{
	// 			foreach($option as $opt)
	// 			{
	// 				$expandedOptions[$method][] = $opt;
	// 			}
	// 		}
			
	// 	}

	// 	return $expandedOptions;
	// }

	/**
	 * Call to Eloquent model method
	 *
	 * @return Eloquent
	 */
	public function __call($method, $parameters)
	{
		if(!is_null($this->model))
		{
			return call_user_func_array(array($this->model,$method), $parameters);
		}

		throw new Exception('Method ['.$method.'] does not exist on the model instance: ['.get_class($this->model).']');
	}

}