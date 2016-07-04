<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/


$factory->defineAs(App\User::class, 'organization', function(Faker\Generator $faker) use ($factory){
    $user = $factory->raw(App\User::class);
    return array_merge( $user , ['type'=>'organization']);
});


$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Activity::class, function(Faker\Generator $faker){
	return [
		'title' => $faker->sentence,
		'description' => $faker->paragraph(6,false),
        'objectives' => $faker->paragraph(2),
		'vacancies' => rand(1,10),
        'type' => 'regular',
        'state' => 'accepted'
	];
});
