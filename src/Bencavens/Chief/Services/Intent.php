<?php namespace Bencavens\Chief\Services;

/*
|--------------------------------------------------------------------------
| Intent
|--------------------------------------------------------------------------
|
| Handle intended url redirects. 
| Allows for easy insert of intents. works well with laravel native URL::intended()
|
| @version 	0.1
| @author 	Ben Cavens <cavensben@gmail.com>
*/
use Illuminate\Session\Store as SessionStore;
use App,Request;

class Intent{
	
	/** 
	 * Intended url, saved in session
	 *
	 */
	protected $intended = null;

	/**
	 * Session key
	 *
	 * @var string
	 */
	protected $key = 'url.intended';


	public function __construct()
	{
		$this->session = App::make('session.store');

		// Load the intended from session
		$this->intended = $this->session->get($this->key,null);

	}

	public static function make()
	{
		return new static();
	}

	/**
	 * Is there a intended?
	 *
	 * @return bool
	 */
	protected function exists()
	{
		return !is_null($this->intended);
	}

	/**
	 * Add an intended url to the stack
	 *
	 * @param 	string 	$intent
	 * @return  void
	 */
	protected function put($intent = null)
	{
		// We use the referrer url as our intended default
		if(is_null($intent)) $intent = Request::url();
		
		$this->set($intent);
	}

	/**
	 * Retrieve the last intended url
	 *
	 * @param 	mixed 	$default - if no intended url is found
 	 * @return  string
	 */
	protected function get($default = null)
	{
		if(!is_null($this->intended))
		{
			// Clear the intent stack
			$this->flush();

			return $this->intended;
		}

		return $default;
	}

	/**
	 * Add to intended
	 *
	 */
	protected function set($intent)
	{
		$this->intended = $intent;
		
		$this->session->put($this->key,$this->intended);
	}

	/**
	 * Clear all intents from intended
	 *
	 */
	protected function flush()
	{
		$this->intended = null;
		
		$this->session->forget($this->key);
	}

	/**
	 * Magic method
	 *
	 */
	public static function __callStatic($method,$parameters)
	{
		
		$class = get_called_class();

		if(method_exists($class,$method))
		{
			return call_user_func_array(array(new $class,$method),$parameters);
		}

		throw new \Exception('Invalid method. '.$class.' has no method called "'.$method .'"');

	}

	

	
}