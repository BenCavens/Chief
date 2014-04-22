<?php

class ChiefCommentsTableSeeder extends Seeder {

    public function run()
    {
    	$comments = array(
            array(
                'post_id'       => 1,
                'content'       => 'this is a first comment',
                'parent_id'     => null,
                'status'        => 'approved',
                'username'      => 'Ben Cavens',
                'email'         => 'cavensben@gmail.com',
                'user_id'       => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ),
             array(
                'post_id'       => 1,
                'content'       => 'this is a second comment',
                'parent_id'     => null,
                'status'        => 'pending',
                'username'      => 'Sam Cavens',
                'email'         => 'cavenssam@outlook.com',
                'user_id'       => null,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            )
        );

        // Uncomment the below to run the seeder
        DB::table('chiefcomments')->insert($comments);
    }

}