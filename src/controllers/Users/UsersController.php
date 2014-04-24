<?php namespace Bencavens\Chief\Controllers\Users;

use Illuminate\Routing\Controller;
use Bencavens\Chief\ChiefFacade as Chief;
use Bencavens\Chief\Users\UserManager;
use View,Redirect,Input,App;

class UsersController extends Controller{
	
	/**
	 * Index
	 *
	 * @return Response
	 */
	 public function index()
	 {
	 	$users = Chief::user()->paginate(12)->getAll();

	 	return View::make('chief::users.index',compact('users'));
	 }

	/**
	 * Show
	 *
	 * @return Response
	 */
	 public function show()
	 {
	 	return 'show a user';
	 }

	/**
	 * create a user
	 *
	 * @return Response
	 */
	 public function create()
	 {
	 	$user = null;

	 	return View::make('chief::users.create',compact('user'));
	 }

	/**
	 * store a user
	 *
	 * @return Response
	 */
	 public function store()
	 {
	 	$userManager = App::make('Bencavens\Chief\Users\UserManager');

	 	if( $userManager->create( Input::all() ))
	 	{
	 		return Redirect::route('chief.users.index'); 
	 	}

	 	return Redirect::back()->withInput()->withErrors( Chief::error()->get() );
	 }

	/**
	 * edit a user
	 *
	 * @param  int 	$user_id
	 * @return Response
	 */
	 public function edit( $user_id )
	 {
	 	$user = Chief::user()->getById( $user_id );

	 	$groups = \Bencavens\Chief\Users\Group::all();
	 	$groups = array_pair($groups,'name','id');

	 	// Add own groups to user model for form model binding
	 	$user->groups = array_pair($user->groups()->get()->toArray(),'id');

	 	return View::make('chief::users.edit',compact('user','groups'));
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

	/**
	 * delete a user
	 *
	 * @return Response
	 */
	 public function destroy( $user_id )
	 {
	 	$userManager = App::make('Bencavens\Chief\Users\UserManager');

	 	if( $userManager->delete( $user_id ))
	 	{
	 		return Redirect::route('chief.users.index'); 
	 	}

	 	return Redirect::route('chief.users.index'); 
	 }


}