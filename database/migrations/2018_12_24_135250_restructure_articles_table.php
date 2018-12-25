<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RestructureArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('subtitle')->after('article_title')->default('');
            $table->text('content_html')->after('article_content')->comment('使用 Markdown 编辑内容但同时保存 HTML 版本');
            $table->boolean('is_draft')->after('content_html')->default(false)->comment('该文章是否是草稿');
            $table->string('layout')->after('is_draft')->default('blog.layouts.article')->comment('使用的布局');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('layout');
            $table->dropColumn('is_draft');
            $table->dropColumn('content_html');
            $table->dropColumn('subtitle');
        });
    }
}
