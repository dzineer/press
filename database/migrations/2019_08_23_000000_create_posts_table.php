<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreatePostsTable
 */
class CreatePostsTable extends Migration {

	/**
	 * Migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('posts', function(Blueprint $table) {
			$table->increments('id');
			$table->string('identifier')->index();
			$table->string('slug')->unique()->index();
			$table->text('title');
			$table->text('body');
			$table->text('extra');
			$table->timestamps();

			$table->index('created_at');
			$table->index('updated_at');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('posts');
	}

}