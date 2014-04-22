<?php namespace Bencavens\Chief\Tests;

use Bencavens\Chief\Posts\PostRepository;
use Bencavens\Chief\Users\UserRepository;
use Bencavens\Chief\Posts\CommentRepository;

use Bencavens\Chief\Core\ChiefRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CustomPostRepository extends PostRepository{
	
	public function __construct( CustomPostModel $model )
	{
		$this->model = $model;
	}

}

class CustomUserRepository extends UserRepository{
	
	public function __construct( CustomUserModel $model )
	{
		$this->model = $model;
	}

}

class CustomCommentRepository extends CommentRepository{
	
	public function __construct( CustomCommentModel $model )
	{
		$this->model = $model;
	}

}

class Article extends Model{
	
}

class ArticleRepository implements ChiefRepositoryInterface{
	
	public function __construct( Article $model )
	{
		$this->model = $model;
	}

	public function getAll(){

	}

	public function getById( $id ){}

}

