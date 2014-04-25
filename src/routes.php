<?php 

/**
 * -------------------------------------------------------
 * Public Chief Routes
 * -------------------------------------------------------
 *
 */
Route::group(array('prefix' => 'chief'),function(){

	// Login
	Route::get('logout',array('as' => 'chief.user.logout', 'uses' => 'Bencavens\Chief\Controllers\Users\SessionsController@destroy'));
	Route::post('login',array('as' => 'chief.user.login.store','uses' => 'Bencavens\Chief\Controllers\Users\SessionsController@store'));
	Route::get('login',array('as' => 'chief.user.login','uses' => 'Bencavens\Chief\Controllers\Users\SessionsController@create'));
	
	// Reset password
	Route::get('forgotpassword',array('as' => 'chief.user.forgotpassword','uses'=>'Bencavens\Chief\Controllers\Users\PasswordsController@forgot'));
	Route::post('forgotpassword',array('as' => 'chief.user.forgotpassword.store','uses'=>'Bencavens\Chief\Controllers\Users\PasswordsController@forgot_store'));
	Route::get('resetpassword/{userid}/{resetcode}',array('as' => 'chief.user.resetpassword','uses'=>'Bencavens\Chief\Controllers\Users\PasswordsController@reset'));
	Route::post('resetpassword/{userid}/{resetcode}',array('as' => 'chief.user.resetpassword.store','uses'=>'Bencavens\Chief\Controllers\Users\PasswordsController@reset_store'));

});

/**
 * -------------------------------------------------------
 * Chief Backend Routes
 * -------------------------------------------------------
 *
 */
Route::group(array('prefix' => 'chief','before' => 'chief.auth'),function(){

	// POST ROUTES
	Route::get('posts',array('as' => 'chief.posts.index','uses' =>'Bencavens\Chief\Controllers\PostsController@index'));
	Route::get('posts/create',array('as' => 'chief.posts.create','before' => 'chief.hasAccess:post-create', 'uses' =>'Bencavens\Chief\Controllers\PostsController@create'));
	Route::get('posts/{id}',array('as' => 'chief.posts.show','uses' =>'Bencavens\Chief\Controllers\PostsController@show'));
	Route::post('posts',array('as' => 'chief.posts.store','before' => 'chief.hasAccess:post-create', 'uses' =>'Bencavens\Chief\Controllers\PostsController@store'));
	Route::get('posts/{id}/edit',array('as' => 'chief.posts.edit','before' => 'chief.hasAccess:post-edit', 'uses' =>'Bencavens\Chief\Controllers\PostsController@edit'));
	Route::put('posts/{id}',array('as' => 'chief.posts.update','before' => 'chief.hasAccess:post-edit', 'uses' =>'Bencavens\Chief\Controllers\PostsController@update'));
	Route::delete('posts/{id}',array('as' => 'chief.posts.destroy','before' => 'chief.hasAccess:post-delete', 'uses' =>'Bencavens\Chief\Controllers\PostsController@destroy'));

	// COMMENT ROUTES
	Route::get('comments',array('as' => 'chief.comments.index','uses' =>'Bencavens\Chief\Controllers\CommentsController@index'));
	Route::get('comments/create',array('as' => 'chief.comments.create','before' => 'chief.hasAccess:comment-create', 'uses' =>'Bencavens\Chief\Controllers\CommentsController@create'));
	Route::get('comments/{id}',array('as' => 'chief.comments.show','uses' =>'Bencavens\Chief\Controllers\CommentsController@show'));
	Route::post('comments',array('as' => 'chief.comments.store','before' => 'chief.hasAccess:comment-create', 'uses' =>'Bencavens\Chief\Controllers\CommentsController@store'));
	Route::get('comments/{id}/edit',array('as' => 'chief.comments.edit','before' => 'chief.hasAccess:comment-edit', 'uses' =>'Bencavens\Chief\Controllers\CommentsController@edit'));
	Route::put('comments/{id}',array('as' => 'chief.comments.update','before' => 'chief.hasAccess:comment-edit', 'uses' =>'Bencavens\Chief\Controllers\CommentsController@update'));
	Route::delete('comments/{id}',array('as' => 'chief.comments.destroy','before' => 'chief.hasAccess:comment-delete', 'uses' =>'Bencavens\Chief\Controllers\CommentsController@destroy'));

	// Own settings can be adjusted
	Route::get('settings',array('as' => 'chief.user.settings','uses'=>'Bencavens\Chief\Controllers\Users\SettingsController@edit'));
	Route::put('settings',array('as' => 'chief.user.settings.update','uses'=>'Bencavens\Chief\Controllers\Users\SettingsController@update'));
	
	// upload image via our editor
	Route::post('posts/image/upload',array('as' => 'chief.posts.image.upload','uses' => 'Bencavens\Chief\Controllers\FilesController@uploadImage'));

	// Route::resource('media','Bencavens\Chief\Controllers\MediaController');
	
	Route::get('/','Bencavens\Chief\Controllers\PostsController@index');

});

/**
 * -------------------------------------------------------
 * Chief Admin Routes
 * -------------------------------------------------------
 *
 */

Route::group(array('prefix' => 'chief','before' => 'chief.auth|chief.auth.manager'),function(){

	Route::resource('users','Bencavens\Chief\Controllers\Users\UsersController'); // Only Managers
	Route::resource('categories','Bencavens\Chief\Controllers\CategoriesController');
	Route::resource('tags','Bencavens\Chief\Controllers\TagsController');

});



/**
 * -------------------------------------------------------
 * Chief Auth filter
 * -------------------------------------------------------
 *
 */
Route::filter('chief.auth', function($route, $request)
{
	if(false == \Bencavens\Chief\ChiefFacade::auth()->isLogged())
	{
		\Bencavens\Chief\Services\Intent::put();

		return Redirect::route('chief.user.login');
	}
	
});

Route::filter('chief.auth.manager', function($route, $request)
{
	if( false == \Bencavens\Chief\ChiefFacade::auth()->isManager() )
	{
		return Redirect::route('chief.posts.index')->with('messages.danger','Unrestricted access');
	}
	
});

Route::filter('chief.hasAccess', function($route, $request, $value)
{
	if(false == \Bencavens\Chief\ChiefFacade::auth()->hasAccess( $value ))
	{
		return Redirect::route('chief.posts.index')->with('messages.danger','Unrestricted access');
	}
	
});

Route::filter('chief.inGroup', function($route, $request, $value)
{
	if(false == \Bencavens\Chief\ChiefFacade::auth()->inGroup( $value ))
	{
		return Redirect::route('chief.posts.index')->withErrors(array('not allowed in here'));
	}
	
});


 
//Example use
 
Route::group(array('prefix' => 'cms/product', 'before' => 'Sentry|inGroup:Admins'), function()
{
 Route::get('/', array(
 'as' => 'product.index',
	 'before' => 'hasAccess:product.index',
 'uses' => 'ProductController@index'
 ));
});
