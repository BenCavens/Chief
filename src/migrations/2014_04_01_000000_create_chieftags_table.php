<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChieftagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chieftags', function(Blueprint $table) {
			
			$table->increments('id');
			$table->string('name');
			$table->string('slug');
			$table->boolean('cat')->default(0);
			
			$table->engine = 'InnoDB';
			$table->unique('slug');
		
		});

		Schema::create('chieftaggables', function(Blueprint $table) {
			
			$table->integer('tag_id')->unsigned();
			$table->integer('taggable_id')->unsigned();
			$table->string('taggable_type');
			
			$table->engine = 'InnoDB';
			$table->unique(array('tag_id','taggable_type','taggable_id'));
		
		});

		// Schema::create('chiefcategories', function(Blueprint $table) {
			
		// 	$table->increments('id');
		// 	$table->string('name');
		// 	$table->string('slug');
		// 	$table->tinyinteger('parent_id')->default(0);
			
		// 	$table->engine = 'InnoDB';
		// 	$table->unique('slug');
		
		// });

		// Schema::create('chiefcategorizables', function(Blueprint $table) {
			
		// 	$table->integer('category_id')->unsigned();
		// 	$table->integer('categorizable_id')->unsigned();
		// 	$table->string('categorizable_type');
			
		// 	$table->engine = 'InnoDB';
		// 	$table->unique(array('category_id','categorizable_type','categorizable_id'));
		
		// });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('chieftags');
		Schema::drop('chieftaggables');
		// Schema::drop('chiefcategories');
		// Schema::drop('chiefcategorizables');
	}

}
