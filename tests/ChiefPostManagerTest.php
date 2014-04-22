<?php

class ChiefPostManagerTest extends TestCase {

	
	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testPostCreate()
	{
		$postManager = App::make('Bencavens\Chief\Posts\PostManager');

		$input = array(

			'title' 	=> 'third blogpost',
			'slug'		=> 'third-post',
			'content'	=> 'inhoud van het artikel'

		);

		$post = $postManager->create( $input );

		$this->assertTrue( $post instanceof \Illuminate\Database\Eloquent\Model );
		$this->assertTrue( $post instanceof \Bencavens\Chief\Posts\Post );

		$postDB = $postManager->repo->getById($post->id);

		$this->assertTrue( $post->slug == $postDB->slug );

	
	}

	public function testPostCreateTitleRequired()
	{
		// For testing purposes we need to reset the errorManager cause the error messages 
		$errorManager = App::make('Bencavens\Chief\Services\ErrorManager');
		$errorManager->forget();

		$postManager = App::make('Bencavens\Chief\Posts\PostManager');

		$input = array( 'slug' => 'xxx' );

		$this->assertFalse( $postManager->validateInput( $input ) );
	}

	public function testPostCreateSlugRequired()
	{
		// For testing purposes we need to reset the errorManager cause the error messages 
		$errorManager = App::make('Bencavens\Chief\Services\ErrorManager');
		$errorManager->forget();

		$postManager = App::make('Bencavens\Chief\Posts\PostManager');

		$input = array( 'title' => 'xxx' );

		$this->assertFalse( $postManager->validateInput( $input ) );
	}

	public function testPostCreateAllRequired()
	{
		// For testing purposes we need to reset the errorManager cause the error messages 
		$errorManager = App::make('Bencavens\Chief\Services\ErrorManager');
		$errorManager->forget();

		$postManager = App::make('Bencavens\Chief\Posts\PostManager');

		$input = array( 'title' => 'xxx','slug' => 'xxx' );

		$this->assertTrue( $postManager->validateInput( $input ) );
	}

	public function testPostSanitizeSlug()
	{
		// For testing purposes we need to reset the errorManager cause the error messages 
		$errorManager = App::make('Bencavens\Chief\Services\ErrorManager');
		$errorManager->forget();

		$postManager = App::make('Bencavens\Chief\Posts\PostManager');

		$input = array( 'title' => 'posttitle','slug' => 'xxx' );
		$this->assertTrue( $postManager->sanitizeInput( $input ) == $input );

	}

	public function testPostSanitizeAddSlug()
	{
		// For testing purposes we need to reset the errorManager cause the error messages 
		$errorManager = App::make('Bencavens\Chief\Services\ErrorManager');
		$errorManager->forget();

		$postManager = App::make('Bencavens\Chief\Posts\PostManager');

		$input = array( 'title' => 'posttitle' );
		$this->assertTrue( $postManager->sanitizeInput( $input ) == array('title' => 'posttitle','slug' => 'posttitle') );

	}

	public function testPostSanitizeFilterSlug()
	{
		// For testing purposes we need to reset the errorManager cause the error messages 
		$errorManager = App::make('Bencavens\Chief\Services\ErrorManager');
		$errorManager->forget();

		$postManager = App::make('Bencavens\Chief\Posts\PostManager');

		$input = array( 'title' => 'posttitleé#' );
		
		$this->assertTrue( $postManager->sanitizeInput( $input ) == array('title' => 'posttitleé#','slug' => 'posttitlee') );
	}

	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testPostUpdate()
	{
		$postManager = App::make('Bencavens\Chief\Posts\PostManager');

		$postDB = $postManager->repo->getById(1);

		$input = array(

			'title' 	=> 'new title',
			'content'	=> 'xxxxx'

		);

		$post = $postManager->update($postDB->id, $input );

		$this->assertTrue( $post instanceof \Illuminate\Database\Eloquent\Model );
		$this->assertTrue( $post instanceof \Bencavens\Chief\Posts\Post );

		$this->assertTrue( $post->slug == $postDB->slug );
		$this->assertFalse( $post->title == $postDB->title );
		$this->assertTrue( $post->content == 'xxxxx');

	
	}

	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testPostUpdateValidate()
	{
			
	}

	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testPostDelete()
	{
		$postManager = App::make('Bencavens\Chief\Posts\PostManager');

		$deleted = $postManager->delete( 1 );

		$post = $postManager->repo->getById(1);

		$this->assertNull( $post );
		

	}



}