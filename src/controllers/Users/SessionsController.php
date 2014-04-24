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

use Bencavens\Chief\ChiefFacade as Chief;

use Bencavens\Chief\Services\AuthManager;
use Bencavens\Chief\Services\Auth;
use Illuminate\Routing\Controller;
use View,Input,Redirect;

class SessionsController extends Controller{

    public function __construct( AuthManager $authManager,
                                 Auth $auth )
    {
        $this->authManager = $authManager;
        $this->auth = $auth;
    }

    /**
     * Display login form
     *
     */
    public function create()
    {
        return View::make('chief::users.login');
    }

    /**
     * Handle login submit
     *
     */
    public function store()
    {
        $credentials = array(
            'email'         => Input::get('email'),
            'password'      => Input::get('password')
        );

        // Remember me foreva, not by default
        $remember = !!Input::get('remember',0);

        if($this->authManager->login($credentials,$remember))
        {
            // Get the userslug from the freshly logged user
            $user = $this->auth->getLogged();

            return Redirect::intended(route('chief.posts.index'));
        }

        return Redirect::back()->withErrors(Chief::error()->get())->withInput();
    }

    /**
     * Handle Logout
     *
     */
    public function destroy()
    {
        // Log the user out
        $this->authManager->logout();

        return Redirect::route('chief.user.login');
    }

    

}
