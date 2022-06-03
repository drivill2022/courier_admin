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
Route::post('/check-mobile' , 'Api\RiderApiController@verify');
Route::post('/send-otp' , 'Api\RiderApiController@send_otp');
Route::post('/register' , 'Api\RiderApiController@register');
Route::post('/login' , 'Api\RiderApiController@login');
Route::post('/forgot/password','Api\RiderApiController@forgot_password');
Route::post('/reset/password','Api\RiderApiController@reset_password');

Route::post('/page-content','Api\RiderApiController@get_page_content');
Route::get('/vehicle-data','Api\RiderApiController@vehicle_data');
Route::get('/hubs','Api\RiderApiController@hubs');
Route::post('/refresh-token','Api\RiderApiController@refresh_token');

Route::post('/sms-send' , 'Api\RiderApiController@sms_send');
Route::get('/supports' , 'Api\RiderApiController@supports');

 Route::get('/shipment-list' , 'Api\RiderShipmentController@ship_list');

#authenticated rider routes here 
/*
| Route::group( ['prefix' => '/','middleware' => ['auth:riderapi','scopes:rider'] ]
*/
Route::group( ['prefix' => '/','middleware' => ['auth:riderapi','scopes:rider'] ],function(){
   Route::get('/', function () {return $request->user();});
   Route::post('/change-password' , 'Api\RiderApiController@password_change');
   Route::get('profile', "Api\RiderApiController@profile");
   Route::post('/profile/update' , 'Api\RiderApiController@update');
   Route::get('/logout' , 'Api\RiderApiController@logout');

   Route::group( ['prefix' => 'shipments'],function(){
      Route::get('/' , 'Api\RiderShipmentController@index');
      Route::get('/detail/{id}' , 'Api\RiderShipmentController@detail');
      Route::post('/status-update' , 'Api\RiderShipmentController@status_update');
      Route::post('/send-otp' , 'Api\ShipmentApiController@shipment_otp');
      Route::post('/cancel-reason-list','Api\RiderShipmentController@cancel_reasons');
      Route::post('/cancel','Api\RiderShipmentController@cancel');
      Route::post('/riding-statement' , 'Api\RiderShipmentController@ridingStatement');
      Route::get('/payment-history' , 'Api\RiderShipmentController@paymentHistory');
      Route::get('/cod-statement' , 'Api\RiderShipmentController@codStatement');
      Route::post('/deposit-amount' , 'Api\RiderShipmentController@depositAmount');
      Route::post('/add-current-location' , 'Api\RiderShipmentController@addCurrentLocation');
      Route::post('/find-nearest-rider' , 'Api\RiderShipmentController@findNearestRider');
      Route::post('/find-nearest-hub' , 'Api\RiderShipmentController@findNearestHub');
      Route::post('/transfer-to-rider' , 'Api\RiderShipmentController@transfer_to_rider');
      Route::post('/transfer-to-hub' , 'Api\RiderShipmentController@transfer_to_hub');
      Route::get('/notification-list' , 'Api\RiderShipmentController@notificationList');
      Route::get('/notification-read/{notification_id}' , 'Api\RiderShipmentController@notificationRead');
   });
});  
