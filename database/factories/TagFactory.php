<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Admin\Tag::class, function (Faker $faker) {
    $images = ['uploads/about-bg.jpg', 'uploads/contact-bg.jpg', 'uploads/home-bg.jpg', 'uploads/post-bg.jpg'];
    $word = $faker->word;
    return [
        'tag' => $word,
        'title' => ucfirst($word),
        'subtitle' => $faker->sentence,
        'page_image' => $images[mt_rand(0, 3)],
        'meta_description' => "Meta for $word",
        'reverse_direction' => false,
    ];
});
