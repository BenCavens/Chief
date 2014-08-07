<?php namespace Bencavens\Chief;

use Bencavens\Chief\Posts\PostRepositoryInterface;
use Bencavens\Chief\Users\UserRepositoryInterface;
use Bencavens\Chief\Posts\CommentRepositoryInterface;
use Bencavens\Chief\Tags\TagRepositoryInterface;
use Bencavens\Chief\Tags\CategoryRepositoryInterface;
use Bencavens\Chief\Posts\PostManager;
use Bencavens\Chief\Posts\CommentManager;
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
								 PostManager $postManager,
								 CommentManager $commentManager,
								 ErrorManager $error )
	{
		$this->postRepo 	= $postRepo;
		$this->userRepo 	= $userRepo;
		$this->auth 		= $auth;
		$this->commentRepo 	= $commentRepo;
		$this->tagRepo 		= $tagRepo;
		$this->categoryRepo = $categoryRepo;
		$this->postManager  = $postManager;
		$this->commentManager = $commentManager;
		$this->error 		= $error;
	}

	public function post(){ return $this->postRepo; }
	public function user(){ return $this->userRepo; }
	public function auth(){ return $this->auth; }
	public function comment(){ return $this->commentRepo; }

	public function tag(){ return $this->tagRepo; }
	public function category(){ return $this->categoryRepo; }
	public function error(){ return $this->error; }
	public function postManager(){ return $this->postManager; }
	public function commentManager(){ return $this->commentManager; }

	/**
	 * Dynamic call to own repositories
	 *
	 * @param 	string 	$method
	 * @param 	array 	$parameters
	 * @return 	Repository
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