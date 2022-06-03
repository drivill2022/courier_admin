<?php

/*
|-------------------------------------------------------------
| Admin Routes
|-------------------------------------------------------------
*/
Route::get('/', 'Admin\AdminController@dashboard')->name('index');
/*Route::get('/dashboard/{type}', 'Admin\AdminController@dashboard')->name('dashboard');
Route::post('/dashboard/{type}', 'Admin\AdminController@dashboard')->name('dashboard.filter');*/
Route::get('/dashboard', 'Admin\AdminController@dashboard')->name('dashboard');
Route::post('/dashboard', 'Admin\AdminController@dashboard')->name('dashboard');
Route::get('/map', 'Admin\AdminController@map_index')->name('map');
Route::get('/rider-of-hub/{hub_id}', 'Admin\AdminController@getRiderByHub')->name('riderofhub');
Route::get('profile', 'Admin\AdminController@profile')->name('profile');
Route::get('edit-profile', 'Admin\AdminController@edit_profile')->name('edit.profile');
Route::post('profile', 'Admin\AdminController@profile_update')->name('profile.update');
Route::get('change-password', 'Admin\AdminController@password')->name('change-password');
Route::post('change-password', 'Admin\AdminController@password_update')->name('password.update');
Route::resource('roles', 'Admin\Resource\RoleController');
Route::resource('permissions', 'Admin\Resource\PermissionController');
Route::resource('sub-admins', 'Admin\Resource\AdminUser');
Route::resource('merchants', 'Admin\Resource\MerchantController');
Route::resource('hubs', 'Admin\Resource\HubController');
Route::resource('riders', 'Admin\Resource\DeliveryRiderController');
Route::resource('earnings', 'Admin\Resource\EarningController');
Route::resource('delivery-charges', 'Admin\Resource\MerchantDeliveryChargeController');

#vehicle route
Route::group(['prefix' => 'vehicle','as' => 'vehicle.'], function () {
Route::resource('brands', 'Admin\Resource\VehicleBrandController');
Route::resource('models', 'Admin\Resource\VehicleModelController');
Route::resource('regions', 'Admin\Resource\VehicleRegionController');
Route::resource('categories', 'Admin\Resource\VehicleCategoryController');
});

#sellers route
Route::group(['prefix' => 'sellers','as' => 'sellers.'], function () {
Route::resource('categories', 'Admin\Resource\ItemCategoryController');
Route::resource('{seller}/items', 'Admin\Resource\ItemController');
});
Route::resource('sellers', 'Admin\Resource\SellerController');
Route::resource('product-types', 'Admin\Resource\ProductTypeController');
#shipment module 
Route::group(['prefix' => 'shipments'], function () {
	Route::get('/upcoming', 'Admin\ShipmentController@upcoming')->name('shipments.upcoming');
	Route::get('/tracking', 'Admin\ShipmentController@track')->name('shipments.track');
	Route::get('/transfer/{id}', 'Admin\ShipmentController@transfer')->name('shipments.transfer');
	Route::post('/transfer/{id}', 'Admin\ShipmentController@shipment_transfer')->name('shipments.transfer.post');
	Route::get('/assign-rider/{id}', 'Admin\ShipmentController@assign_rider')->name('shipments.assign');
	Route::get('/cancel/{id}', 'Admin\ShipmentController@cancel_shipment')->name('shipments.cancel');
	Route::post('/cancel/{id}', 'Admin\ShipmentController@cancel_shipment_admin')->name('shipments.cancel.post');
	Route::get('edit-info/{id}', 'Admin\ShipmentController@editInfo')->name('edit-info');
	Route::post('update-info/{id}', 'Admin\ShipmentController@updateInfo')->name('shipment.info.update');
	Route::get('import', 'Admin\ShipmentController@shipmentImport')->name('shipment.import');
	Route::post('import', 'Admin\ShipmentController@shipmentImportPost')->name('shipment.import');
});
Route::resource('shipments', 'Admin\ShipmentController');
Route::get('shipment/{id}', 'Admin\ShipmentController@index')->name('shipment.index');
Route::get('shipment', 'Admin\ShipmentController@index')->name('shipment.index');
Route::resource('reasons', 'Admin\Resource\ReasonController');
Route::resource('settings', 'Admin\Resource\SettingController');
//Route::get('reports/{type}', 'Admin\Resource\ReportController@index')->name('reports');
Route::resource('pages', 'Admin\Resource\PagesController');
Route::resource('services', 'Admin\Resource\ServiceController');
Route::resource('customers', 'Admin\Resource\CustomerController');
Route::resource('settlements', 'Admin\Resource\SettlementController');
Route::get('earnings-payout-section', 'Admin\Resource\EarningController@payout_section')->name('payout');
Route::post('rider-earnings', 'Admin\Resource\EarningController@rider_earnings')->name('rider-earnings');

Route::get('/getMerchantRemAmt/{merchant_id}' , 'Admin\Resource\EarningController@getMerchantRemAmt');
Route::get('/getRiderRemAmt/{rider_id}' , 'Admin\Resource\EarningController@getRiderRemAmt');

Route::get('merchant-payment', 'Admin\Resource\EarningController@merchant_payment')->name('merchant_payment');
Route::get('merchant-payment/{merchant_id}', 'Admin\Resource\EarningController@merchant_payment');

Route::get('merchant-transaction', 'Admin\Resource\EarningController@merchant_transaction')->name('merchant_transaction');
Route::get('merchant-transaction/{type}', 'Admin\Resource\EarningController@merchant_transaction')->name('merchant_transaction');
Route::post('merchant-transaction', 'Admin\Resource\EarningController@merchant_transaction')->name('merchant_transaction');
Route::post('merchant-transaction/{type}', 'Admin\Resource\EarningController@merchant_transaction')->name('merchant_transaction');
Route::get('merchant-transaction/{type}/{merchant_id}', 'Admin\Resource\EarningController@merchant_transaction')->name('merchant_transaction');
Route::post('merchant-transaction/{type}/{merchant_id}', 'Admin\Resource\EarningController@merchant_transaction')->name('merchant_transaction');

Route::get('rider-payment', 'Admin\Resource\EarningController@rider_payment')->name('rider_payment');

Route::get('rider-transaction', 'Admin\Resource\EarningController@rider_transaction')->name('rider_transaction');

/*Route::get('rider-deposit/{type}', 'Admin\Resource\EarningController@rider_deposit')->name('rider_deposit');

Route::post('rider-deposit/{type}', 'Admin\Resource\EarningController@rider_deposit');*/

Route::get('rider/earning-statement/{type}', 'Admin\Resource\EarningController@rider_earning_statement')->name('rider_earning_statement');

Route::get('rider/earning-statement/{type}/{rider_id}', 'Admin\Resource\EarningController@rider_earning_statement');

Route::post('rider/earning-statement/{type}', 'Admin\Resource\EarningController@rider_earning_statement');

Route::post('rider/earning-statement/{type}/{rider_id}', 'Admin\Resource\EarningController@rider_earning_statement');

Route::get('rider/shipment-report/{type}', 'Admin\Resource\EarningController@rider_shipment_report')->name('rider_shipment_report');

Route::get('rider/shipment-report/{type}/{rider_id}', 'Admin\Resource\EarningController@rider_shipment_report');

Route::post('rider/shipment-report/{type}', 'Admin\Resource\EarningController@rider_shipment_report');

Route::post('rider/shipment-report/{type}/{rider_id}', 'Admin\Resource\EarningController@rider_shipment_report');

Route::post('/changeRiderDepositStatus' , 'Admin\Resource\EarningController@changeRiderDepositStatus');

Route::get('merchant/earning-statement/{type}', 'Admin\Resource\EarningController@merchant_earning_statement')->name('merchant_earning_statement');

Route::get('merchant/earning-statement/{type}/{merchant_id}', 'Admin\Resource\EarningController@merchant_earning_statement');

Route::post('merchant/earning-statement/{type}', 'Admin\Resource\EarningController@merchant_earning_statement');

Route::post('merchant/earning-statement/{type}/{merchant_id}', 'Admin\Resource\EarningController@merchant_earning_statement');

Route::get('merchant/shipment-report/{type}', 'Admin\Resource\EarningController@merchant_shipment_report')->name('merchant_shipment_report');

Route::get('merchant/shipment-report/{type}/{merchant_id}', 'Admin\Resource\EarningController@merchant_shipment_report');

Route::post('merchant/shipment-report/{type}', 'Admin\Resource\EarningController@merchant_shipment_report');

Route::post('merchant/shipment-report/{type}/{merchant_id}', 'Admin\Resource\EarningController@merchant_shipment_report');

Route::get('merchant/withdraw-request', 'Admin\Resource\EarningController@withdraw_request')->name('withdraw_request');

Route::put('shipment-update/{id}', 'Admin\ShipmentController@shipmentUpdate')->name('shipment.update');

Route::get('/transfer-to-hub/{id}', 'Admin\ShipmentController@transferToHub')->name('shipments.transfer.hub');
Route::post('/transfer-to-hub/{id}', 'Admin\ShipmentController@shipment_transfer_to_hub')->name('shipments.transfer.hub.post');
Route::resource('help', 'Admin\Resource\HelpController');

Route::post('/dashboard-filter', 'Admin\AdminController@dashboard_filter')->name('dashboard.filter');

Route::resource('/merchant-banners', 'Admin\Resource\MerchantBannerController');

Route::get('/report-claim/{id}', 'Admin\Resource\HelpController@report_claim')->name('shipments.report.claim');


Route::get('hub/earning-statement/{type}', 'Admin\Resource\EarningController@hub_earning_statement')->name('hub_earning_statement');

Route::post('hub/earning-statement/{type}', 'Admin\Resource\EarningController@hub_earning_statement');

Route::get('hub/earning-statement/{type}/{hub_id}', 'Admin\Resource\EarningController@hub_earning_statement');

Route::post('hub/earning-statement/{type}/{hub_id}', 'Admin\Resource\EarningController@hub_earning_statement');

Route::get('hub/shipment-report/{type}', 'Admin\Resource\EarningController@hub_shipment_report')->name('hub_shipment_report');

Route::get('hub/shipment-report/{type}/{rider_id}', 'Admin\Resource\EarningController@hub_shipment_report');

Route::post('hub/shipment-report/{type}', 'Admin\Resource\EarningController@hub_shipment_report');

Route::post('hub/shipment-report/{type}/{rider_id}', 'Admin\Resource\EarningController@hub_shipment_report');

Route::get('hub-payment', 'Admin\Resource\EarningController@hub_payment')->name('hub_payment');

Route::get('/getHubRemAmt/{hub_id}' , 'Admin\Resource\EarningController@getHubRemAmt');

/*Route::get('hub-deposit/{type}', 'Admin\Resource\EarningController@hub_deposit')->name('hub_deposit');

Route::post('hub-deposit/{type}', 'Admin\Resource\EarningController@hub_deposit');*/

Route::post('/changeHubDepositStatus' , 'Admin\Resource\EarningController@changeHubDepositStatus');
Route::post('/payMerchantPayment' , 'Admin\Resource\EarningController@payMerchantPayment');
Route::post('/send-invoice' , 'Admin\Resource\EarningController@sendInvoice');

Route::get("/hub-pickup-details", function(){
   return View::make("admin.hubs.hub-pickup-details");
});

Route::get('hub-deposit', 'Admin\Resource\EarningController@hub_deposit')->name('hub_deposit');
Route::get('hub-deposit/{hub_id}', 'Admin\Resource\EarningController@hub_deposit');
Route::get('rider-deposit', 'Admin\Resource\EarningController@rider_deposit')->name('rider_deposit');
Route::get('rider-deposit/{rider_id}', 'Admin\Resource\EarningController@rider_deposit');
Route::get('merchant-detail/{id}', 'Admin\Resource\MerchantController@detail')->name('merchant-detail');
Route::get('merchant-available-balance', 'Admin\Resource\MerchantController@availableBalance')->name('available-balance');

Route::resource('/merchant-account', 'Admin\Resource\MerchantAccountController');



/////testing
Route::get('shipment-list/{id}', 'Admin\ShipmentController@shipmentGet')->name('shipment.list');
Route::get('shipment-list', 'Admin\ShipmentController@shipmentGet')->name('shipment.list');