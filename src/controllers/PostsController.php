<?php namespace Bencavens\Chief\Controllers;

use Illuminate\Routing\Controller;
use Bencavens\Chief\ChiefFacade as Chief;
use Bencavens\Chief\Posts\PostManager;
use View,Redirect,Input,App;

class PostsController extends Controller{
	
	/**
	 * Index
	 *
	 * @return Response
	 */
	 public function index()
	 {
	 	$posts = Chief::post()->getAll(array(),6);

	 	return View::make('chief::posts.index',compact('posts'));
	 }

	/**
	 * Show
	 *
	 * @return Response
	 */
	 public function show()
	 {
	 	return 'show a post';
	 }

	/**
	 * create a post
	 *
	 * @return Response
	 */
	 public function create()
	 {
	 	$post = null;

	 	$categories = Chief::category()->getAll();
	 	$tags = Chief::tag()->getAll();

	 	return View::make('chief::posts.create',compact('post','categories','tags'));
	 }

	/**
	 * store a post
	 *
	 * @return Response
	 */
	 public function store()
	 {
	 	$postManager = App::make('Bencavens\Chief\Posts\PostManager');

	 	if( $postManager->create( Input::all() ))
	 	{
	 		return Redirect::route('chief.posts.index'); 
	 	}

	 	return Redirect::back()->withInput()->withErrors( Chief::error()->get() );
	 }

	/**
	 * edit a post
	 *
	 * @param  int 	$post_id
	 * @return Response
	 */
	 public function edit( $post_id )
	 {
	 	$post = Chief::post()->getById( $post_id );

	 	$categories = Chief::category()->getAll();
	 	$tags = Chief::tag()->getAll();

	 	// checkbox population
	 	// Add Tags and Categories to Post as id arrays
	 	$post->category_ids = array_pair($post->categories()->get(),'id');
	 	$post->tag_ids = array_pair($post->tags()->get(),'id');

	 	return View::make('chief::posts.edit',compact('post','categories','tags'));
	 }

	/**
	 * update a post
	 *
	 * @param  int 	$post_id
	 * @return Response
	 */
	 public function update( $post_id )
	 {
	 	$postManager = App::make('Bencavens\Chief\Posts\PostManager');

	 	if( $postManager->update( $post_id, Input::all() ))
	 	{
	 		return Redirect::route('chief.posts.index'); 
	 	}

	 	return Redirect::back()->withInput()->withErrors( Chief::error()->get() );
	 }

	/**
	 * delete a post
	 *
	 * @return Response
	 */
	 public function destroy( $post_id )
	 {
	 	$postManager = App::make('Bencavens\Chief\Posts\PostManager');

	 	if( $postManager->delete( $post_id ))
	 	{
	 		return Redirect::route('chief.posts.index'); 
	 	}

	 	return Redirect::route('chief.posts.index'); 
	 }


}