<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProjectUrl;
use App\Project;
use Faker\Generator as Faker;

$factory->define(ProjectUrl::class, function (Faker $faker) {

    $projects = Project::all()->pluck('id')->toArray();

    return [
        'url' => $faker->url,
        'project_id' => $faker->randomElement($projects),
    ];
});
