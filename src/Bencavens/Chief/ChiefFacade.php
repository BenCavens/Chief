<?php namespace Bencavens\Chief;

use Illuminate\Support\Facades\Facade;

class ChiefFacade extends Facade{
	
	/**
	 * Retrieve the registered name of our ChiefInstance as binding in the Container
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'Bencavens\Chief\Chief';
	}

}