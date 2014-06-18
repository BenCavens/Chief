<?php namespace Bencavens\Chief\Services;

use Bencavens\Chief\Users\UserRepositoryInterface;
use Bencavens\Chief\Users\User;
use Bencavens\Chief\Services\ErrorManager;
use Exception,stdClass,Mail;

class Pipeline{
	
	public function __construct( UserRepositoryInterface $user,
								 ErrorManager $error )
	{
		$this->user   = $user;
		$this->error  = $error;
	}

	/**
	 * Activation mail
	 *
	 */
	public function sendActivationMail(User $user)
	{
		/**
         * Activation code
         * access the  user class for  method 'getActivationCode'
         *
         */
       // $User = User::find( $user->id );

        // Activation code
        $activationcode = $user->getActivationCode();

        // Send activation code and redirect to confirmpage
        Mail::send('chief::_emails.activation',compact('user','activationcode'), function($message) use ($user)
        {
            $message->from();
            $message->to($user->email);
                    
        });
       
	}

	/**
	 * Reset password mail
	 *
	 */
	public function sendResetPasswordMail(User $user)
	{
		/**
         * Activation code
         * access the  user class for  method 'getActivationCode'
         *
         */
        // User = User::find( $user->id );

        // Reset password code
        $resetpasswordcode = $user->getResetPasswordCode();

        // Send activation code and redirect to confirmpage
        Mail::send('chief::_emails.resetpassword',compact('user','resetpasswordcode'), function($message) use ($user)
        {
            $message->to($user->email);
       });
        
	}

}