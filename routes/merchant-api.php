<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/check-mobile' , 'Api\MerchantApiController@verify');
Route::post('/send-otp' , 'Api\MerchantApiController@send_otp');
Route::post('/signup' , 'Api\MerchantApiController@register');
Route::post('/login' , 'Api\MerchantApiController@login');
Route::post('/forgot/password','Api\MerchantApiController@forgot_password');
Route::post('/reset/password','Api\MerchantApiController@reset_password');

Route::get('/signup-data','Api\MerchantApiController@signup_data');
Route::post('/refresh-token','Api\MerchantApiController@refresh_token');

Route::get('/divisions','Api\ShipmentApiController@divisions');
Route::get('/district/{id}','Api\ShipmentApiController@district');
Route::get('/thana/{id}','Api\ShipmentApiController@thana');

Route::get('/supports' , 'Api\RiderApiController@supports');
Route::get('/sendnotification' , 'Api\ShipmentApiController@sendNotificaton');

#authenticated merchant routes here 
/*
| Route::group( ['prefix' => '/','middleware' => ['auth:riderapi','scopes:rider'] ]
*/
Route::group( ['prefix' => '/','middleware' => ['auth:merchantapi','scopes:merchant'] ],function(){
   Route::get('/', function () {return $request->user();});
   Route::post('/change-password' , 'Api\MerchantApiController@password_change');
   Route::get('profile', "Api\MerchantApiController@profile");
   Route::post('/profile/update' , 'Api\MerchantApiController@update');
   Route::get('/logout' , 'Api\MerchantApiController@logout');
   Route::get('/banner-list' , 'Api\MerchantApiController@bannerList');

   Route::group( ['prefix' => 'shipments'],function(){
      Route::get('/','Api\ShipmentApiController@index');
      Route::post('create','Api\ShipmentApiController@create');
      Route::post('cancel','Api\ShipmentApiController@cancel');
      Route::get('detail/{id}','Api\ShipmentApiController@detail');
      Route::post('tracking','Api\ShipmentApiController@shipment_track');
      Route::post('send-to-pickup','Api\ShipmentApiController@request_pickup');
      Route::get('nearest-hubs','Api\ShipmentApiController@nearest_hubs');
      Route::post('cancel-reason-list','Api\ShipmentApiController@cancel_reasons');
      Route::get('/payment-history' , 'Api\ShipmentApiController@paymentHistory');
      Route::get('/shipping-history' , 'Api\ShipmentApiController@shippingHistory');
      Route::get('/earn-pay' , 'Api\ShipmentApiController@earnPay');
      Route::post('/shipping-database' , 'Api\ShipmentApiController@shippingDatabase');
      Route::post('/payment-breakdown' , 'Api\ShipmentApiController@paymentbreakdown');
      Route::get('/withdraw-request' , 'Api\ShipmentApiController@withdrawRequest');
      Route::post('/complain' , 'Api\ShipmentApiController@complain');
      Route::get('/weight-product-list' , 'Api\ShipmentApiController@weightProductList');
      Route::get('/notification-list' , 'Api\ShipmentApiController@notificationList');
      Route::get('/notification-read/{notification_id}' , 'Api\ShipmentApiController@notificationRead');
      Route::get('/payment-view-detail/{txn_id}' , 'Api\ShipmentApiController@productViewDetail');
      Route::get('/view-invoice/{id}' , 'Api\ShipmentApiController@viewInVoice');
      Route::post('/account' , 'Api\ShipmentApiController@account');
   });
});  
