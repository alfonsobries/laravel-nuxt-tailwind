<?php

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'role' => User::roleOptions()->random(),
        'remember_token' => str_random(10),
    ];
});

$factory->state(User::class, 'root', [
    'role' => User::ROLE_ROOT,
]);

$factory->state(User::class, 'admin', [
    'role' => User::ROLE_ADMIN,
]);

$factory->state(User::class, 'store', function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => 'secret',
        'role' => User::roleOptions()->random(),
        'remember_token' => null
    ];
});

