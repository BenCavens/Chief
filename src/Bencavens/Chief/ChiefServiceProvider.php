<?php namespace Bencavens\Chief;

use Illuminate\Support\ServiceProvider;

class ChiefServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('bencavens/chief');

		include_once __DIR__.'/Services/htmLawed.php';
		include_once __DIR__.'/Services/helpers.php';

		include_once __DIR__.'/../../routes.php';		
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Register all our service providers
		$this->app->register('Bencavens\Chief\Providers\RepositoryServiceProvider');
		$this->app->register('Bencavens\Chief\Providers\ChiefSentryServiceProvider');
	
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}