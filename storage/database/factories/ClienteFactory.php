<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Models\Encargado;
use Faker\Generator as Faker;

$factory->define(Encargado::class, function (Faker $faker) {
    return [
        'numero_celular' => $faker->e164PhoneNumber(),
        'nombre_encargado' => $faker->text($maxNbChars = 20),
        'email' => $faker->email(),
        'direccion' => $faker->streetAddress(),
        'numero_serial' => '12345',
    ];
});
