<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Column;
use App\Models\Layout;
use Faker\Generator as Faker;

$factory->define(Column::class, function (Faker $faker) {
    return [
        'layout_id' => function () {
            return factory(Layout::class)->create();
        },
        'name' => $faker->sentence(2),
        'slug' => str_slug($faker->sentence(2), '_'),
        'type' => Column::typeOptions()->random(),
        'when_duplicated' => Column::actionOptions()->random(),
        'required' => $faker->boolean,
        'published_at' => $faker->optional()->dateTime,
    ];
});

$factory->state(Column::class, 'published', function ($faker) {
    return [
        'published_at' => $faker->dateTime,
    ];
});

$factory->state(Column::class, 'required', [
    'required' => true,
]);
