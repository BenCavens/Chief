<?php namespace Bencavens\Chief\Core\Traits;

use Input;

trait Sortable{

	/**
	 * Query key to listen to for sorting
	 *
	 * @var string
	 */
	public $sortableKey = 'sort';

	/**
	 * Enable sort 
	 *
	 * @param 	array 	$sortables - pass custom set of sortables (overrides default sortables)
	 * @return  Repo
	 */
	public function sort( array $sortables = null )
	{
		if(!is_null($sortables)) $this->sortables = $sortables;
				
		$this->listenToSortPayload();

		return $this;
	}

	/**
	 * listener for query sort values
	 *
	 * If the url query contains the sort key, the belonging values are taken into account for sorting.
	 * multiple values are separated by a comma. 
	 * Default is Ascending sort, a minus before a value depicts a descending direction
	 *
	 * @return 	void
	 */
	protected function listenToSortPayload()
	{
		if(empty($this->sortables)) return;

		// Sorting
		if(false != ($sorters = Input::get($this->sortableKey)) )
		{
			$sorters = explode(',',$sorters);

			foreach($sorters as $sorter)
			{
				$order = 'ASC';
					
				if(0 === strpos($sorter,'-'))
				{
					$order = 'DESC';
					$sorter = substr($sorter,1);
				}

				if(false !== ($key = array_search($sorter,$this->sortables)))
				{
					$sortable = $this->sortables[$key];

					if(method_exists($this,'sortBy'.ucfirst($sortable)))
					{
						call_user_func_array(array($this,'sortBy'.ucfirst($sortable)),array($sorter));
					}

					else
					{
						$this->model = $this->model->orderBy($sortable,$order);
					}
					
				}
			}
		}
	}
}