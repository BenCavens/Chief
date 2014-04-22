<?php

class ChiefPostsTableSeeder extends Seeder {

    public function run()
    {
    	$posts = array(
            array(
                'id'        => 1,
                'title'     => 'First post',
                'subtitle'  => 'subtitle',
                'slug'      => 'first-post',
                'content'   => 'xxx',
                'status'    => 'published',
                'parent_id' => 0,
                'comment_count' => 0,
                'image_id'  => 1,
                'views'     => 0,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'published_at'  => null
            ),
             array(
                'id'        => '2',
                'title'     => 'Second post',
                'subtitle'  => 'subtitle',
                'slug'      => 'second-post',
                'content'   => '<h1>dit is de titel</h1><p>lets talk about stuff</p>',
                'status'    => 'draft',
                'parent_id' => 0,
                'comment_count' => 5201,
                'image_id'  => 0,
                'views'     => 20,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'published_at'  => null
            ),
             array(
                'id'        => '3',
                'title'     => 'version - second post',
                'subtitle'  => 'subtitle',
                'slug'      => 'version-second-post',
                'content'   => '<h1>dit is de vorige versie titel</h1><p>lets talk about stuff</p>',
                'status'    => 'draft',
                'parent_id' => 2,
                'comment_count' => 41,
                'image_id'  => 0,
                'views'     => 48485,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'published_at'  => null
            )
        );

        

        // Uncomment the below to run the seeder
        DB::table('chiefposts')->insert($posts);



        $posttypes = array(

            array(
                'name'              => 'article',
                'slug'              => 'article',
                'allow_comments'    => 1
            ),
            array(
                'name'              => 'event',
                'slug'              => 'event',
                'allow_comments'    => 0
            )

        );

         DB::table('chiefposttypes')->insert($posttypes);


        $authors = array(

            array(
                'post_id'      => 1,
                'user_id'      => 1,
                'order'        => 1
            ),
           array(
                'post_id'      => 2,
                'user_id'      => 1,
                'order'        => 2
            ),
           array(
                'post_id'      => 2,
                'user_id'      => 2,
                'order'        => 1
            )

        );

         DB::table('chiefauthors')->insert($authors);
    }

}