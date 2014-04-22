<?php

class ChiefAuthorTest extends TestCase {

	
	/**
	 * Call post Model from PostRepository
	 *
	 * @return void
	 */
	public function testPostGetAuthors()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$postRepo = $chief->post();

		$post = $postRepo->getById(1);

		$authors = $post->authors()->get();

		$this->assertTrue( $authors instanceof \Illuminate\Database\Eloquent\Collection );

	}

	/**
	 * Call post Model from PostRepository
	 *
	 * @return void
	 */
	public function testPostGetAuthor()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$postRepo = $chief->post();

		$post = $postRepo->getById(1);
		
		$author = $post->authors()->first();

		$this->assertTrue( $author instanceof \Bencavens\Chief\Users\User );

		// Order info
		$this->assertNotNull( $author->pivot->order );
	}

	/**
	 * Call post Model from PostRepository
	 *
	 * @return void
	 */
	public function testAuthorsCorrectOrder()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$postRepo = $chief->post();

		$post = $postRepo->getById(2);
		
		$authors = $post->authors()->get();

		$order = 0;

		foreach($authors as $author)
		{
			$this->assertGreaterThanOrEqual( $order, $author->pivot->order);
			$order = $author->pivot->order;
		}

	}


}