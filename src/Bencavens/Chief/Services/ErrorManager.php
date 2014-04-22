<?php namespace Bencavens\Chief\Services;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;

class ErrorManager{
	
	/**
	 * Cached collection of messages
	 *
	 * @var array
	 */
	static protected $messages = array();

	/**
	 * Session key
	 * 
	 * Make sure we don't use the standard 'errors' since this will override our errors variable in our views
	 * @var string
	 */
	protected $key = 'error_messages';

	/**
	 * Checks if we have any error messages
	 *
	 * @return bool
	 */
	public function hasAny()
	{
		$messages = $this->get();

		return !!count($messages);
	}

	/**
	 * Retrieve the first error message
	 * 
	 *@return  array
	 */
	public function first()
	{
 		return $this->hasAny() ? reset(static::$messages) : null;
	}

	/**
	 * Retrieve the error messages
	 * 
	 *@return  array
	 */
	public function get()
	{
 		return static::$messages;
	}

	/**
	 * Writes a new resource to storage
	 *
	 * @param 	string  $message
	 * @return  void
	 */
	public function add($message)
	{
		static::$messages[] = $message;
		
		$this->store();
	}

	/**
	 * Add translated message
	 *
	 * @param 	string 	$trans
	 * @param 	array 	$parameters
	 * @return  void
	 */
	public function trans( $trans, $parameters = array() )
	{
		$message =  Lang::get($trans,$parameters);

		$this->add( $message );
	}

	/**
	 * Save the messages to session
	 *
	 * @return void
	 */
	public function store()
	{
		Session::flash($this->key,static::$messages);
	}

	/**
	 * Forget message stack
	 *
	 * @return void
	 */
	public function forget()
	{
		static::$messages = array();

		Session::forget($this->key);
	}

	/**
	 * Array interpretation of error messages
	 *
	 */
	public function __toString()
	{
		return static::$messages;
	}

	
	
}