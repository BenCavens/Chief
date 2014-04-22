<?php namespace Bencavens\Chief\Providers;

use Cartalyst\Sentry\Cookies\IlluminateCookie;
use Cartalyst\Sentry\Groups\Eloquent\Provider as GroupProvider;
use Cartalyst\Sentry\Hashing\BcryptHasher;
use Cartalyst\Sentry\Hashing\NativeHasher;
use Cartalyst\Sentry\Hashing\Sha256Hasher;
use Cartalyst\Sentry\Hashing\WhirlpoolHasher;
use Cartalyst\Sentry\Sentry;
use Cartalyst\Sentry\Sessions\IlluminateSession;
use Cartalyst\Sentry\Throttling\Eloquent\Provider as ThrottleProvider;
use Cartalyst\Sentry\Users\Eloquent\Provider as UserProvider;
use Illuminate\Support\ServiceProvider;

class ChiefSentryServiceProvider_old extends ServiceProvider {

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		//$this->package('cartalyst/sentry', 'cartalyst/sentry');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerHasher();
		$this->registerUserProvider();
		$this->registerGroupProvider();
		$this->registerThrottleProvider();
		$this->registerSession();
		$this->registerCookie();
		$this->registerSentry();
	}

	/**
	 * Register the hasher used by Sentry.
	 *
	 * @return void
	 */
	protected function registerHasher()
	{
		$this->app['chief.sentry.hasher'] = $this->app->share(function($app)
		{
			$hasher = $app['config']->get('chief::config.sentry.hasher');

			switch ($hasher)
			{
				case 'native':
					return new NativeHasher;
					break;

				case 'bcrypt':
					return new BcryptHasher;
					break;

				case 'sha256':
					return new Sha256Hasher;
					break;

				case 'whirlpool':
					return new WhirlpoolHasher;
					break;
			}

			throw new \InvalidArgumentException("Invalid hasher [$hasher] chosen for Sentry.");
		});
	}

	/**
	 * Register the user provider used by Sentry.
	 *
	 * @return void
	 */
	protected function registerUserProvider()
	{
		$this->app['chief.sentry.user'] = $this->app->share(function($app)
		{
			$model = $app['config']->get('chief::config.sentry.users.model');

			// We will never be accessing a user in Sentry without accessing
			// the user provider first. So, we can lazily set up our user
			// model's login attribute here. If you are manually using the
			// attribute outside of Sentry, you will need to ensure you are
			// overriding at runtime.
			if (method_exists($model, 'setLoginAttributeName'))
			{
				$loginAttribute = $app['config']->get('chief::config.sentry.users.login_attribute');

				forward_static_call_array(
					array($model, 'setLoginAttributeName'),
					array($loginAttribute)
				);
			}

			// Define the Group model to use for relationships.
			if (method_exists($model, 'setGroupModel'))
			{
				$groupModel = $app['config']->get('chief::config.sentry.groups.model');

				forward_static_call_array(
					array($model, 'setGroupModel'),
					array($groupModel)
				);
			}

			// Define the user group pivot table name to use for relationships.
			if (method_exists($model, 'setUserGroupsPivot'))
			{
				$pivotTable = $app['config']->get('chief::config.sentry.user_groups_pivot_table');

				forward_static_call_array(
					array($model, 'setUserGroupsPivot'),
					array($pivotTable)
				);
			}

			return new UserProvider($app['chief.sentry.hasher'], $model);
		});
	}

	/**
	 * Register the group provider used by Sentry.
	 *
	 * @return void
	 */
	protected function registerGroupProvider()
	{
		$this->app['chief.sentry.group'] = $this->app->share(function($app)
		{
			$model = $app['config']->get('chief::config.sentry.groups.model');

			// Define the User model to use for relationships.
			if (method_exists($model, 'setUserModel'))
			{
				$userModel = $app['config']->get('chief::config.users.model');

				forward_static_call_array(
					array($model, 'setUserModel'),
					array($userModel)
				);
			}

			// Define the user group pivot table name to use for relationships.
			if (method_exists($model, 'setUserGroupsPivot'))
			{
				$pivotTable = $app['config']->get('chief::config.user_groups_pivot_table');

				forward_static_call_array(
					array($model, 'setUserGroupsPivot'),
					array($pivotTable)
				);
			}

			return new GroupProvider($model);
		});
	}

	/**
	 * Register the throttle provider used by Sentry.
	 *
	 * @return void
	 */
	protected function registerThrottleProvider()
	{
		$this->app['chief.sentry.throttle'] = $this->app->share(function($app)
		{
			$model = $app['config']->get('chief::config.throttling.model');

			$throttleProvider = new ThrottleProvider($app['chief.sentry.user'], $model);

			if ($app['config']->get('chief::config.throttling.enabled') === false)
			{
				$throttleProvider->disable();
			}

			if (method_exists($model, 'setAttemptLimit'))
			{
				$attemptLimit = $app['config']->get('chief::config.throttling.attempt_limit');

				forward_static_call_array(
					array($model, 'setAttemptLimit'),
					array($attemptLimit)
				);
			}
			if (method_exists($model, 'setSuspensionTime'))
			{
				$suspensionTime = $app['config']->get('chief::config.throttling.suspension_time');

				forward_static_call_array(
					array($model, 'setSuspensionTime'),
					array($suspensionTime)
				);
			}

			return $throttleProvider;
		});
	}

	/**
	 * Register the session driver used by Sentry.
	 *
	 * @return void
	 */
	protected function registerSession()
	{
		$this->app['chief.sentry.session'] = $this->app->share(function($app)
		{
			$key = $app['config']->get('chief::config.cookie.key');

			return new IlluminateSession($app['session.store'], $key);
		});
	}

	/**
	 * Register the cookie driver used by Sentry.
	 *
	 * @return void
	 */
	protected function registerCookie()
	{
		$this->app['chief.sentry.cookie'] = $this->app->share(function($app)
		{
			$key = $app['config']->get('chief::config.cookie.key');

			return new IlluminateCookie($app['request'], $app['cookie'], $key);
		});
	}

	/**
	 * Takes all the components of Sentry and glues them
	 * together to create Sentry.
	 *
	 * @return void
	 */
	protected function registerSentry()
	{
		$this->app['chief.sentry'] = $this->app->share(function($app)
		{
			return new Sentry(
				$app['chief.sentry.user'],
				$app['chief.sentry.group'],
				$app['chief.sentry.throttle'],
				$app['chief.sentry.session'],
				$app['chief.sentry.cookie'],
				$app['request']->getClientIp()
			);
		});
	}

}
