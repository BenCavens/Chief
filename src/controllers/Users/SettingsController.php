<?php namespace Bencavens\Chief\Controllers\Users;

use Illuminate\Routing\Controller;
use Bencavens\Chief\ChiefFacade as Chief;
use Bencavens\Chief\Users\UserManager;
use View,Redirect,Input,App;

class SettingsController extends Controller{
	
	public function __construct( UserManager $userManager )
	{
		$this->userManager = $userManager;
	}

	/**
	 * edit your own settings
	 *
	 * @return Response
	 */
	 public function edit()
	 {
	 	$user = Chief::auth()->getLogged();

	 	return View::make('chief::users.settings.edit',compact('user'));
	 }

	/**
	 * update a user
	 *
	 * @param  int 	$user_id
	 * @return Response
	 */
	 public function update()
	 {
	 	$user = Chief::auth()->getLogged();

	 	if( $this->userManager->update( $user->id, Input::all() ))
	 	{
	 		return Redirect::route('chief.posts.index'); 
	 	}

	 	return Redirect::back()->withInput()->withErrors( Chief::error()->get() );
	 }

	



}