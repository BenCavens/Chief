<?php

class ChiefPostVersionTest extends TestCase {

	
	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testGetLatestVersionByDefault()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		// Add version for post 1
		$postVersion = $chief->post()->create(array(

			'title'			=> 'version first post',
			'slug'			=> 'version-first-post',
			'content' 		=> 'xxx',
			'parent_id' 	=> 1,
			'created_at'	=> date('Y-m-d H:i:s',time()+100),
			'updated_at'	=> date('Y-m-d H:i:s',time()+100)

		));

		$post = $chief->post()->find(1);

		$versions = $chief->post()->getVersionsById( 1 );

		$post2 = $versions->first();

		$this->assertTrue($post->id == $post2->parent_id);
		$this->assertTrue($post->created_at < $post2->created_at);
	}

	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testGetAllVersions()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$posts = $chief->post()->getVersionsById( 1 );

		$this->assertTrue( $posts instanceof \Illuminate\Database\Eloquent\Collection );
	
		
	}

	/**
	 * Reach Chief Posts by default no versions!
	 *
	 * @return void
	 */
	public function testGetNoVersionsByDefault()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$posts = $chief->post()->getAll();

		foreach($posts as $post)
		{
			$this->assertTrue($post->parent_id == 0);
		}
		
	}


}