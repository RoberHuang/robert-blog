<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Admin\Project::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
