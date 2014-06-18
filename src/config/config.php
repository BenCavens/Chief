<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Main chief email
	|--------------------------------------------------------------------------
	|
	| Main email address that is used as sender for all password reminders
	| and confirmation mails
	*/
	'mail' => [

		'from' 	=> ['Chief admin','chief@localhost.com']

	],

	/*
	|--------------------------------------------------------------------------
	| Custom Repositories
	|--------------------------------------------------------------------------
	|
	| Chief provides the post listing out of the box. 
	| Developers are free to add others listable resources like events, gigs, contacts,... 
	| TO DEVELOP
	*/

	'repositories' => [

		// 'events' 	=> 'App\Repositories\EventRepository'
		'article'	=> '\Bencavens\Chief\Tests\ArticleRepository'

	],

	/*
	|--------------------------------------------------------------------------
	| Custom Repositorie Column attribute defaults
	|--------------------------------------------------------------------------
	|
	| For each of the custom repositories listed above, you can provide a datatype for all columns
	| The Backend will present the data as such
	|
	*/

	'attributes' => [

		'article'	=> [

			'content'	=> ['textarea','content',null,['placeholder' => 'content']]

		]

	],
	// datatypes
	// attribute data

	/*
	|--------------------------------------------------------------------------
	| CHIEF SENTRY
	|--------------------------------------------------------------------------
	|
	| 
	|
	*/
	'sentry'=>array(
        
        'driver' => 'eloquent',
        
        'hasher' => 'native',
        
        'groups' => array(
            'model' => 'Bencavens\Chief\Users\Group',
        ),

        'cookie' => array(
            'key' => 'cartalyst_sentry_chief',
        ),

        'users' => array(
            'model' => 'Bencavens\Chief\Users\User',
            'login_attribute' => 'email',
        ),

        'throttling' => array(
            'enabled' => false,
            'model' => 'Cartalyst\Sentry\Throttling\Eloquent\Throttle',
            'attempt_limit' => 5,
            'suspension_time' => 15,
        ),
    ),


);


