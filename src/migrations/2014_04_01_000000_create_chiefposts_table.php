<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChiefpostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chiefposts', function(Blueprint $table) {
			
			$table->increments('id');
			$table->string('title');
			$table->string('subtitle')->nullable();
			$table->string('slug');
			$table->text('content');
			$table->enum('status',array('draft','published','archived'))->default('draft');
			$table->boolean('allow_comments')->default(1);

			/* Versioning */
			$table->integer('parent_id')->unsigned()->default(0);
			
			$table->mediuminteger('comment_count')->unsigned()->default(0);
			
			$table->integer('image_id')->unsigned()->nullable(); /* Main image for article */
			$table->mediuminteger('views')->unsigned()->default(0);

			$table->timestamps();
			$table->softDeletes();
			$table->datetime('published_at')->nullable();

			$table->engine = 'InnoDB';
			$table->unique('slug');
			$table->index(array('status','parent_id'));
		
		});

		Schema::create('chiefposttypes', function(Blueprint $table) {
			
			$table->increments('id');
			$table->string('name');
			$table->string('slug');
			$table->boolean('allow_comments')->default(0);
			$table->engine = 'InnoDB';
			$table->unique('slug');
		
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('chiefposts');
		Schema::drop('chiefposttypes');
	}

}
