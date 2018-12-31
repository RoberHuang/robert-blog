<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Goods::class, function (Faker $faker) {
    return [
        'subject' => $faker->word,
        'image' => $faker->imageUrl(300, 360),
    ];
});
