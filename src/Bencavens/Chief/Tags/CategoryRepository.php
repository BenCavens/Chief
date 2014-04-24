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
	 * @return  Illuminate\Database\Eloquent\Collection
	 *
	 */
	public function fetch()
	{
		$this->model = $this->model->where('cat',1);
		
		return parent::fetch();
	}

}