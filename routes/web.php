<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', 'Admin\Auth\LoginController@showLoginForm');

/*Route::get('phpmyinfo', function () {
    phpinfo(); 
})->name('phpmyinfo');*/

Route::get('/', 'Web\WebController@home');
Route::get('/privacy-policy', 'Web\WebController@privacyPolicy');
Route::get('/terms-of-use', 'Web\WebController@termsOfUse');

/*--disable register & login routes----*/
Auth::routes([
  'register' => false, // Registration Routes disable
  'login' => false, // Login  Routes disable
]);

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', 'Admin\Auth\LoginController@showLoginForm');
    Route::post('/login', 'Admin\Auth\LoginController@login');
    Route::post('/logout', 'Admin\Auth\LoginController@logout');
    Route::post('/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'Admin\Auth\ResetPasswordController@reset');
    Route::get('/password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
});

/*
|--------------------------------------------------------------------------
| Merchant Authentication Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'merchant'], function () {
    Route::get('/login', 'Merchant\Auth\LoginController@showLoginForm')->name('merchant.login');
    Route::post('/login', 'Merchant\Auth\LoginController@login');
    Route::post('/logout', 'Merchant\Auth\LoginController@logout');
    /*Route::post('/password/email', 'Merchant\Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'Merchant\Auth\ResetPasswordController@reset');
    Route::get('/password/reset/{token}', 'Merchant\Auth\ResetPasswordController@showResetForm')->name('merchant.password.reset');*/
    Route::post('/password/mobile/reset', 'Merchant\Auth\ForgotPasswordController@reset_password')->name('merchant.password.mobile.reset');
    Route::get('/password/reset', 'Merchant\Auth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/mobile/reset', 'Merchant\Auth\ForgotPasswordController@reset')->name('merchant.showReset');
    Route::post('/password/mobile', 'Merchant\Auth\ForgotPasswordController@forgot_otp');
});

/*
|--------------------------------------------------------------------------
| Hub Authentication Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'hub'], function () {
    Route::get('/login', 'Hub\Auth\LoginController@showLoginForm');
    Route::post('/login', 'Hub\Auth\LoginController@login');
    Route::post('/logout', 'Hub\Auth\LoginController@logout');
    Route::post('/password/email', 'Hub\Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'Hub\Auth\ResetPasswordController@reset');
    Route::get('/password/reset', 'Hub\Auth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'Hub\Auth\ResetPasswordController@showResetForm')->name('hub.password.reset');
});

/*
|--------------------------------------------------------------------------
| Seller Authentication Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'seller'], function () {
    Route::get('/login', 'Seller\Auth\LoginController@showLoginForm');
    Route::post('/login', 'Seller\Auth\LoginController@login');
    Route::post('/logout', 'Seller\Auth\LoginController@logout');
    Route::post('/password/email', 'Seller\Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'Seller\Auth\ResetPasswordController@reset');
    Route::get('/password/reset', 'Seller\Auth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'Seller\Auth\ResetPasswordController@showResetForm')->name('seller.password.reset');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/get-riders/{hub}', 'Admin\ShipmentController@get_rider')->name('hub.riders');
Route::get('/get-district/{division}', 'Admin\ShipmentController@get_district');
Route::get('/get-thana/{district}', 'Admin\ShipmentController@get_thana');


/*
| Route command using for development only
| Run simple php artisan command via url
*/
Route::get('command/{command}', function ($command) {    
    /* php artisan migrate */
    \Artisan::call($command);
    dd(Artisan::output());
});
Route::get('phpinfo', function () {    
   phpinfo();
});