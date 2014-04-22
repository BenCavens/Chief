<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChiefcommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chiefcomments', function(Blueprint $table) {
			
			$table->increments('id');
			$table->integer('post_id')->unsigned();
			$table->text('content');
			$table->integer('parent_id')->nullable();
			$table->enum('status',array('pending','approved','denied'))->default('pending');
			
			$table->string('username')->nullable();
			$table->string('email')->nullable();
			$table->integer('user_id')->nullable();
			
			$table->timestamps();

			$table->engine = 'InnoDB';
			$table->index(array('post_id','status'));
		
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('chiefcomments');
	}

}
