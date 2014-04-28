<?php

class ErrorManagerTest extends TestCase {

	
	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testInstance()
	{
		$errorManager = App::make('Bencavens\Chief\Services\ErrorManager');	
	}

	/**
	 * Reach Chief PostRepository
	 *
	 * @return void
	 */
	public function testManagerAsSingleton()
	{
		$errorManager = App::make('Bencavens\Chief\Services\ErrorManager');

		$errorManager->add('test');

		$errorManager2 = App::make('Bencavens\Chief\Services\ErrorManager');

		$this->assertTrue($errorManager2->hasAny());
		$this->assertTrue($errorManager2->first() == 'test');

		$errorManager2->add('second');

		$this->assertTrue($errorManager->hasAny());
		$this->assertTrue($errorManager->first() == 'test');
		$this->assertTrue(count($errorManager->get()) == 2);

		$errors = $errorManager->get();
		$this->assertTrue($errors[1] == 'second');
	
	}

	/**
	 * Translation
	 *
	 * @return void
	 */
	public function testManagerTranslationknown()
	{
		$errorManager = App::make('Bencavens\Chief\Services\ErrorManager');
		$errorManager->forget();

		$errorManager->trans('errors.posts.title.required');

		$this->assertTrue($errorManager->hasAny());
		$this->assertTrue($errorManager->first() == "Title is required");
		
	}

	/**
	 * Translation
	 *
	 * @return void
	 */
	public function testManagerTranslationUnknown()
	{
		$errorManager = App::make('Bencavens\Chief\Services\ErrorManager');
		$errorManager->forget();

		$errorManager->trans('test.test');

		$this->assertTrue($errorManager->hasAny());
		$this->assertTrue($errorManager->first() == 'chief::test.test');
		
	}




}