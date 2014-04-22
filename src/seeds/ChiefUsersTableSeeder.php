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
            ),
             array(
                'email' => 'tielemansthomas@gmail.com',
                'password' => '$2y$10$Qm5JAlG7NdSw4893fqe03.idp/sKQfz69b/qS7nrEX0kun8F.4gPG',
                'first_name' => 'Thomas',
                'last_name' => 'Tielemans',
                'activated' => 1,
                'created_at' => '2013-09-12 11:32:56',
                'updated_at' => '2013-09-12 11:45:24',
                'avatar'    => '',
                'slug' => 'thomastielemans'
            )
        );

       

        // Uncomment the below to run the seeder
        DB::table('chiefusers')->insert($users);
    }

}