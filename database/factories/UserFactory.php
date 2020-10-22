<?php

/** @var Factory $factory */

use App\Models\User;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Models\Subject;
use App\Models\Item;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'governorate_id' => 1,
    ];
});



//$factory->define(Item::class, function (Faker $faker) {
//    return [
//        'name' => $faker->name,
//        'type' => 'BOOK',
//        'course_id' => 1,
//        'course_session_id' => 1,
//        'description' => $faker->text,
//    ];
//});
