<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Layout;
use App\Models\Provider;
use Faker\Generator as Faker;

$factory->define(Layout::class, function (Faker $faker) {
    return [
        'provider_id' => function () {
            return factory(Provider::class)->create()->id;
        },
        'name' => $faker->company,
        'slug' => str_slug($faker->company),
    ];
});
