<?php

class ChiefSentryTest extends TestCase {

	
	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testChiefSentryFacade()
	{
		$logged = App::make('chief.sentry')->check();

		$this->assertTrue( is_bool($logged) );
	}


}