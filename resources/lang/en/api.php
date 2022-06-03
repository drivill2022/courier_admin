<?php 

return array (

	'user' => [
		'incorrect_password' => 'Incorrect Password',
		'change_password' => 'Required is new password should 
not be same as old password',
		'password_updated' => 'Password Updated',
		'location_updated' => 'Location Updated',
		'profile_updated' => 'Profile Updated',
		'user_not_found' => 'User Not Found',
		'not_paid' => 'User Not Paid',

	],
	'ride' => [
		'request_inprogress' => 'Already Request in Progress',
		'no_providers_found' => 'No Drivers Found',
		'request_cancelled' => 'Your Ride Cancelled',
		'already_cancelled' => 'Already Ride Cancelled',
		'already_onride' => 'Already You are Onride',
		'provider_rated' => 'Driver Rated',
		'request_scheduled' => 'Ride Scheduled',
		'request_already_scheduled' => 'Ride Already Scheduled',
		'request_modify_location' => 'User Changed Destination Address',
		'request_already_incomplete' => 'Sorry You\'r in-complete order limit is over. Please complete your in-complete order first.',
	],
	'something_went_wrong' => 'Something Went Wrong',
	'logout_success' => 'Logged out Successfully',
	'email_available' => 'Email Available',
	'services_not_found' => 'Services Not Found',
	'bikes_not_found' => 'Vehicle Not Found',
	'promocode_applied' => 'Promocode Applied',
	'promocode_expired' => 'Promocode Expired',
	'promocode_already_in_use' => 'Promocode Already in Use',
	'paid' => 'Paid',
	'payment_fail' => 'Payment Fail',
	'added_to_your_wallet' => 'Added to your Wallet',
	'push' => [
		'request_accepted' => 'Your Ride Accepted by a Driver',
		'request_accepted_ride' => 'Your Ride is Accepted by a Driver:name',
		'request_accepted_parcel' => 'Your Parcel delivery request is Accepted by Driver:name',
		'request_accepted_food' => 'Your Shoping delivery request is Accepted by Driver:name',
		'request_accepted_shop' => 'Your Food delivery request is Accepted by Driver:name',
		'arrived' => 'Driver Arrived at your Location',
		'arrived_parcel' => 'Driver Arrived at your Location for collecting Parcel',
		'dropped' => 'Your ride is completed successfully. you have to pay',
		'incoming_request' => 'New Incoming Ride',
		'incoming_ride' => 'New Ride request received',
		'incoming_food' => 'New Food delivery request received',
		'incoming_shop' => 'New Shop delivery request received',
		'incoming_parcel' => 'New Parcel delivery request received',
		'added_money_to_wallet' => ' Added to your Wallet',
		'charged_from_wallet' => ' Charged from your Wallet',
		'refund_from_wallet' => ' Refunded in your Wallet due to order :order_code cancelled of not completed.',
		'document_verfied' => 'Your Documents are verified, Now you are ready to Start your Business',
		'provider_not_available' => 'Sorry for inconvenience, Our provider is busy. Please try after some time',
		'user_cancelled' => 'User Cancelled the Ride',
		'provider_cancelled' => 'Driver Cancelled the Ride',
		'schedule_start' => 'Your Scheduled ride has been started',
		'provider_enable' => 'Congratulations! Your account has been enabled by administrator',
		'provider_disable' => 'Sorry! Your account has been banned by administrator',
	],
	'payment_for'=>[
		'food' => 'food order',
		'parcel' => 'parcel delivery',
		'shop' => 'shop order',
	],
	'order'=>[
		'cancel'=>"Sorry for inconvience, We are not able to complete your order.",
		'accept'=>"Your order has been accepted",
		'prepared'=>"Your order has been prepared",
		'packed'=>"Your order has been packed & ready for delivery.",
		'delivered'=>"Your order has been delivered successfully.",
		'merchant_rated'=>"Rated successfully to merchant",
		'new_order'=>"New order received",
		'merchant_close'=>'Sorry selected :Merchant has been closed. Please select another :merchant',
		'logout_pending'=>'Sorry You can not Logout. You\'r :order order(s) are not completed yet.',
		'cancel_admin'=>"Sorry for inconvience, We are not able to complete your request.",
		],
	'otp_sms' => 'Your OTP for :app_name is :otp. Please do not share your OTP with anyone as it is confidential.',
	'invoice'=>[
		'ride'=>[
			'subject'=>':app_name | Ride invoice',
			'message'=>'Thank you for ride with :app_name . Please find attechement of your ride invoice.'
		],
		'food'=>[
			'subject'=>':app_name | Food order invoice',
			'message'=>'Thank you for food order at :app_name . Please find attechement of your order invoice.'
		],
		'shop'=>[
			'subject'=>':app_name | Shop order invoice',
			'message'=>'Thank you for shopping with :app_name . Please find attechement of your order invoice.'
		],
		'parcel'=>[
			'subject'=>':app_name | Parcel delivery invoice',
			'message'=>'Thank you for choosing :app_name to deliver your parcel. Please find attechement of your order invoice.'
		],
		'regards'=>'Regards'
	],
	'bike_detail' => 'Vehicle Details Saved Successfully',
);