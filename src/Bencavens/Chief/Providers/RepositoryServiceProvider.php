<?php namespace Bencavens\Chief\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider{

	public function register()
	{
		// PostRepository
		$this->app->bind(
			'Bencavens\Chief\Posts\PostRepositoryInterface',
			'Bencavens\Chief\Posts\PostRepository'
		);

		// UserRepository
		$this->app->bind(
			'Bencavens\Chief\Users\UserRepositoryInterface',
			'Bencavens\Chief\Users\UserRepository'
		);

		// CommentRepository
		$this->app->bind(
			'Bencavens\Chief\Posts\CommentRepositoryInterface',
			'Bencavens\Chief\Posts\CommentRepository'
		);

		// TagRepository
		$this->app->bind(
			'Bencavens\Chief\Tags\TagRepositoryInterface',
			'Bencavens\Chief\Tags\TagRepository'
		);

		// CategoryRepository
		$this->app->bind(
			'Bencavens\Chief\Tags\CategoryRepositoryInterface',
			'Bencavens\Chief\Tags\CategoryRepository'
		);
	}

}