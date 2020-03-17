<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use App\User;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    $users = User::all()->pluck('id')->toArray();

    return [
        'user_id' => $faker->randomElement($users),
        'name' => $faker->name,

    ];
});
