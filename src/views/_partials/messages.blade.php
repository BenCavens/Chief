<?php 

/**
 *--------------------------------------------------------------------------
 * Messagebar
 *--------------------------------------------------------------------------
 *
 * Display messages to user. Messages appear after an action is performed.
 * There are success, error or info messages. 
 * 
 *
 * 
 */
if(count( $_messages = Session::get('messages')) > 0)
{
	$bar = array();

	foreach($_messages as $type => $message)
	{
		$bar[] = '<div class="alert alert-'.$type.' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$message.'</div>';
	}

	// Display messagebar
	echo implode('',$bar);
}

?>
