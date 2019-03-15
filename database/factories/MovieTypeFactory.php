<?php

use App\Movie;
use App\Type;
use App\MovieType;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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

$factory->define(MovieType::class, function (Faker $faker) {
    return [
        'movie_id' => App\Movie::all()->random()->id,
        'type_id' => App\Type::all()->random()->id,

    ];
});
