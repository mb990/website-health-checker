<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProjectUrl;
use App\Project;
use App\Frequency;
use Faker\Generator as Faker;

$factory->define(ProjectUrl::class, function (Faker $faker) {

    $projects = Project::all()->pluck('id')->toArray();

    $frequencies = Frequency::all()->pluck('id')->toArray();

    return [
        'url' => $faker->url,
        'check_frequency_id' => $faker->randomElement($frequencies),
        'project_id' => $faker->randomElement($projects),
    ];
});
