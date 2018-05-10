<?php

use Faker\Generator as 	Faker;

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
// use App\DB;

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Item::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'price' => $faker->randomFloat(2,1,100),
        'description' => $faker->word
    ];
});

$factory->define(App\Box::class, function (Faker $faker) {
    $itemID = App\Item::all()->pluck('id')->toArray();

    return [
        'item_id' => $faker->randomElement($itemID),
        'name' => $faker->name,
        'weight' => $faker->randomFloat(2,1,100)
    ];
});
