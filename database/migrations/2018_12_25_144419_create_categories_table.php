<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cate_name', 128)->unique();
            $table->string('cate_title')->default('');
            $table->string('cate_keywords')->default('');
            $table->string('cate_description')->default('');
            $table->unsignedInteger('cate_frequency')->default(0);
            $table->unsignedTinyInteger('cate_order')->default(0);
            $table->unsignedInteger('cate_pid')->default(0);
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
        Schema::dropIfExists('categories');
    }
}
