<?php namespace Bencavens\Chief;

use Bencavens\Chief\Posts\PostRepositoryInterface;
use Bencavens\Chief\Users\UserRepositoryInterface;
use Bencavens\Chief\Posts\CommentRepositoryInterface;
use Bencavens\Chief\Tags\TagRepositoryInterface;
use Bencavens\Chief\Tags\CategoryRepositoryInterface;
use Bencavens\Chief\Services\Auth;
use Bencavens\Chief\Services\ErrorManager;
use Exception,Config,App;

class Chief{
	
	static $cachedRepos = array();

	public function __construct( PostRepositoryInterface $postRepo,
								 UserRepositoryInterface $userRepo,
								 Auth $auth,
								 CommentRepositoryInterface $commentRepo,
								 TagRepositoryInterface $tagRepo,
								 CategoryRepositoryInterface $categoryRepo,
								 ErrorManager $error )
	{
		$this->postRepo 	= $postRepo;
		$this->userRepo 	= $userRepo;
		$this->auth 		= $auth;
		$this->commentRepo 	= $commentRepo;
		$this->tagRepo 		= $tagRepo;
		$this->categoryRepo = $categoryRepo;
		$this->error 		= $error;
	}

	/**
	 * Postrepository
	 * 
	 * @return PostRepository
	 */
	public function post()
	{
		return $this->postRepo;
	}

	/**
	 * userrepository
	 * 
	 * @return userRepository
	 */
	public function user()
	{
		return $this->userRepo;
	}

	/**
	 * Chief Auth
	 * 
	 * @return Auth
	 */
	public function auth()
	{
		return $this->auth;
	}

	/**
	 * commentrepository
	 * 
	 * @return commentRepository
	 */
	public function comment()
	{
		return $this->commentRepo;
	}

	/**
	 * tagrepository
	 * 
	 * @return tagRepository
	 */
	public function tag()
	{
		return $this->tagRepo;
	}

	/**
	 * categoryrepository
	 * 
	 * @return categoryRepository
	 */
	public function category()
	{
		return $this->categoryRepo;
	}

	/**
	 * Chief Error Manager
	 * 
	 * @return ErrorManager
	 */
	public function error()
	{
		return $this->error;
	}

	/**
	 * Dynamic call to own repositories
	 *
	 * @param 	string 	$method
	 * @param 	array 	$parameters
	 * @return 	PostRepository
	 */
	 public function __call($method, $parameters)
	{
		if(array_key_exists($method,self::$cachedRepos)) return self::$cachedRepos[$method];

		$repositories = Config::get('chief::config.repositories');

		foreach($repositories as $name => $repository)
		{
			if($method == $name)
			{
				return self::$cachedRepos[$method] = App::make($repository);
			}
		}

		throw new Exception('['.$method.'] does not point to an existing repository and does not exist as method on the Chief object');

	}

}