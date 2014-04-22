<?php

class ChiefTagsTest extends TestCase {

	
	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testTagRepository()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$tagRepo = $chief->tag();

		$this->assertTrue( $tagRepo instanceof \Bencavens\Chief\Tags\TagRepositoryInterface );
		$this->assertTrue( $tagRepo instanceof \Bencavens\Chief\Core\ChiefRepositoryInterface );		
		$this->assertTrue( $tagRepo instanceof \Bencavens\Chief\Tags\TagRepository );
	}

	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testgetAllTags()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$tags = $chief->tag()->getAll();

		$this->assertTrue( $tags instanceof \Illuminate\Database\Eloquent\Collection );
		$this->assertTrue(count($tags) > 0);
		
		foreach($tags as $tag)
		{
			$this->assertTrue( $tag instanceof \Illuminate\Database\Eloquent\Model );
			$this->assertTrue( $tag instanceof \Bencavens\Chief\Tags\Tag );
		}
	}

	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testGetTagsFromPost()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$post = $chief->post()->getById(1);

		$tags = $post->tags()->get();

		$this->assertTrue( $tags instanceof \Illuminate\Database\Eloquent\Collection );

		$this->assertTrue(count($tags) == 0);
		foreach($tags as $tag)
		{
			$this->assertTrue( $tag instanceof \Illuminate\Database\Eloquent\Model );
			$this->assertTrue( $tag instanceof \Bencavens\Chief\Tags\Tag );
		}

	}

	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testGetExistingTagsFromPost()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$post = $chief->post()->getById(1);

		// Add a tag
		$post->tags()->attach(1);

		$tags = $post->tags()->get();
		
		$this->assertTrue( $tags instanceof \Illuminate\Database\Eloquent\Collection );
		$this->assertTrue( count($tags) == 1 );
		
		foreach($tags as $tag)
		{
			$this->assertTrue( $tag instanceof \Illuminate\Database\Eloquent\Model );
			$this->assertTrue( $tag instanceof \Bencavens\Chief\Tags\Tag );
		}

	}

}