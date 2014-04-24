<?php namespace Bencavens\Chief\Controllers;

use Illuminate\Routing\Controller;
use Bencavens\Chief\ChiefFacade as Chief;
use Bencavens\Chief\Posts\CommentManager;
use View,Redirect,Input,App;

class CommentsController extends Controller{
	
	/**
	 * Index
	 *
	 * @return Response
	 */
	 public function index()
	 {
	 	$comments = Chief::comment()->paginate(10)->orderBy('created_at','DESC')->getAll();

	 	return View::make('chief::comments.index',compact('comments'));
	 }

	/**
	 * create a comment
	 *
	 * @return Response
	 */
	 public function create()
	 {
	 	$comment = null;

	 	return View::make('chief::comments.create',compact('comment'));
	 }

	/**
	 * store a comment
	 *
	 * @return Response
	 */
	 public function store()
	 {
	 	$commentManager = App::make('Bencavens\Chief\Posts\CommentManager');

	 	if( $commentManager->create( Input::all() ))
	 	{
	 		return Redirect::route('chief.comments.index'); 
	 	}

	 	return Redirect::back()->withInput()->withErrors( Chief::error()->get() );
	 }

	/**
	 * edit a comment
	 *
	 * @param  int 	$comment_id
	 * @return Response
	 */
	 public function edit( $comment_id )
	 {
	 	$comment = Chief::comment()->getById( $comment_id );

	 	return View::make('chief::comments.edit',compact('comment'));
	 }

	/**
	 * update a comment
	 *
	 * @param  int 	$comment_id
	 * @return Response
	 */
	 public function update( $comment_id )
	 {
	 	$commentManager = App::make('Bencavens\Chief\Posts\CommentManager');

	 	if( $commentManager->update( $comment_id, Input::all() ))
	 	{
	 		return Redirect::route('chief.comments.index'); 
	 	}

	 	return Redirect::back()->withInput()->withErrors( Chief::error()->get() );
	 }

	/**
	 * delete a comment
	 *
	 * @return Response
	 */
	 public function destroy( $comment_id )
	 {
	 	$commentManager = App::make('Bencavens\Chief\Posts\CommentManager');

	 	if( $commentManager->delete( $comment_id ))
	 	{
	 		return Redirect::route('chief.comments.index'); 
	 	}

	 	return Redirect::route('chief.comments.index'); 
	 }


}