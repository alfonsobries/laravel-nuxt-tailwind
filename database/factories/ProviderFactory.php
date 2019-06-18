<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Company;
use App\Models\Provider;
use Faker\Generator as Faker;

$factory->define(Provider::class, function (Faker $faker) {
    return [
        'company_id' => function () {
            return factory(Company::class)->create()->id;
        },
        'name' => $faker->company,
        'slug' => str_slug($faker->company, '_'),
    ];
});
