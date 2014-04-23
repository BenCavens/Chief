<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class ChiefTestSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Safety measure
		if(App::environment() == 'production')
		{
			exit('No seeding allowed on production!');
		}

		Eloquent::unguard();

        // Seed
		$this->call('ChiefPostsTableSeeder');
		$this->call('ChiefUsersTableSeeder');
		$this->call('ChiefCommentsTableSeeder');
		$this->call('ChiefTagsTableSeeder');

		// Fakeseeding
		// $this->call('ChiefFakerSeeder');
		
	}
}