<?php

class ChiefTagsTableSeeder extends Seeder {

    public function run()
    {
    	$tags = array(

            array(
               'id'     => 1,
               'name'   => 'social',
               'slug'   => 'social',
               'cat'    => 0
            ),
             array(
               'id'     => 2,
               'name'   => 'coding',
               'slug'   => 'coding',
               'cat'    => 0
            ),
            array(
               'id'     => 3,
               'name'   => 'hr',
               'slug'   => 'hr',
               'cat'    => 1
            ),
             array(
               'id'     => 4,
               'name'   => 'Mar Com',
               'slug'   => 'marcom',
               'cat'    => 1
            )

        );

         DB::table('chieftags')->insert($tags);

        //  $categories = array(

        //     array(
        //        'id'     => 1,
        //        'name'   => 'HR',
        //        'slug'   => 'hr'
        //     ),
        //      array(
        //        'id'     => 2,
        //        'name'   => 'IT & Web',
        //        'slug'   => 'it-Web'
        //     )

        // );

        //   // FAKER
        // $faker = Faker\Factory::create();

        // for($i = 0;$i<30;$i++)
        // {
        //   $name = $faker->unique()->word();
        //   $slug   = Str::slug($name);

        //    $categories[] = [

        //        'id' => null,
        //        'name' => $name,
        //        'slug' => $slug
        //     ];
        // }

         //DB::table('chiefcategories')->insert($categories);
    }

}