<?php namespace Bencavens\Chief\Services;

use Illuminate\Support\Facades\Facade;

class ChiefSentryFacade extends Facade{
	
	protected static function getFacadeAccessor()
	{
		return 'chief.sentry';
	}

}