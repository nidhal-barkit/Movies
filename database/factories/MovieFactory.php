<?php

use App\Movie;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
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

$factory->define(Movie::class, function (Faker $faker) {
    $date =  new \DateTime();
    return [
        'title' => $faker->name,
        'image' => '/images/'.uniqid().'?v='.$date->getTimestamp(),
        'year' => $faker->year,
        'user_id' => App\User::all()->random()->id,
        'published' => '0',

    ];
});
