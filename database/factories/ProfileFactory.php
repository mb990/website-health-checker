<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Profile;
use App\User;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {

    $users = User::all()->pluck('id')->toArray();

    return [
        'image_url' => $faker->imageUrl(),
        'user_id' => $faker->unique()->randomElement($users)
    ];
});
