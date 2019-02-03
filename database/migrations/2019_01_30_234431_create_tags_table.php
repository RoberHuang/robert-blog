<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTagsTable.
 */
class CreateTagsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tags', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('title')->default('');
            $table->string('page_image')->default('')->comment('标签图片');
            $table->string('description')->default('')->comment('标签介绍');
            $table->boolean('reverse_direction')->comment('在文章列表按时间升序排列博客文章（默认是降序）');
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tags');
	}
}
