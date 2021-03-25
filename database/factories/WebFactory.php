<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Illuminate\Support\Str;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;

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

$factory->define(Web::class, function (Faker $faker) {
    return [
        'name' => $faker->word, // internal
        'title' => $faker->word,
        'url' => sprintf('https://%s/', $faker->domainName),
        'domain' => $faker->domainName,
    ];
});
