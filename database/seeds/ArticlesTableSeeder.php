<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Article;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::truncate();
        factory(Article::class, 20)->create();
    }
}
