<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class ChiefSeeder extends Seeder {

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

		// Setup the default admin account
        $users =  array(
              
              array(
                'email' 		=> 'admin@admin.com',
                'password' 		=> Hash::make('chief'),
                'first_name' 	=> 'Admin',
                'last_name' 	=> 'Chief',
                'activated' 	=> 1,
                'created_at' 	=> date('Y-m-d H:i:s'),
                'updated_at' 	=> date('Y-m-d H:i:s'),
                'avatar'    	=> '',
                'slug' 			=> 'admin',
            )
        );

        // Uncomment the below to run the seeder
        DB::table('chiefusers')->insert($users);
		
	}
}