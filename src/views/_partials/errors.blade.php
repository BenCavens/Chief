<?php

if(isset($errors))
{
	// Laravel always provides an errors variable
	// Errors could be a Messagebag object
	if($errors instanceof Illuminate\Support\MessageBag)
	{
		$errors = $errors->all();
	}


	if(count($errors) > 0)
	{
		// Easy hack to avoid duplicates in error messages
		// Keep local cache of displayed errors
		$local_errors = array();

		$error_list = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><ul class="messages-error">';

		foreach($errors as $error)
		{
			if(false === array_search($error,$local_errors) )
			{
				$error_list .= '<li>'.$error.'</li>';

				$local_errors[] = $error;
			} 
		}

		echo $error_list.'</ul></div>';
	}
}
