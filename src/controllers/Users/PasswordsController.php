<?php namespace Bencavens\Chief\Controllers\Users;

/*
|--------------------------------------------------------------------------
| User pages
|--------------------------------------------------------------------------
|
| These are the user page profile and managable pages
| Only Accessible for the logged User 
|
*/

use Bencavens\Chief\Users\UserRepositoryInterface;
use Bencavens\Chief\Services\AuthManager;
use Bencavens\Chief\Services\Auth;
use Bencavens\Chief\Services\ErrorManager;
use Bencavens\Chief\Services\Pipeline;
use Illuminate\Routing\Controller;
use View,Input,Redirect;

class PasswordsController extends Controller {

	public function __construct( 	UserRepositoryInterface $user,
									AuthManager $authManager,
									Auth $auth,
									Pipeline $pipeline,
									ErrorManager $error	)
	{
		$this->user 		= $user;
		$this->authManager 	= $authManager;
		$this->auth 		= $auth;
		$this->pipeline  	= $pipeline;
		$this->error  		= $error;
	}

	/**
	 * Display forgot password form
	 *
	 * @return Response
	 */
	public function forgot()
	{
       $user = $this->auth->getLogged();

       return View::make('chief::users.password.forgot',compact('user'));
	}

	/**
	 * Handle forgot password form
	 *
	 * @return Response
	 */
	public function forgot_store()
	{
       // Get user by email
		$user = $this->user->getByEmail(Input::get('email'));

       if(!is_null($user))
       {
       	   // Send mail for reset invitation
	       $this->pipeline->sendResetPasswordMail($user);

		   // Confirm back to user
		    return View::make('chief::users.password.forgot_send',compact('user'));
       }
       
       $this->error->add('Sorry. We hebben geen account gevonden via het opgegeven emailadres.');

	    return Redirect::back()->withInput()->withErrors($this->error->get());
	}

	/**
	 * Display reset password form
	 *
	 * @return Response
	 */
	public function reset($id,$resetcode)
	{
       $user = $this->user->getById($id);

       return View::make('chief::users.password.reset',compact('user','resetcode'));
      
	}

	/**
	 * Handle reset password form
	 *
	 * @return Response
	 */
	public function reset_store($id,$resetcode)
	{
       $user = $this->user->getById($id);

       if(!is_null($user))
       {
       		if($this->authManager->resetPassword($user,$resetcode))
       		{
       			return View::make('chief::users.password.resetconfirm',compact('user'));
       		}

        }
       
       return Redirect::back()->withInput()->withErrors($this->error->get());
	}

	

}
