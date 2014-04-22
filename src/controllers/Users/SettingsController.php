<?php namespace Bencavens\Chief\Controllers\Users;

use Illuminate\Routing\Controller;
use Bencavens\Chief\ChiefFacade as Chief;
use Bencavens\Chief\Users\UserManager;
use View,Redirect,Input,App;

class SettingsController extends Controller{
	
	/**
	 * edit a setting
	 *
	 * @param  int 	$user_id
	 * @return Response
	 */
	 public function edit( $user_id )
	 {
	 	$user = Chief::user()->getById( $user_id );

	 	return View::make('chief::users.edit',compact('user'));
	 }

	/**
	 * edit own settings
	 *
	 * @return Response
	 */
	 public function edit_own()
	 {
	 	$user = Chief::auth()->getLogged();

	 	return View::make('chief::users.settings.own',compact('user'));
	 }

	/**
	 * update a user
	 *
	 * @param  int 	$user_id
	 * @return Response
	 */
	 public function update( $user_id )
	 {
	 	$userManager = App::make('Bencavens\Chief\Users\UserManager');

	 	if( $userManager->update( $user_id, Input::all() ))
	 	{
	 		return Redirect::route('chief.users.index'); 
	 	}

	 	return Redirect::back()->withInput()->withErrors( Chief::error()->get() );
	 }

	



}