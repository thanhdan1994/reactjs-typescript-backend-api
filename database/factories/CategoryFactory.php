<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Categories\Category;
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

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->unique()->randomElement([
        'Điện Thoại',
        'Đồng Hồ',
    ]);
    $slug = Str::slug($name, '-');
    return [
        'name' => $name,
        'slug' => $slug,
    ];
});
