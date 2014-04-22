<?php

class ChiefUserTest extends TestCase {

	
	/**
	 * Reach Chief UserRepository
	 *
	 * @return void
	 */
	public function testUserRepository()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$userRepo = $chief->user();

		$this->assertTrue( $userRepo instanceof \Bencavens\Chief\Users\UserRepositoryInterface );
		$this->assertTrue( $userRepo instanceof \Bencavens\Chief\Users\UserRepository );
	}

	/**
	 * Custom extend UserRepository
	 *
	 * @return void
	 */
	public function testUserRepositoryExtend()
	{
		include_once 'assets/Customrepositories.php';	
		include_once 'assets/Custommodels.php';	

		// UserRepository
		$this->app->bind(
			'Bencavens\Chief\Users\UserRepositoryInterface',
			'Bencavens\Chief\Tests\CustomUserRepository'
		);

		$chief = App::make('Bencavens\Chief\Chief');

		$userRepo = $chief->user();

		$this->assertTrue( $userRepo instanceof \Bencavens\Chief\Users\UserRepositoryInterface );
		$this->assertTrue( $userRepo instanceof \Bencavens\Chief\Tests\CustomUserRepository );
	}

	/**
	 * Call user Model from UserRepository
	 *
	 * @return void
	 */
	public function testUserRepositoryModel()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$userRepo = $chief->user();

		$user = $userRepo->find(1);

		$this->assertTrue( $user instanceof \Illuminate\Database\Eloquent\Model );
	}

	/**
	 * Call user Model from UserRepository
	 *
	 * @return void
	 */
	public function testUserRepositoryModelExtend()
	{
		include_once 'assets/Customrepositories.php';	
		include_once 'assets/Custommodels.php';		

		// UserRepository
		$this->app->bind(
			'Bencavens\Chief\Users\UserRepositoryInterface',
			'Bencavens\Chief\Tests\CustomUserRepository'
		);

		$chief = App::make('Bencavens\Chief\Chief');

		$userRepo = $chief->user();

		$user = $userRepo->find(1);

		$this->assertTrue( $user instanceof \Illuminate\Database\Eloquent\Model );
		$this->assertTrue( $user instanceof \Bencavens\Chief\Tests\CustomUserModel );
	
	}

	/**
	 * Call user Model from UserRepository
	 *
	 * @return void
	 */
	public function testUserRepositoryGetAll()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$userRepo = $chief->user();

		$users = $userRepo->getAll();
		
		$this->assertTrue( $users instanceof \Illuminate\Database\Eloquent\Collection );
	}

	/**
	 * Call user Model from UserRepository
	 *
	 * @return void
	 */
	public function testUserRepositoryCollection()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		$userRepo = $chief->user();

		$users = $userRepo->getAll();
		
		// Get first item slug
		$first = $users[0];
		$this->assertTrue(($first->email == 'cavensben@gmail.com'));

		// Convert to Array
		$users = $users->toArray();
		$this->assertTrue( is_array($users));
	}

	/**
	 * Call user Model from UserRepository
	 *
	 * @return void
	 */
	public function testUserRepositoryGetEmail()
	{
		$chief = App::make('Bencavens\Chief\Chief');
		$userRepo = $chief->user();

		$user = $userRepo->getByEmail('cavensben@gmail.com');
		
		$this->assertTrue( $user instanceof \Illuminate\Database\Eloquent\Model );
		
		$this->assertTrue(($user->email == 'cavensben@gmail.com'));

	}

	/**
	 * Call user Model from UserRepository
	 *
	 * @return void
	 */
	public function testUserModelSave()
	{
		$chief = App::make('Bencavens\Chief\Chief');
		$userRepo = $chief->user();

		$user = $userRepo->getByEmail('cavensben@gmail.com');
		
		$user->email = 'cavensben@hotmail.com';
		$user->save();

		$this->assertTrue( $user instanceof \Illuminate\Database\Eloquent\Model );
		
		$this->assertTrue(($user->email == 'cavensben@hotmail.com'));
		
		// Now this should return NULL
		$user = $userRepo->getByEmail('cavensben@gmail.com');
		$this->assertNull($user);
	}

	/**
	 * Create Group
	 *
	 * @return void
	 */
	public function testCreateGroup()
	{
		$group = \Bencavens\Chief\Users\Group::where('name','admin')->first();
		$this->assertNull($group);

		$group = new \Bencavens\Chief\Users\Group;
		$group->name = 'admin';
		$group->save();

		$groupCheck = \Bencavens\Chief\Users\Group::where('name','admin')->first();
		$this->assertTrue($groupCheck instanceof \Bencavens\Chief\Users\Group);

	}

	/**
	 * Add user to group
	 *
	 * @return void
	 */
	public function testAddUserToGroup()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		// Create group
		$group = new \Bencavens\Chief\Users\Group;
		$group->name = 'admin';
		$group->save();

		$user = $chief->user()->getById(1);

		$user->groups()->attach($group->id);

		$groupCheck = $user->groups()->first();
		$this->assertTrue($groupCheck instanceof \Bencavens\Chief\Users\Group);
		$this->assertTrue($groupCheck->name == 'admin' );

	}

	/**
	 * Remove group from user
	 *
	 * @return void
	 */
	public function testRemoveGroupFromUser()
	{
		$chief = App::make('Bencavens\Chief\Chief');

		// Create group
		$group = new \Bencavens\Chief\Users\Group;
		$group->name = 'admin';
		$group->save();

		$user = $chief->user()->getById(1);

		$user->groups()->attach($group->id);

		$groupCheck = $user->groups()->first();
		$this->assertTrue($groupCheck instanceof \Bencavens\Chief\Users\Group);
		$this->assertTrue($groupCheck->name == 'admin' );

		// NOW DETACH
		$user->groups()->detach($groupCheck->id);

		$groupCheck2 = $user->groups()->first();
		$this->assertNull($groupCheck2);
	
	}



}