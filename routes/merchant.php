<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::get('/', 'Merchant\MerchantController@dashboard')->name('index');
Route::get('/dashboard', 'Merchant\MerchantController@dashboard')->name('dashboard');
Route::post('/dashboard', 'Merchant\MerchantController@dashboard')->name('dashboard');
Route::get('profile', 'Merchant\MerchantController@profile')->name('profile');
Route::get('edit-profile', 'Merchant\MerchantController@edit_profile')->name('edit.profile');
Route::post('profile', 'Merchant\MerchantController@profile_update')->name('profile.update');
Route::get('change-password', 'Merchant\MerchantController@password')->name('change-password');
Route::post('change-password', 'Merchant\MerchantController@password_update')->name('password.update');

#shipment module 
Route::resource('shipment', 'Merchant\ShipmentController');
Route::group(['prefix' => 'shipments'], function () {
Route::get('upcoming', 'Merchant\ShipmentController@upcoming')->name('shipment.upcoming');
Route::get('tracking', 'Merchant\ShipmentController@track')->name('shipment.track');
Route::get('reports/{type}', 'Merchant\ReportController@index')->name('reports');
Route::get('earnings', 'Merchant\ReportController@my_earnings')->name('my_earnings');
Route::get('delivery-area-graph', 'Merchant\ReportController@delivery_graph')->name('graph');

Route::get('/cancel/{id}', 'Merchant\ShipmentController@cancel_shipment')->name('shipment.cancel');
Route::post('/cancel/{id}', 'Merchant\ShipmentController@cancel_shipment_admin')->name('shipment.cancel.post');

Route::get('request-for-pickup/{id}', 'Merchant\ShipmentController@request_for_pickup')->name('shipment.request-for-pickup');
Route::post('request-for-pickup', 'Merchant\ShipmentController@post_request_for_pickup')->name('request-for-pickup');

Route::get('import', 'Merchant\ShipmentController@shipmentImport')->name('shipment.import');
Route::post('import', 'Merchant\ShipmentController@shipmentImportPost')->name('shipment.import');

});

Route::put('shipment-update/{id}', 'Merchant\ShipmentController@shipmentUpdate')->name('shipment.update');
Route::get('/report-claim/{id}', 'Merchant\Resource\HelpController@report_claim')->name('shipment.report.claim');
Route::resource('help', 'Merchant\Resource\HelpController');


Route::get('earning-statement/{type}', 'Merchant\Resource\EarningController@merchant_earning_statement')->name('merchant_earning_statement');

Route::get('earning-statement/{type}/{merchant_id}', 'Merchant\Resource\EarningController@merchant_earning_statement');

Route::post('earning-statement/{type}', 'Merchant\Resource\EarningController@merchant_earning_statement');

Route::post('earning-statement/{type}/{merchant_id}', 'Merchant\Resource\EarningController@merchant_earning_statement');

Route::get('shipment-report/{type}', 'Merchant\Resource\EarningController@merchant_shipment_report')->name('merchant_shipment_report');

Route::get('shipment-report/{type}/{merchant_id}', 'Merchant\Resource\EarningController@merchant_shipment_report');

Route::post('shipment-report/{type}', 'Merchant\Resource\EarningController@merchant_shipment_report');

Route::post('shipment-report/{type}/{merchant_id}', 'Admin\Resource\EarningController@merchant_shipment_report');

Route::post('dashboard-filter', 'Merchant\MerchantController@dashboard_filter')->name('dashboard.filter');

Route::get('payment-history', 'Merchant\Resource\EarningController@merchant_transaction')->name('payment-history');

Route::post('payment-history', 'Merchant\Resource\EarningController@merchant_transaction');

Route::post('withdraw-request', 'Merchant\Resource\EarningController@withdrawRequest')->name('withdraw-request');

Route::get('notifications', 'Merchant\Resource\EarningController@notifications')->name('notifications');

Route::get('notifications/detail/{id}', 'Merchant\Resource\EarningController@notificationDetail')->name('notification-detail');

Route::get('payment-history/{type}', 'Merchant\Resource\EarningController@merchant_transaction')->name('payment-history');

Route::post('payment-history/{type}', 'Merchant\Resource\EarningController@merchant_transaction')->name('payment-history');