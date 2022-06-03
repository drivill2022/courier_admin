<?php

/*
|--------------------------------------------------------------------------
| Seller Panel Routes
|--------------------------------------------------------------------------
*/
Route::get('/', 'Seller\SellerController@dashboard')->name('index');
Route::get('/dashboard', 'Seller\SellerController@dashboard')->name('dashboard');
Route::get('profile', 'Seller\SellerController@profile')->name('profile');
Route::get('edit-profile', 'Seller\SellerController@edit_profile')->name('edit.profile');
Route::post('profile', 'Seller\SellerController@profile_update')->name('profile.update');
Route::get('change-password', 'Seller\SellerController@password')->name('change-password');
Route::post('change-password', 'Seller\SellerController@password_update')->name('password.update');
Route::get('sub-category/{id}','Seller\ItemController@subcategory')->name('scat');
Route::resource('items','Seller\ItemController');


