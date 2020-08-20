<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SearchField;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(SearchField::class, function (Faker $faker) {
    return [
        'sequence'=> $faker->unique()->numberBetween(0,3),
        'documentID'=>$faker->unique()->randomElement(['place1', 'place2']),
        'placeID'=>Str::random(10),
        'name'=>$faker->address,
        'lat'=>$faker->randomFloat(),
        'lng'=>$faker->randomFloat()
    ];
});
