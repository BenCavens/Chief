<?php

class ChiefFakerSeeder extends Seeder {

    public function run()
    {
    	// FAKER
        $faker = Faker\Factory::create();

        // COMMENT -----------------------------------------------------------------
        $comments = [];

        for($i = 0;$i<40;$i++)
        {
            $comments[] = [

                'post_id'       => rand(0,40),
                'content'       => $faker->text(),
                'parent_id'     => array_rand(array(null,null,null,1,2,3)),
                'status'        => array_rand(array('pending','approved','denied')),
                'username'      => $faker->name,
                'email'         => $faker->email,
                'user_id'       => array_rand(array(null,null,1,2)),
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ];
        }

        // Uncomment the below to run the seeder
        DB::table('chiefcomments')->insert($comments);


        // POSTS -----------------------------------------------------------------
        $posts = [];

        for($i = 0;$i<100;$i++)
        {
            $posts[] = [

                'id'        => null,
                'title'     => $faker->word(),
                'slug'      => Str::slug($faker->unique()->word),
                'content'   => $faker->text(),
                'status'    => array_rand(array('draft','published','archived')),
                'parent_id' => array_rand(array(0,0,0,1,2)),
                'comment_count' => rand(0,50),
                'image_id'  => 0,
                'views'     => rand()*100,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'published_at'  => null

            ];
        }

        DB::table('chiefposts')->insert($posts);


        // TAGS and CATEGORIES --------------------------------------------
        $tags = [];

        for($i = 0;$i<30;$i++)
        {
          $name = $faker->unique()->word();
          $slug   = Str::slug($name);

           $tags[] = [

               'id' => null,
               'name' => $name,
               'slug' => $slug,
               'cat'  => array_rand(array(0,0,0,1))
            ];
        }

        DB::table('chieftags')->insert($tags);


        // USERS ----------------------------------------------------------
        $users = [];

        for($i = 0;$i<30;$i++)
        {
           $firstName = $faker->firstName;
           $lastName = $faker->lastName;
           $slug = Str::slug($firstName .''. $lastName);

            $users[] = [

               'email' => $faker->unique()->email,
                'password' => '$2y$10$zne.qUJEPDbt169kgrrCw.zCdVr1dyF8NWf6cQwjtkZPKDxLaLatK',
                'first_name' => $firstName,
                'last_name' => $lastName,
                'activated' => 1,
                'created_at' => '2013-09-11 13:50:03',
                'updated_at' => '2013-09-11 15:50:47',
                'avatar'    => '',
                'slug' => $slug,

            ];
        }

        DB::table('chiefusers')->insert($users);
    }

}