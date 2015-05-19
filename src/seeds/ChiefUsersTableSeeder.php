<?php

class ChiefUsersTableSeeder extends Seeder {

    public function run()
    {
    	$users =  array(
              array(
                'email' => 'cavensben@gmail.com',
                'password' => '$2y$10$zne.qUJEPDbt169kgrrCw.zCdVr1dyF8NWf6cQwjtkZPKDxLaLatK',
                'first_name' => 'Ben',
                'last_name' => 'Cavens',
                'activated' => 1,
                'created_at' => '2013-09-11 13:50:03',
                'updated_at' => '2013-09-11 15:50:47',
                'avatar'    => '',
                'slug' => 'bencavens',
            )
        );

       

        // Uncomment the below to run the seeder
        DB::table('chiefusers')->insert($users);
    }

}
