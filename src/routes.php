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

	Route::resource('posts','Bencavens\Chief\Controllers\PostsController');
	Route::resource('comments','Bencavens\Chief\Controllers\CommentsController');
	
	// Own settings... TODO: auth filter check is logged as this one
	Route::get('settings',array('as' => 'chief.user.settings.own','uses'=>'Bencavens\Chief\Controllers\Users\SettingsController@edit_own'));
	Route::put('settings',array('as' => 'chief.user.settings.own.update','uses'=>'Bencavens\Chief\Controllers\Users\SettingsController@update'));
	
	// upload image via our editor
	Route::post('posts/image/upload',array('as' => 'chief.posts.image.upload','uses' => 'Bencavens\Chief\Controllers\FilesController@uploadImage'));

	// Route::resource('media',"Bencavens\Chief\Controllers\MediaController");
	
	Route::resource('users',"Bencavens\Chief\Controllers\Users\UsersController"); // Only Managers
	Route::resource('categories',"Bencavens\Chief\Controllers\CategoriesController");
	Route::resource('tags',"Bencavens\Chief\Controllers\TagsController");

	Route::get('/','Bencavens\Chief\Controllers\PostsController@index');

});



/**
 * -------------------------------------------------------
 * Chief Auth filter
 * -------------------------------------------------------
 *
 */
Route::filter('chief.auth', function()
{
	if(false == \Bencavens\Chief\ChiefFacade::auth()->isLogged())
	{
		\Bencavens\Chief\Services\Intent::put();

		return Redirect::route('chief.user.login');
	}
	
});