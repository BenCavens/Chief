<?php

class ChiefCustomRepositoryTest extends TestCase {

	
	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testGetCustomRepository()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$articleRepo = $chief->article();

		$this->assertTrue( $articleRepo instanceof \Bencavens\Chief\Tests\ArticleRepository );
		$this->assertTrue( $articleRepo instanceof \Bencavens\Chief\Core\ChiefRepositoryInterface);
	}	

	/**
	 * Reach Chief PostRepository
	 *
	 * @expectedException Exception
	 */
	public function testGetNonExistingCustomRepository()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$chief->fake();		
	}


	

}