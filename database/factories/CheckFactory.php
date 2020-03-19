<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Check;
use App\ProjectUrl;
use Faker\Generator as Faker;

$factory->define(Check::class, function (Faker $faker) {

    $urls = ProjectUrl::all()->pluck('id')->toArray();
    $codes = [200, 300, 401, 402, 403, 404, 500];

    return [
        'url_id' => $faker->randomElement($urls),
        'response_code' => $faker->randomElement($codes),
        'response_time' => rand(1, 50) / 10,
    ];
});
