<?php

class ChiefPostPublishTest extends TestCase {

	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testOnlyPublishedPostsMustHavePublishDate()
	{
		// $chief = App::make('Bencavens\Chief\Chief');

		// $publishedPosts = $chief->post()->getAllPublished();

		// foreach($publishedPosts as $post)
		// {
		// 	$this->assertNotNull($post->published_at);
		// }
	}

	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testGetSinglePostEvenIfPublishDateInFuture()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$post = $chief->post()->getBySlug('first-post');
		$this->assertTrue( $post instanceof \Illuminate\Database\Eloquent\Model );

		// Draft
		$post = $chief->post()->getBySlug('second-post');
		$this->assertNull( $post );

		
	}

	/**
	 * Reach Chief PostRepository
	 *
	 * Publish date has no effect on publishing the article. Only the status label does
	 * @return void
	 */
	public function testCanPublishBeforePublishDate()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$input = array(

			'title' 	=> 'fourth blogpost',
			'slug'		=> 'fourth-post',
			'content'	=> 'inhoud van het artikel',
			'published_at'	=> date('Y-m-d H:i:s',time()+2000),
			'status'	=> 'published'

		);

		$post = $chief->postManager()->create( $input );

		$post = $chief->post()->getBySlug('fourth-post');
		$this->assertTrue( $post instanceof \Illuminate\Database\Eloquent\Model );

		$input = array(

			'title' 	=> 'fifth blogpost',
			'slug'		=> 'fifth-post',
			'content'	=> 'inhoud van het artikel',
			'published_at'	=> date('Y-m-d H:i:s',time()-2000),
			'status'	=> 'published'

		);

		$post = $chief->postManager()->create( $input );

		$post = $chief->post()->getBySlug('fifth-post');
		$this->assertTrue( $post instanceof \Illuminate\Database\Eloquent\Model );
	}

	



}