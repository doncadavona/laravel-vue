<?php

use App\User;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'email'                => $faker->unique()->safeEmail,

        'username'             => $faker->unique()->userName,
        'first_name'           => $faker->firstName,
        'last_name'            => $faker->lastName,
        'address'              => $faker->address,
        'postcode'             => $faker->randomNumber(4),
        'contact_phone_number' => '09' . $faker->randomNumber(9),

        'email_verified_at'    => now(),
        'password'             => bcrypt('secret'),
        'remember_token'       => Str::random(10),
    ];
});
