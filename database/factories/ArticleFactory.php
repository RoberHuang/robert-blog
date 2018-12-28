<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Admin\Article::class, function (Faker $faker) {
    $images = ['uploads/about-bg.jpg', 'uploads/contact-bg.jpg', 'uploads/home-bg.jpg', 'uploads/post-bg.jpg'];
    $title = $faker->sentence(mt_rand(3, 10));
    return [
        'article_title' => $title,
        'subtitle' => str_limit($faker->sentence(mt_rand(10, 20)), 252),
        'article_thumb' => $images[mt_rand(0, 3)],
        'cate_id' => 18,
        'article_keywords' => $faker->word,
        'article_description' => "Meta for $title",
        'article_content' => join("\n\n", $faker->paragraphs(mt_rand(3, 6))),
        'article_author' => $faker->name,
        'published_at' => $faker->dateTimeBetween('-1 month', '+3 days'),
        'is_draft' => false,
    ];
});
