<?php
function currency($value = '')
{
	if($value == ""){
		return Setting::get('currency')."0";
	} else {
		return Setting::get('currency').round($value);
	}
}

function distance($value = '')
{
    if($value == ""){
        return "0".Setting::get('distance', 'Km');
    }else{
        return round($value,1).Setting::get('distance', 'Km');
    }
}

function img($img){
	if($img == ""){
		return asset('main/avatar.jpg');
	}else if (strpos($img, 'http') !== false) {
        return $img;
    }else{
		return asset('public/storage/'.$img);
	}
}
function admin_asset($asset) {
    return asset('public/backend/'.$asset);
}
function front_asset($asset) {
    return asset('public/front/'.$asset);
}

function image($img){
	if($img == ""){
		return asset('main/avatar.jpg');
	}else{
		return asset($img);
	}
}

function promo_used_count($promo_id)
{
	return PromocodeUsage::where('status','ADDED')->where('promocode_id',$promo_id)->count();
}

function curl($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $return = curl_exec($ch);
    curl_close ($ch);
    return $return;
}

function get_all_bike_types()
{
	return BikeType::all()?:[];
}

function demo_mode(){
	if(\Setting::get('demo_mode', 0) == 1) {
        return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at info@appdupe.com');
    }
}
function statusClass($status){
	$st=array('SEARCHING','ARRIVED','PICKEDUP','DROPPED','ACCEPTED','PREPARED','PACKED','PIKEDUP','DELIVERED','COMPLETED','STARTED');
	if(in_array($status, $st)) {
        return 'success';
    }elseif(in_array($status, ['SCHEDULED','PENDING'])){
    	return 'warning';
    }else{
    	return 'danger';
    }
}

function seller_product_type($seller,$column='id',$type='0')
{
   $data= \App\models\admin\Seller::findOrFail($seller)->product_type()->select($column)->get()->pluck($column)->toArray();
   if($type==1){
    $data=implode(',', $data);
   }
   return $data;
}

/*
|------------------------------
|Function for get formated date
|------------------------------
*/
function MydateTime($date, $format='')
{
    /*$default=config('app.default_date_format');
    if($format){
        return date($format, strtotime($date));
    }
    return date($default, strtotime($date));*/
    return date('d M Y', strtotime($date));
}

function shipment_staus_option($status=0)
{
    //$st=[0,1,2,3,4,5,6,7,8,9];
    $st=[1,2,3,4,5,6,8];
    $op='<option value="">Select Status</option>';
    foreach($st as $s){
        $sel=$status==$s?'selected':'';
        $op.='<option value="'.$s.'" '.$sel.'>'.shipment_status($s).'</option>';
    }
    return $op;
}

function shipment_status($status)
{
    switch ($status) {
        case '1':
        return 'Requested';
        break;
        case '2':
        return 'Assigned';
        break;
        case '3':
        return 'Pickedup';
        break;
        case '4':
        return 'Transit';
        break;  
        case '5':
        //return 'Shipped';
        return 'On going delivery';
        break;
        case '6':
        return 'Delivered';
        break;
        case '7':
        return 'Completed';
        break;  
        case '8':
        return 'Cancelled';
        break;
        case '9':
        return 'Rejected';
        break;     
        case '10':
        return 'Cancelled(Customer Not Available)';
        break;
        case '11':
        return 'Cancelled(Cancel by admin/merchant before mark pickup)';
        case '12':
        return 'Cancelled(Cancel by rider)';
        break;        
        default:
        return 'Onboarding';
        break;
    }
}

function shipmentPType($type)
{
    $types=['1'=>'Documents','2'=>'Heavy Weight'];
    return isset($types[$type])?$types[$type]:'NA';
}
function shipmentStatusDB($status)
{
    $status=strtolower($status);
    $types=[
        'onboarding'=>0,
        'requested'=>1,
        'assigned'=>2,
        'pickedup'=>3,
        'transit'=>4,
        'shipped'=>5,
        'delivered'=>6,
        'completed'=>7,
        'cancelled'=>8,
        'rejected'=>9
    ];
    return isset($types[$status])?$types[$status]:'NA';
}

function shipmentDType($type)
{
    //$types=['1'=>'Normal','2'=>'Express'];
    $types=['1'=>'Standard','2'=>'Express'];
    return isset($types[$type])?$types[$type]:'NA';
}
function reasonsType($type)
{
    $types=['0'=>'All','1'=>'Admin','2'=>'Rider','3'=>'Hub','4'=>'Merchant','5'=>'Seller','6'=>'Customer'];
    return isset($types[$type])?$types[$type]:'NA';
}

/*
|-----------------------------------------------------
| Function checking the role permission to access menu
|-----------------------------------------------------
*/
function AdminCan($url)
{  
    if(session('expire') < Date('Y-m-d H:i:s') || is_null(session('permissions'))){   
        $role = \App\models\admin\Role::with('permissions')->findOrFail(auth()->guard('admin')->user()->role_id);        
        $permissions = $role->permissions;
        $min=env('PERMISSION_UPDATE_REFRESH',0);
        session(['permissions'=>$permissions,'expire'=>date('Y-m-d H:i:s',strtotime('+'.$min.' minutes'))]);
    }else{
        $permissions = session('permissions');
    }  
   foreach ($permissions as $permission)
   {    
     if($url === $permission->name || $permission->id == '1')
     {   
        return true;
     }
    }
    return false;
}


function hub_riders($hub,$sel='')
{
     $rider=\App\models\admin\DeliveryRiders::where('hub_id',$hub)->where('status', 'Active')->get();
        $op='<option value="">Select Rider</option>';
        if($rider->count()==0){
            return $op='<option value="">---No Rider In Selected Hub----</option>';
        }
        foreach($rider as $r){
            $s=$sel==$r->id?'selected':'';
            $op.='<option value="'.$r->id.'" '.$s.'>'.ucwords($r->name).'</option>';
        }
        return $op;
}


 function get_sub_category($id,$selId='')
    {
         $ct=\App\models\SellerItemCategories::where('parent_category_id',$id)->where('status', 'Active')->get();
        $op='<option value=""></option>';
        if($ct->count()==0){
            return $op='<option value="">---No Sub Category In Selected Category----</option>';
        }
        foreach($ct as $c){
            $sel=($c->id==$selId)?'selected':'';
            $op.='<option value="'.$c->id.'" '.$sel.'>'.ucwords($c->name).'</option>';
        }
        return $op;
    }


/*function sendSms($msisdn, $messageBody)
    {
        $bytes = random_bytes(10);
        $csms_id = bin2hex($bytes);
        $params = [
                "api_token" => "DRIVILL-616ca3b0-d6f0-4fcb-996a-17a7b7e03e6a",
                "sid" => "DRIVILLBDAPI",
                "msisdn" => $msisdn,
                "sms" => $messageBody,
                "csms_id" => $csms_id 
               ];

        $url = "https://smsplus.sslwireless.com/api/v3/send-sms";
        $params = json_encode($params);

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params),
            'accept:application/json'
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://smsplus.sslwireless.com/api/v3/send-sms',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array('api_token' => 'DRIVILL-616ca3b0-d6f0-4fcb-996a-17a7b7e03e6a','sid' => 'DRIVILLBDAPI','msisdn' => $msisdn,'sms' => $messageBody,'csms_id' => $csms_id)
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }*/

    function sendSms($mobiles, $message)
    {
        $username = "drivillPromo";
        $password = "DrivillD09.@";
        $first = substr($mobiles, 0, 1);
        $third = substr($mobiles, 0, 3);
        if($first == 0)
        {
           $mobiles = '+88'.$mobiles; 
        }
        else if($third == '880')
        {
            $mobiles = '+'.$mobiles; 
        }
        else
        {
           $mobiles = '+880'.$mobiles;
        }
        //return $message;
        //$mobiles = '8801785711924';
        //$sms = 'Thank you for your kind purchase. For any query, please contact our hotline number: 01969604444.';
        //$originator = '01844016400';
    
        $message = rawurlencode($message);
        
        $url = "http://clients.muthofun.com:8901/esmsgw/sendsms.jsp?user=$username&password=$password&mobiles=$mobiles&sms=$message&unicode=1";           

        $c = curl_init(); 
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($c, CURLOPT_URL, $url); 
        $response = curl_exec($c);
        /*if( $response === false)
        {
            echo 'Curl error: ' . curl_error($c).' '.curl_errno($c); die;
        } */
        return $response;

    }

function delivery_charges_area($id)
{
    switch ($id) {
        case '1':
        return 'Metro area';
        break;
        case '2':
        return 'Suburbs area';
        break;
        case '3':
        return 'Intercity area';
    }
}

function shipmentProductType($product_type_id)
{
     $product_type=\App\models\admin\ProductType::find($product_type_id);
     return $product_type->name; 
}
function FindReturnShipment($shipment_id)
{
     $data=App\models\ShipmentStatusLog::where('shipment_id',$shipment_id)->where('status',10)->count('id');
     return $data; 
}
function cancelNote($note,$updated_by_id,$updated_by)
{
     if($updated_by == "Admin")
     {
        $user=\App\models\admin\Admin::find($updated_by_id);
        return str_replace("Admin",$user->name,$note);
     } 
      if($updated_by == "Customer")
     {
        $user=\App\models\admin\DeliveryRiders::find($updated_by_id);
        return str_replace("Customer",$user->name,$note);
     }  
     if($updated_by == "Merchant")
     {
        $user=\App\models\admin\Merchants::find($updated_by_id);
        return str_replace("Merchant",$user->name,$note);
     }    
}
function sendNotification($firebaseToken,$data)
    {
        //$firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
          
        //$SERVER_API_KEY = 'AAAAcfXlScc:APA91bEDObXY3Ym5Tka7ELJex4MVwE0dvfd3C0jReqkvktRMk3v3RVONWKHelrtjyVsDId0C7LClNR6AwZboj7QggqfDm8YeEA9cKEgCItAXTEuzTEF3wBEwoex7gaKwrFbotkK232DR';

        $SERVER_API_KEY = 'AAAAOt4XEo8:APA91bER5o9oUFuJkG8FDD3H8E0HOoQErgsAbRW_aeiEax1qswaTQkimSu2XjWbEOMMyqbAikvFBIPLBXlJr72nEpVhCqT4odyFAU6pkrExkmNiT7U-DMjykWL4-luGN3xzX9bar6XV7';
  
        $data = [
            "registration_ids" => (array)$firebaseToken,
            "notification" => [
                "title" => $data['title'],
                "body" => $data['body'],  
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
       return $response = curl_exec($ch);
  
    }

function getMerchant($merchant_id)
{
    $user=\App\models\admin\Merchants::find($merchant_id);
    return $user->address;    
}

  function notificationList($merchant_id)
    {
      $data = \App\models\ShipNotification::select('ship_notifications.id','ship_notifications.rider_id','ship_notifications.shipment_id','ship_notifications.is_viewed','ship_notifications.created_at','notifications.message')->join('notifications','notifications.id','=','ship_notifications.notification_id')->where('merchant_id', $merchant_id)->orderBy('created_at','desc')->limit(3)->get();
      if(!empty($data))
      {
        foreach ($data as $key => $value) {
          $shipment = \App\models\Shipments::find($value->shipment_id);
          $rider = \App\models\admin\DeliveryRiders::find($value->rider_id);
          $data[$key]->message = str_replace("{{tracking_number}}",$shipment->shipment_no,$value->message);
          $data[$key]->message = str_replace("{{rider_name}}",@$rider->name,$value->message);
          $data[$key]->message = str_replace("{{cod_amount}}",'Tk.'.$shipment->cod_amount,$value->message);
        }
      }
      return $data;
    }

     function notificationcount($merchant_id)
    {
      $data = \App\models\ShipNotification::select('ship_notifications.id','ship_notifications.rider_id','ship_notifications.shipment_id','ship_notifications.is_viewed','ship_notifications.created_at','notifications.message')->join('notifications','notifications.id','=','ship_notifications.notification_id')->where('merchant_id', $merchant_id)->orderBy('created_at','desc')->where('is_viewed','0')->count();
      
      return $data;
    }
     function cancelShipmentCharge($shipment_id)
    {
       $sql = "SELECT * FROM `dri_shipment_status_logs` where id < (SELECT id FROM `dri_shipment_status_logs` where shipment_id = '".$shipment_id."'and status = 8 ORDER BY `dri_shipment_status_logs`.`id` DESC limit 1) and status != 8 ORDER BY `dri_shipment_status_logs`.`id` DESC limit 1";
      $data = \DB::select($sql);
      return $data;
    }
    function getHubDetail($hub_id)
    {
        $data = \App\models\admin\Hubs::find($hub_id);
        return @$data->name;
    }
    function getMerchantBussName($merchant_id)
    {
        $user=\App\models\admin\Merchants::find($merchant_id);
        return $user->buss_name;    
    }
<<<<<<< HEAD
    function GetDeliveryDate($shipment_id)
    {
         $data=App\models\ShipmentStatusLog::where('shipment_id',$shipment_id)->where('status',6)->first();
         return $data; 
=======
    function FindReturnShipmentAddress($shipment_id)
    {
         $data=App\models\ShipmentStatusLog::where('shipment_id',$shipment_id)->where('status',8)->first();
         $shipment = \App\models\Shipments::find($shipment_id);
         if(!empty($data))
         {
            $merchant=\App\models\admin\Merchants::find($shipment->merchant_id);
            return $merchant->address;  
         }
         else
         {
            
            return $shipment->d_address;  
         }
         
>>>>>>> 6b712ad7351dc956a816c255232e9a4818d3a8ab
    }