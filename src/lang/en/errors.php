<?php

return array(

	'posts' => array(

		'title' 	=> array(

			'required'	=> 'Title is required'

		),
		'slug' 	=> array(

			'required'	=> 'Permalink is required.',
			'unique'	=> 'Post permalink must be unique. The entered one does already exist for another post.'

		)

	),

	'users' => array(

		'first_name' 	=> array(

			'required'	=> 'First name of user is required'

		),
		'last_name' 	=> array(

			'required'	=> 'Last name of user is required.'

		),
		'email' 	=> array(

			'required'	=> 'Email is required.',
			'unique'	=> 'Entered email does already exists for another Chief user. Make sure it is unique.'

		)

	)

);