<?php namespace Bencavens\Chief\Tags;

use Bencavens\Chief\Core\BaseRepository;
use Bencavens\Chief\Core\ChiefRepositoryInterface;

class TagRepository extends BaseRepository implements TagRepositoryInterface,ChiefRepositoryInterface{

	public function __construct( Tag $model )
	{
		$this->model = $model;
	}

	/**
	 * Fetch
	 *
	 * Filter on tags
	 * 
	 * @param 	array 	$options
	 * @param 	int  	$paginated 
	 * @return  Illuminate\Database\Eloquent\Collection
	 *
	 */
	public function fetch( array $options = array(), $paginated = null )
	{
		// Defaults
		$options = array('whereCat' => 0) + $options;

		return parent::fetch( $options, $paginated );
	}

}