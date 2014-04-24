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
	 * @return  Illuminate\Database\Eloquent\Collection
	 *
	 */
	public function fetch()
	{
		$this->model = $this->model->where('cat',0);
		
		return parent::fetch();
	}
	

}