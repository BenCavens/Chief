<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChiefusersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chiefusers', function($table)
		{
			$table->increments('id');
			$table->string('email');
			$table->string('password');
			$table->text('permissions')->nullable();
			$table->boolean('activated')->default(0);
			$table->string('activation_code')->nullable();
			$table->timestamp('activated_at')->nullable();
			$table->timestamp('last_login')->nullable();
			$table->string('persist_code')->nullable();
			$table->string('reset_password_code')->nullable();
			
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('slug');
			$table->text('description')->default('');
			$table->string('avatar');

			$table->timestamps();

			$table->engine = 'InnoDB';
			$table->unique('email');
			$table->unique('slug');
			$table->index('activation_code');
			$table->index('reset_password_code');
		});

		Schema::create('chiefauthors', function($table)
		{
			$table->integer('post_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->tinyinteger('order')->default(0);

			$table->engine = 'InnoDB';
			$table->primary(array('post_id','user_id'));
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('chiefusers');
	}

}
