<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// Homepage
Route::get('/', 'HomeController@index');

// Profiles
Route::resource('profile', 'ProfileController');

// Restaurants
Route::resource('restaurant', 'RestaurantController');
Route::post('search', 'RestaurantController@search')->name('search');

// Consumable routes
Route::resource('restaurant/{restaurant_id}/consumable', 'ConsumableController');