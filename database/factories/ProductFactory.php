<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Products\Product;
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

$factory->define(Product::class, function (Faker $faker) {
    $name = $faker->sentence;
    return [
        'name' => $name,
        'category_id' => rand(1, 2),
        'brand_id' => rand(1, 5),
        'slug' => Str::slug($name, '-'),
        'views' => rand(1000, 10000),
        'like' => rand(1000, 10000),
        'parameters' => [
            ['key' => 'Màn hình', 'value' => '27inch'],
            ['key' => 'Công suất', 'value' => '24/24'],
        ],
        'amount' => rand(50000, 1000000),
        'content' => $faker->text(1000),
        'excerpt' => $faker->text(200),
        'status' => rand(0, 1)
    ];
});
