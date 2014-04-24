<?php namespace Bencavens\Chief\Core\Traits;

use Input;

trait Filterable{

	/**
	 * Enable filter 
	 *
	 * @param 	array 	$filters - pass custom set of filters (overrides default filterables)
	 * @return  Repo
	 */
	public function filter( array $filterables = null )
	{
		if(!is_null($filterables)) $this->filterables = $filterables;
				
		$this->listenToFilterPayload();

		return $this;
	}

	/**
	 * listener for query filters
	 *
	 * The input is scanned for a viable filter payload. 
	 * If so, these filters are taken into account for the constructed query
	 *
	 * FilterBy 	The Repository can contain FilterBy... methods by which it can deliver a specific querybuild to the model
	 * 				These methods should not return anything but instead chain their custom query to the model property.
	 * Text search	By default the filter will assume a tablefield is searched upon
	 * 				A non-strict text search is applied
	 * 
	 * @return 	void
	 */
	protected function listenToFilterPayload()
	{
		foreach($this->filterables as $filter)
		{
			if( false != ($value = Input::get($filter)) )
			{
				if(method_exists($this,'filterBy'.ucfirst($filter)))
				{
					call_user_func_array(array($this,'filterBy'.ucfirst($filter)),array($value));
				}

				else
				{
					$this->model = $this->model->where($filter,'LIKE','%'.$value.'%');
				}
			}
		}

	}

}