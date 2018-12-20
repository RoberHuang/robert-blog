<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique()->comment('将文章标题转化为 URL 的一部分，以利于SEO');
            $table->string('article_title');
            $table->unsignedInteger('cate_id')->default(0);;
            $table->string('article_keywords', 128)->nullable();
            $table->string('article_description')->nullable();
            $table->string('article_thumb')->nullable();
            $table->text('article_content');
            $table->string('article_author', 64)->nullable();
            $table->unsignedInteger('article_frequency')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('articles');
    }
}
