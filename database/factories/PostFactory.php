<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'content' => 'yo que se',
        'user_id' => factory(\App\User::class),
    ];
});
