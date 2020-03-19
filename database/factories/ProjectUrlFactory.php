<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProjectUrl;
use App\Project;
use Faker\Generator as Faker;

$factory->define(ProjectUrl::class, function (Faker $faker) {

    $projects = Project::all()->pluck('id')->toArray();

    $frequencies = [60, 300, 900, 1800, 3600, 43200, 86400];

    return [
        'url' => $faker->url,
        'check_frequency' => $faker->randomElement($frequencies),
        'project_id' => $faker->randomElement($projects),
    ];
});
