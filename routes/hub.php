<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::get('/', 'Hub\HubController@dashboard')->name('index');
Route::get('/dashboard', 'Hub\HubController@dashboard')->name('dashboard');
Route::get('profile', 'Hub\HubController@profile')->name('profile');
Route::get('edit-profile', 'Hub\HubController@edit_profile')->name('edit.profile');
Route::post('profile', 'Hub\HubController@profile_update')->name('profile.update');
Route::get('change-password', 'Hub\HubController@password')->name('change-password');
Route::post('change-password', 'Hub\HubController@password_update')->name('password.update');
Route::resource('riders','Hub\RiderController');
Route::get('reports/{type}', 'Hub\ReportController@index')->name('reports');
Route::get('earnings', 'Hub\ReportController@my_earnings')->name('my_earnings');
Route::get('delivery-area-graph', 'Hub\ReportController@delivery_graph')->name('graph');

#shipment module 
Route::group(['prefix' => 'shipments'], function () {
	Route::get('/upcoming', 'Hub\ShipmentController@upcoming')->name('shipments.upcoming');
	Route::get('/tracking', 'Hub\ShipmentController@track')->name('shipments.track');
	Route::get('/transfer/{id}', 'Hub\ShipmentController@transfer')->name('shipments.transfer');
	Route::get('/assign-rider/{id}', 'Hub\ShipmentController@assign_rider')->name('shipments.assign');
	Route::get('/cancel/{id}', 'Hub\ShipmentController@cancel_shipment')->name('shipments.cancel');
	Route::post('/cancel/{id}', 'Hub\ShipmentController@cancel_shipment_admin')->name('shipments.cancel.post');
});
Route::resource('shipments', 'Hub\ShipmentController');
Route::get('/report-claim/{id}', 'Hub\HelpController@report_claim')->name('shipments.report.claim');
Route::resource('help', 'Hub\HelpController');

Route::post('/dashboard-filter', 'Hub\HubController@dashboard_filter')->name('dashboard.filter');

Route::get('rider/earning-statement/{type}', 'Hub\Resource\EarningController@rider_earning_statement')->name('rider_earning_statement');

Route::get('rider/earning-statement/{type}/{rider_id}', 'Hub\Resource\EarningController@rider_earning_statement')->name('rider.earning.statement');

Route::post('rider/earning-statement/{type}', 'Hub\Resource\EarningController@rider_earning_statement');

Route::post('rider/earning-statement/{type}/{rider_id}', 'Hub\Resource\EarningController@rider_earning_statement');

Route::get('rider/shipment-report/{type}', 'Hub\Resource\EarningController@rider_shipment_report')->name('rider_shipment_report');

Route::get('rider/shipment-report/{type}/{rider_id}', 'Hub\Resource\EarningController@rider_shipment_report')->name('rider.shipment.report');

Route::post('rider/shipment-report/{type}', 'Hub\Resource\EarningController@rider_shipment_report');

Route::post('rider/shipment-report/{type}/{rider_id}', 'Hub\Resource\EarningController@rider_shipment_report');


Route::get('earning-statement/{type}', 'Hub\Resource\EarningController@hub_earning_statement')->name('hub_earning_statement');

Route::post('earning-statement/{type}', 'Hub\Resource\EarningController@hub_earning_statement');

Route::get('shipment-report/{type}', 'Hub\Resource\EarningController@hub_shipment_report')->name('hub_shipment_report');

Route::get('shipment-report/{type}/{rider_id}', 'Hub\Resource\EarningController@hub_shipment_report');

Route::post('shipment-report/{type}', 'Hub\Resource\EarningController@hub_shipment_report');

Route::post('shipment-report/{type}/{rider_id}', 'Hub\Resource\EarningController@hub_shipment_report');

Route::post('shipment-report/{type}/{rider_id}', 'Hub\Resource\EarningController@hub_shipment_report');

Route::post('deposit-amount', 'Hub\HubController@depositAmount')->name('deposit-amount');

Route::resource('delivery-charges', 'Hub\Resource\MerchantDeliveryChargeController');

Route::get('rider-deposit', 'Hub\Resource\EarningController@rider_deposit')->name('rider_deposit');

Route::get('rider-deposit/{rider_id}', 'Hub\Resource\EarningController@rider_deposit');

Route::post('/changeRiderDepositStatus' , 'Hub\Resource\EarningController@changeRiderDepositStatus');
