<?php namespace Bencavens\Chief\Services;

use Bencavens\Chief\Users\User;
use Exception,Session,stdClass,Input,Hash;

class AuthManager{
	
	public function __construct( Auth $auth,
                                 ErrorManager $errorManager )
    {
        $this->auth = $auth;
        $this->errorManager = $errorManager;
    }

   /**
	 * Log the user in
	 *
	 * @param 	array $credentials
	 * @param   bool  $remember
	 * @return  bool
	 */
	public function login(array $credentials,$remember = false)
	{
		try 
 		{
 			$this->auth->login($credentials,$remember);

 			return true;
 		} 

 		catch (Exception $e) 
 		{
            if( $e instanceof \Cartalyst\Sentry\Users\LoginRequiredException)
            {
                $this->errorManager->add('Email is verplicht');
            }
            else if( $e instanceof \Cartalyst\Sentry\Users\PasswordRequiredException)
            {
                $this->errorManager->add('Paswoord is verplicht');
            }
            else if( $e instanceof \Cartalyst\Sentry\Users\WrongPasswordException)
            {
                $this->errorManager->add('Paswoord is niet correct');
            }
            else if( $e instanceof \Cartalyst\Sentry\Users\UserNotFoundException)
            {
                $this->errorManager->add('Dit emailadres is nog geregistreerd.');
            }
            else if( $e instanceof \Cartalyst\Sentry\Users\UserNotActivatedException)
            {
                $this->errorManager->add('Dit emailadres is nog niet geactiveerd. Contacteer de Chief admin om jouw account te laten activeren');
            }
            else if( $e instanceof \Cartalyst\Sentry\Throttling\UserSuspendedException)
            {
                $this->errorManager->add('Dit emailadres is tijdelijk gedesactiveerd wegens teveel loginpogingen. Na een kwartiertje kan u opnieuw inloggen. We verontschuldigen ons voor dit ongemak maar dit is een maatregel tegen verdacht surfgedrag. <br><br>Contacteer het Young Prozzz team om je hierbij te assisteren.');
            }
            else if( $e instanceof \Cartalyst\Sentry\Throttling\UserBannedException)
            {
                $this->errorManager->add('Dit emailadres is momenteel niet meer actief. Hebt u hierbij vragen, contacteer dan één van de Young Prozzz teammembers.');
            }

            else
            {
                throw new Exception($e);
            }

        }

        return false;	
	}

   

    /**
     * Logs the user out
     *
     */
    public function logout()
    {
        $this->auth->logout();
    }

    /**
     * Register a new user
     *
     * @param   array $credentials
     * @param   bool  $remember
     * @return  bool
     */
    public function register(array $credentials)
    {
        // Try to register the user
        try 
        {
            $user = $this->auth->register($credentials);

            return true;
        } 

        catch (Exception $e) 
        {
            if( $e instanceof \Cartalyst\Sentry\Users\LoginRequiredException)
            {
                $this->errorManager->add('Email is verplicht');
            }
            else if( $e instanceof \Cartalyst\Sentry\Users\PasswordRequiredException)
            {
                $this->errorManager->add('Paswoord is verplicht');
            }
            else if( $e instanceof \Cartalyst\Sentry\Users\UserExistsException)
            {
                $login_link = link_to_route('chief.user.login','Login');
            
                $forget_link = link_to_route('chief.user.forgotpassword','did you forget your password?');
            
                $this->errorManager->add('Someone is already registered with this email. '.$login_link.' or '.$forget_link);
            }
            else
            {
                // Unknown exception must be thrown directly to client
                throw new Exception($e);
            }
        }

        return false;

    }

    /**
     * Activate an user
     *
     */
    public function activate(User $user,$activationcode)
    {
        try
        {
            // Attempt to activate the user
            if($this->auth->activate($user->id,$activationcode))
            {
                return true;
            }
            else
            {
                // No activation code and not yet activated. means invalid request to this method
                if(is_null($user->activation_code) and 0 === $user->activated)
                {
                    $this->errorManager->add('Invalid request for activation. We have sent you a new activation mail. Please contact our support team if this issue persists.');
                
                    // Resend activation mail
                    $this->mail->sendActivationMail($user);

                }

                else
                {
                    // User activation failed
                    $this->errorManager->add('Something went wrong on your activation. We apologize for this inconvenience. Please contact our support team to assist you.');
                }

            }
        }
        catch (Exception $e) 
        {
            if( $e instanceof \Cartalyst\Sentry\Users\UserNotFoundException)
            {
                $this->errorManager->add('No user found by these credentials');
            }
            else if( $e instanceof \Cartalyst\Sentry\Users\UserAlreadyActivatedException)
            {
                // User may pass since he is already activated
                return true;
            }

            else
            {
                throw new Exception($e);
            }
        
        }

        return false;
    }


    /**
     * Reset a password
     *
     */
    public function resetPassword(User $user,$resetcode)
    {
        $password = Input::get('password');
        $password_confirm = Input::get('password_confirm');

        // VALIDATION
        if(empty($password))
        {
            $this->errorManager->add('Geef aub een paswoord in');
            return false;
        }
        else if($password != $password_confirm)
        {
            $this->errorManager->add('Paswoorden komen niet overeen.');
            return false;
        }

        try
        {
            // Attempt to activate the user
            if($this->auth->resetPassword($user->id,$resetcode,$password))
            {
                return true;
            }
            else
            {
                // User activation failed
                $this->errorManager->add('Something went wrong while trying to reset your password. We apologize for this inconvenience. Please contact our support team to assist you.');
           
            }
        }
        catch (Exception $e) 
        {
            throw new Exception($e);
        
        }

        return false;
    }

}