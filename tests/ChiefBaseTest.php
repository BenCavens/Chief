<?php

class ChiefBaseTest extends TestCase {

	/**
	 * Test init
	 *
	 * @return void
	 */
	public function testInitiateTesting()
	{
		$this->assertTrue(true);
	}

	/**
	 * Reach Chief object
	 *
	 * @return void
	 */
	public function testChiefObject()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$this->assertTrue( is_object( $chief ));
	}

	/**
	 * Reach Chief object
	 *
	 * @return void
	 */
	public function testChiefFacade()
	{
		$postRepo = Bencavens\Chief\ChiefFacade::post();

		$this->assertTrue( $postRepo instanceof \Bencavens\Chief\Posts\PostRepositoryInterface );
		$this->assertTrue( $postRepo instanceof \Bencavens\Chief\Core\ChiefRepositoryInterface );
	}

}