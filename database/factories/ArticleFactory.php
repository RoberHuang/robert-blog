<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    $title = $faker->sentence(mt_rand(3, 10));
    return [
        'slug' => str_slug($title),
        'article_title' => $title,
        'cate_id' => 18,
        'article_keywords' => $faker->word,
        'article_description' => $faker->word,
        'article_content' => join("\n\n", $faker->paragraphs(mt_rand(3, 6))),
        'article_author' => $faker->name,
        'published_at' => date('Y-m-d'),
    ];
});
