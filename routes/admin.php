<?php

// Profile
Route::get('/', 'ProfileController@index')->name('admin');
Route::resource('profiles', 'ProfileController');

// Restaurant
Route::resource('restaurants', 'RestaurantController');

// Consumable
Route::resource('consumables', 'ConsumableController');

// Order
Route::get('/{id}/orders', 'ProfileController@orders')->name('orders');
