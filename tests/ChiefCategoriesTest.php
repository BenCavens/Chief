<?php

class ChiefCategoriesTest extends TestCase {

	
	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testCategoryRepository()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$categoryRepo = $chief->category();

		$this->assertTrue( $categoryRepo instanceof \Bencavens\Chief\Tags\CategoryRepositoryInterface );
		$this->assertTrue( $categoryRepo instanceof \Bencavens\Chief\Core\ChiefRepositoryInterface );		
		$this->assertTrue( $categoryRepo instanceof \Bencavens\Chief\Tags\CategoryRepository );
	}

	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testgetAllCategories()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$categories = $chief->category()->getAll();

		$this->assertTrue( $categories instanceof \Illuminate\Database\Eloquent\Collection );
		$this->assertTrue(count($categories) > 0);
		
		foreach($categories as $category)
		{
			$this->assertTrue( $category instanceof \Illuminate\Database\Eloquent\Model );
			$this->assertTrue( $category instanceof \Bencavens\Chief\Tags\Category );
		}
	}

	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testGetCategoriesFromPost()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$post = $chief->post()->getById(1);

		$categories = $post->categories()->get();

		$this->assertTrue( $categories instanceof \Illuminate\Database\Eloquent\Collection );

		$this->assertTrue(count($categories) == 0);
		foreach($categories as $category)
		{
			$this->assertTrue( $category instanceof \Illuminate\Database\Eloquent\Model );
			$this->assertTrue( $category instanceof \Bencavens\Chief\Tags\Category );
		}

	}

	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testGetExistingCategoriesFromPost()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$post = $chief->post()->getById(1);

		// Add a category
		$post->categories()->attach(3);

		$categories = $post->categories()->get();
		
		$this->assertTrue( $categories instanceof \Illuminate\Database\Eloquent\Collection );
		$this->assertTrue( count($categories) == 1 );
		
		foreach($categories as $category)
		{
			$this->assertTrue( $category instanceof \Illuminate\Database\Eloquent\Model );
			$this->assertTrue( $category instanceof \Bencavens\Chief\Tags\Category );
		}

	}

}