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

        // $roles = array()

        // 	array(
        // 		'name'	=> 'guest',
        // 		'permissions' 	=> array(
        // 			'post-edit'		=> 0,
        // 			'post-create'	=> 0,
        // 			'post-delete'	=> 0,
        // 			'comment-edit'	=> 0,
        // 			'comment-delete'=> 0,
        // 			'comments'		=> 0,
        // 			'users'			=> 0,
        // 			'admin'			=> 0
        // 		),
        // 		'created_at' 	=> date('Y-m-d H:i:s'),
        //         'updated_at' 	=> date('Y-m-d H:i:s'),
        // 	),
        // 	array(
        // 		'name'		=> 'co-writer',
        // 		'permissions' 	=> array(
        // 			'post-edit'		=> 0,
        // 			'post-create'	=> 0,
        // 			'post-delete'	=> 0,
        // 			'comment-edit'	=> 0,
        // 			'comment-delete'=> 0,
        // 			'comments'		=> 0,
        // 			'users'			=> 0,
        // 			'admin'			=> 0
        // 		),
        // 		'created_at' 	=> date('Y-m-d H:i:s'),
        //         'updated_at' 	=> date('Y-m-d H:i:s'),
        // 	),
        // 	array(
        // 		'name'		=> 'writer',
        // 		'permissions' 	=> array(
        // 			'post-edit'		=> 0,
        // 			'post-create'	=> 1,
        // 			'post-delete'	=> 0,
        // 			'comment-edit'	=> 0,
        // 			'comment-delete'=> 0,
        // 			'comments'		=> 0,
        // 			'users'			=> 0,
        // 			'admin'			=> 0
        // 		),
        // 		'created_at' 	=> date('Y-m-d H:i:s'),
        //         'updated_at' 	=> date('Y-m-d H:i:s'),
        // 	),
        // 	array(
        // 		'name'		=> 'chief',
        // 		'permissions' 	=> array(
        // 			'post-edit'		=> 1,
        // 			'post-create'	=> 1,
        // 			'post-delete'	=> 0,
        // 			'comment-edit'	=> 0,
        // 			'comment-delete'=> 0,
        // 			'comments'		=> 0,
        // 			'users'			=> 0,
        // 			'admin'			=> 0
        // 		),
        // 		'created_at' 	=> date('Y-m-d H:i:s'),
        //         'updated_at' 	=> date('Y-m-d H:i:s'),
        // 	),



        // );
		
	}
}