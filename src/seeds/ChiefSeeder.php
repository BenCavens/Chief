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

	    $this->insertDefaultUsers();

        $this->insertGroups();

        $this->addGroupToAdmin();

        $this->insertExamplePost();
        		
	}

    /**
     * Insert Default user admin
     *
     * @return void
     */
    public function insertDefaultUsers()
    {
        // Setup the default admin account
        $users =  array(
              
              array(
                'email'         => 'admin@admin.com',
                'password'      => Hash::make('chief'),
                'first_name'    => 'Admin',
                'last_name'     => 'Chief',
                'activated'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'avatar'        => '',
                'slug'          => 'admin',
            )
        );

        // Uncomment the below to run the seeder
        DB::table('chiefusers')->insert($users);
    }

    /**
     * Create the chief groups - user roles
     *
     * @return void
     */
    public function insertGroups()
    {
        $currentDatetime = date('Y-m-d H:i:s');

        // Groups
        $groups = array(

            array(
                'name'  => 'guest',
                'permissions'   => array(
                    'post-edit'     => 0,
                    'post-create'   => 0,
                    'post-delete'   => 0,
                    'comment-edit'  => 0,
                    'comment-delete'=> 0,
                    'comments'      => 0,
                    'users'         => 0,
                    'admin'         => 0
                ),
                'created_at'    => $currentDatetime,
                'updated_at'    => $currentDatetime,
            ),
            array(
                'name'      => 'writer',
                'permissions'   => array(
                    'post-edit'     => 1,
                    'post-create'   => 1,
                    'post-delete'   => 0,
                    'comment-edit'  => 1,
                    'comment-delete'=> 1,
                    'comments'      => 1,
                    'users'         => 0,
                    'admin'         => 0
                ),
                'created_at'    => $currentDatetime,
                'updated_at'    => $currentDatetime,
            ),
            array(
                'name'      => 'chief',
                'permissions'   => array(
                    'post-edit'     => 1,
                    'post-create'   => 1,
                    'post-delete'   => 1,
                    'comment-edit'  => 1,
                    'comment-delete'=> 1,
                    'comments'      => 1,
                    'users'         => 1,
                    'admin'         => 0
                ),
                'created_at'    => $currentDatetime,
                'updated_at'    => $currentDatetime,
            ),
            array(
                'name'      => 'admin',
                'permissions'   => array(
                    'post-edit'     => 1,
                    'post-create'   => 1,
                    'post-delete'   => 1,
                    'comment-edit'  => 1,
                    'comment-delete'=> 1,
                    'comments'      => 1,
                    'users'         => 1,
                    'admin'         => 1
                ),
                'created_at'    => $currentDatetime,
                'updated_at'    => $currentDatetime,
            )

        );

        foreach($groups as $group)
        {
            try
            {
                \Bencavens\Chief\Services\ChiefSentryFacade::createGroup( $group );
            }

            catch (\Cartalyst\Sentry\Groups\NameRequiredException $e)
            {
                echo 'Error creating group. Name field is required';
            }
            catch (\Cartalyst\Sentry\Groups\GroupExistsException $e)
            {
                echo 'Error creating group. Group already exists';
            }
        }
    }

    /**
     * Assign Admin to admin group
     *
     * @return void
     */
    public function addGroupToAdmin()
    {
        try
        {
            // Find the user using the user id
            $user = \Bencavens\Chief\Services\ChiefSentryFacade::findUserById(1);

            // Find the group using the group id
            $admin = \Bencavens\Chief\Services\ChiefSentryFacade::findGroupByName('admin');

            // Assign the group to the user
            $user->addGroup( $admin );
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            echo 'User was not found...';
        }
        catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
            echo 'Group was not found.';
        }
    }

    /**
     * Insert Example Post
     *
     * @return void
     */
    public function insertExamplePost()
    {
        $posts = array(
            array(
                'id'        => 1,
                'title'     => 'Your First article on Chief',
                'subtitle'  => 'Congratulations on putting on your Chief Hat',
                'slug'      => 'first-post',
                'content'   => 'Hello<br>and welcome to Chief. Hope you enjoy yourself around here. ',
                'status'    => 'published',
                'parent_id' => 0,
                'comment_count' => 0,
                'image_id'  => 1,
                'views'     => 0,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'published_at'  => null
            )
        );

        // Uncomment the below to run the seeder
        DB::table('chiefposts')->insert($posts);
    }
}