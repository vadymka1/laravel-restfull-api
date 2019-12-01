<?php

use Faker\Generator as Faker;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
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

    $user = \App\Models\User::all()->random()->first();

    return [
        'name' => $faker->name,
        'user_id' => $user->id,
    ];
});
