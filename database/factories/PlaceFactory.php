<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Models\Places\Place::class, function (Faker $faker) {
    $title = $faker->sentence;
    return [
        'user_id' => rand(1, 3),
        'name' => $title,
        'views' => rand(1000, 10000),
        'like' => rand(1000, 10000),
        'slug' => Str::slug($title, '-'),
        'content' => $faker->text(1000),
        'excerpt' => $faker->text(200),
        'status' => rand(0, 1)
    ];
});
