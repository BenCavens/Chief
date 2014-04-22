<?php namespace Bencavens\Chief\Tags;

use Bencavens\Chief\Core\BaseRepository;
use Bencavens\Chief\Core\ChiefRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface,ChiefRepositoryInterface{

	public function __construct( Category $model )
	{
		$this->model = $model;
	}

	/**
	 * Fetch
	 *
	 * Filter on categories
	 * 
	 * @param 	array 	$options
	 * @param 	int  	$paginated 
	 * @return  Illuminate\Database\Eloquent\Collection
	 *
	 */
	public function fetch( array $options = array(), $paginated = null )
	{
		// Defaults
		$options = array('whereCat' => 1) + $options;

		return parent::fetch( $options, $paginated );
	}

}