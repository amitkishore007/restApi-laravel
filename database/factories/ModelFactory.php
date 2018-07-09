<?php

use App\User;
use App\Seller;
use App\Product;
use App\Category;
use App\Transaction;

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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'verified'=>$verified = $faker->randomElement([User::UNVERIFIED_USER, User::VERIFIED_USER]),
        'verification_token'=> $verified ? null : User::generateVerificationToken(),
        'admin'=>$faker->randomElement([User::REGULAR_USER, User::ADMIN_USER])
    ];
});

/**
 * category Factory
 */
$factory->define(Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description'=> $faker->paragraph(1)
    ];
});

/**
 * Product Factory
 */
$factory->define(Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description'=> $faker->paragraph(1),
        'quantity'=>$faker->numberBetween(1,10),
        'image'=>$faker->randomElement(['p1.png','p3.png','p6.png']),
        'status'=>$faker->randomElement([Product::PRODUCT_AVAILABLE, Product::PRODUCT_UNAVAILABLE]),
        'seller_id'=> User::all()->random()->id
    ];
});

/**
 * Transaction Factory
 */
$factory->define(Transaction::class, function (Faker\Generator $faker) {

	$seller = Seller::has('products')->get()->random();
	$buyer = User::all()->except($seller->id)->random();
    return [
        'quantity'=>$faker->numberBetween(1,3),
        'buyer_id'=> $buyer->id,
        'product_id'=>Product::all()->random()->id
    ];
});
