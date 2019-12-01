<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
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

    $user = \App\Models\User::all()->random()->first();

    return [
        'name' => $faker->name,
        'description' => $faker->text(100),
        'user_id' => $user->id,
    ];
});