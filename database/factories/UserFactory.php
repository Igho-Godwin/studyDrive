<?php

use Faker\Generator as Faker;

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



$factory->define(App\Models\Store::class, function (Faker $faker) {
    return [
            
        'itemName'=>'Rice',
        'qty'=> '1',
        'UnitPrice' => '2',
        'added_by' => '1',
    ];
});

$factory->define(App\Models\DrinkType::class, function (Faker $faker) {
    return [
            
        'drink_type'=>'Coke',
        'unit_price'=> '1000',
        'added_by' => '2',
        'picture' => 'pic.jpg'
                      
    ];
});

$factory->define(App\Models\SalesDrink::class, function (Faker $faker) {
    return [
            
        'item'=>'1',
        'price'=> '1000',
        'added_by' => '2',
        'qty' => '1',
        'mode_of_payment'=> '1'
                      
    ];
});

$factory->define(App\Models\PoolSales::class, function (Faker $faker) {
    return [
            
        'customer_name'=>'Avwerosuo Igho',
        'cost'=> '1000',
        'added_by' => '1'
    ];
});

$factory->define(App\Models\SellRooms::class, function (Faker $faker) {
    return [
            
        'customer_name'=>'English',
        'room_type'=> '1',
        'qty' => '2',
        'unit_price' => '2',
        'added_by' => '1',
    ];
});

$factory->define(App\Models\StoreCollections::class, function (Faker $faker) {
    return [
            
        'item_name'=>'1',
        'qty'=> '1',
        'unit_price' => '2',
        'user_id' => '2',
        'added_by' => '1',
    ];
});


$factory->define(App\Models\SalesRestuarant::class, function (Faker $faker) {
    return [
            
         
                     
                        'item'=>'1',
                        'price'=> '1000',
                        'added_by' => '2',
                        'qty' => '1',
                        'mode_of_payment'=> '1'
       
    ];
});


    
$factory->define(App\Models\Foodtype::class, function (Faker $faker) {
    return [
            
        'name'=>'Jolof Rice',
        'price'=> '1000',
        'added_by' => '2',
        'picture' => 'pic1.jpg'
                      
    ];
});

$factory->define(App\Models\RoomType::class, function (Faker $faker) {
    return [
            
        'name'=>'Rice',
        'qty'=> '1',
        'UnitPrice' => '2',
        'added_by' => '1',
    ];
});

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
            
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->email,
        'phone_no' => str_random(8),
        'dept' => 1,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        'remember_token' => str_random(10),
        'added_by' => '1'
    ];
});


$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});
