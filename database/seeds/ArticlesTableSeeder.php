<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Article;
use App\Models\Admin\Tag;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::all()->pluck('id')->all();

        Article::truncate();
        DB::table('article_tag_pivot')->truncate();

        factory(Article::class, 20)->create()->each(function ($article) use ($tags) {
            // 30% of the time don't assign a tag
            if (mt_rand(1, 100) <= 30) {
                return;
            }

            shuffle($tags); // 把数组中的元素按随机顺序重新排序
            $articleTags = [$tags[0]];

            if (mt_rand(1, 100) <= 30) {
                $articleTags[] = $tags[1];
            }

            $article->syncTags($articleTags);
        });
    }
}
