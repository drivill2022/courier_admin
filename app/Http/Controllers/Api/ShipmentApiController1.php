<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\models\admin\Merchants;
use App\models\admin\Division;
use App\models\admin\District;
use App\models\admin\Thana;
use App\models\admin\Hubs;
use App\models\Shipments;
use App\models\ShipmentStatusLog;
use App\models\ShipmentAssignStatus;
use App\models\admin\ProductType;
use Illuminate\Support\Facades\Hash;
use App\Helper\ControllerHelper as Helper;
use App\models\admin\ShipmentReason;
use App\models\admin\MerchantPaymentAccount;
use App\models\admin\Admin;
use App\models\MerchantWithdrawRequest;
use App\models\admin\Help;
use Auth;
use Storage;
use Validator;
use DB;
use Carbon\Carbon;
use App\models\Notification;
use App\models\ShipNotification;
use App\models\admin\DeliveryRiders;
use DateTime;
use App\models\MerchantAccount;
use DateInterval;
use DatePeriod;

class ShipmentApiController extends Controller
{

 /* public function cancel_reasons(Request $request)
  {
    $this->validate($request, [            
        'reason_for' => 'required|in:2,3,4,5'
    ]);
    $rf=$request->reason_for?'0,'.$request->reason_for:'0';
    $data['cancel_reasons'] = ShipmentReason::whereIn('reason_for',[$rf])->latest()->get();
    $data['message'] =$data['cancel_reasons']?"success":"No Record found";
    return response()->json($data, 200);
  }*/

   public function cancel_reasons(Request $request)
  {
    $data['cancel_reasons'] = ShipmentReason::where('reason_for',4)->latest()->get();
    $data['message'] =$data['cancel_reasons']?"success":"No Record found";
    return response()->json($data, 200);
  }
  
  public function divisions()
  {
       $data = Division::orderBy('name','asc')->get();
       return response()->json($data, 200);
  }

  public function district($id)
  {
       $data = District::where('division_id',$id)->orderBy('name','asc')->get();
       return response()->json($data, 200);
  }

  public function thana($id)
  {
       $data = Thana::where('district_id',$id)->orderBy('name','asc')->get();
       return response()->json($data, 200);
  }

    public function index(Request $request)
    {
     // DB::enableQueryLog();

        $data = Shipments::locationData()->where('merchant_id', Auth::user()->id)->orderBy('created_at','desc');
        if($request->status) {
            switch (strtolower($request->status)) {
                case 'current':
                    $data= $data->whereIn('status', ['0','1','2']);
                    break;
                case 'scheduled':
                    $data= $data->whereIn('status', ['0','1','2'])->whereDate('pickup_date', '>=', date('Y-m-d'));
                    //$data= $data->whereIn('status', ['0','1','2']);
                    break;
                case 'shipped':
                    $data= $data->whereIn('status', ['2','3','4','5']);
                    break;
                case 'delivered':
                    $data= $data->whereIn('status', ['6','7']);
                    break;
                case 'cancelled':
                    $data= $data->whereIn('status', ['8','9','10']);

                    break;
            }            
        }
        $data =$data->get();
        //dd(DB::getQueryLog());
        if(!empty($data))
        {
            foreach ($data as $key => $value) {
                $product_type = ProductType::find($value->product_type);
                $data[$key]->product_type = $product_type->name;
                $data[$key]->pickup_date = date('Y-m-d',strtotime($value->pickup_date));
                 $shipmentassign = ShipmentAssignStatus::where('shipment_id',$value->id)->orderBy('id','desc')->first();
                //$data[$key]->created_date = $value->created_at->setTimezone('Asia/Dhaka')->format('d M Y h:i A');
                 $data[$key]->created_date = date('d M Y',strtotime($value->pickup_date));
                 /*if($request->status == 'current')
                 {
                   if($value->status != 0)
                   {
                     $data[$key]->created_date = $shipmentassign->created_at->setTimezone('Asia/Dhaka')->format('d M Y h:i A');
                   }
                   
                 }*/
                
            }
        }

        return response()->json($data, 200);
    }

    public function create(Request $request)
    {
        
        $this->validate($request, [            
            'receiver_name' => 'required|max:255',            
            'contact_no' => 'required|digits_between:8,12',            
            //'product_detail' => 'required|max:255',            
            'product_type' => 'required|max:255',
            'product_weight' => 'required|max:255',
            //'note' => 'required|max:255',
            's_thana' => 'required',
            's_district' => 'required',
            's_division' => 'required',
            'd_thana' => 'required',
            'd_district' => 'required',
            'd_division' => 'required',
            's_address'=>'nullable',
            'd_address'=>'nullable',
            'shipment_type'=>'required',
            'shipment_cost'=>'nullable',
            //'pickup_date'=>'required|date_format:d-m-Y h:i A',
            'pickup_date'=>'required',
            'cod_amount'=>'nullable',

        ]);

        try{
            $shipment = $request->all();
            $shipment['merchant_id'] = Auth::user()->id;
            $shipment['pickup_date'] = date('Y-m-d H:i:s',strtotime($request->pickup_date));
            //$shipment['shipment_no'] = rand(1,9999);
            /*$lastship = Shipments::orderBy('id','desc')->first();
            return $shipment['shipment_no'] = '#SPM'.sprintf('%08d', $lastship->id);*/
            $shipment = Shipments::create($shipment);  
           /* $shipment->shipment_no = '#SPM'.sprintf('%08d', $shipment->id);
            $shipment->save();*/
            $shipment->shipment_no = '#DC'.sprintf('%04d', $shipment->id);
            $shipment->save();

            $shipment=Shipments::locationData()->find($shipment->id);
            $product_types = ProductType::find($shipment->product_type);
            $shipment->product_type = $product_types->name;
            return response()->json(['message' =>'Shipment Created Successfully','data'=>$shipment],200);
            }
        catch (Exception $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }
    }


    /*
    |---------------------------------
    | Shipment cancelled by merchant
    |---------------------------------
    */
    public function cancel(Request $request)
    {
        $this->validate($request, [            
            'id' => 'required|exists:shipments,id',
            'reason' => 'required|max:255'
        ]);
        try{
             $shipment=Shipments::where('id',$request->id)->where('merchant_id',Auth::user()->id)->firstOrFail();
            if(in_array($shipment->status, ["0","1","2","3"]) || in_array($shipment->status, [0,1,2,3]))
            {
              $shipment->status='11';
              $shipment->save();
              $shipment->status_log= ShipmentStatusLog::create([
                  'shipment_id'=>$shipment->id,
                  'status'=>11,
                  'updated_by'=>"Merchant",
                  'updated_by_id'=>Auth::user()->id,
                  'updated_ip'=>$request->ip(),
                  'reason'=>$request->reason,
                  'note'=>'Shipment Cancelled By Merchant'
              ]);
            }
            else
            {
              $shipment->status='8';
              $shipment->save();
              $shipment->status_log= ShipmentStatusLog::create([
                  'shipment_id'=>$shipment->id,
                  'status'=>8,
                  'updated_by'=>"Merchant",
                  'updated_by_id'=>Auth::user()->id,
                  'updated_ip'=>$request->ip(),
                  'reason'=>$request->reason,
                  'note'=>'Shipment Cancelled By Merchant'
              ]);
            }
            
            return response()->json(['message' =>'Shipment Cancelled Successfully','data'=>$shipment],200);
        }catch(ModelNotFoundException $m){
             return response()->json(['error' => 'shipment not found'], 404);
        }catch (Exception $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        try {
            $shipment = Shipments::locationData()->with('rider.rider')->where('id',$id)->where('merchant_id',Auth::user()->id)->firstOrFail();
            $shipment->status_logs = ShipmentStatusLog::where('shipment_id',$shipment->id)->get();
            $shipment->product_types = ProductType::find($shipment->product_type);
            $product_type = ProductType::find($shipment->product_type);
            $shipment->product_type_name = $product_type->name;
            return response()->json(['message' =>'success','data'=>$shipment],200);
        }catch(ModelNotFoundException $m){
             return response()->json(['error' => 'shipment not found'], 404);
        }catch (Exception $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }
    }



     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function request_pickup(Request $request)
    {
        $this->validate($request, [            
            'id' => 'required',
            'hub_id'=>'nullable|integer',
            'note'=>'nullable|255'
        ]);
        try {
            $shipment = Shipments::whereIN('id',$request->id)->where('merchant_id',Auth::user()->id)->get();
            //echo count($shipment);die;
            if(!$shipment){
               return response()->json(['error' => 'shipment not found'], 404); 
            }
            foreach($shipment as $k => $s){
                ShipmentStatusLog::create([
                    'shipment_id'=>$s->id,
                    'status'=>1,
                    'updated_by'=>'Merchant',
                    'updated_by_id'=>Auth::user()->id,
                    'updated_ip'=>$request->ip(),
                    'reason'=>$request->reason,
                    'note'=>@$request->note?:'Pickup Request By Merchant'
                ]);
                $shipment[$k]->status='1';
                $shipment[$k]->not_for_hub=$request->not_for_hub;
                $shipment[$k]->save();
                //if($request->hub_id) {
                    ShipmentAssignStatus::create([
                        'shipment_id'=>$s->id,
                        //'hub_id'=>$request->hub_id,
                        'hub_id'=> 0,
                        'rider_id'=>$request->rider?:0,
                        //'status'=>$s->status
                        'status'=> 1
                    ]);
               // }
            }
            return response()->json(['message' =>'Request sent successfully','data'=>$shipment],200);
        }catch(ModelNotFoundException $m){
             return response()->json(['error' => 'shipment not found'], 404);
        }catch (Exception $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }
    }  


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function nearest_hubs(Request $request)
    {
        $this->validate($request, [            
            'latitude' => 'required',
            'longitude' => 'required'
        ]);
        try {
            $distance = \Setting::get('hub_search_radius', '10');
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $select = \DB::raw("*, ROUND(IF((1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),0 ),2) as distance");
            $hubs = Hubs::select($select)->where('status', 'Active')
            ->whereRaw("IF((1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),0 ) <= $distance")
            ->get();
            return response()->json(['message' =>'success','data'=>$hubs],200);
        }catch(ModelNotFoundException $m){
             return response()->json(['error' => 'shipment not found'], 404);
        }catch (Exception $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }
    }



     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function shipment_track(Request $request)
    {
        $this->validate($request, ['shipment_no' => 'required']);
        try {
            $cancel_id = 0;
            $return = 0;
            $shipment = Shipments::locationData()->where('shipment_no',$request->shipment_no)->where('merchant_id',Auth::user()->id)->firstOrFail();
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $shipment->pickup_date)->setTimezone('Asia/Dhaka')->format('d M Y');
            $shipment->created_date = $date;
            $shipment->pickup_date = Carbon::createFromFormat('Y-m-d H:i:s', $shipment->pickup_date)->setTimezone('Asia/Dhaka')->format('d M Y');

            $delivery_Attempt_fail = ShipmentStatusLog::where('shipment_id',$shipment->id)->where('status',10)->orderBy('id','desc')->first();

            $cancel_shipmet_By_admin = ShipmentStatusLog::where('shipment_id',$shipment->id)->where('status',8)->orderBy('id','desc')->first();

            $cancel_shipmet_By_rider = ShipmentStatusLog::where('shipment_id',$shipment->id)->where('status',12)->orderBy('id','desc')->first();

            if(!empty($delivery_Attempt_fail))
            {
              $status_logs = ShipmentStatusLog::where('id','>',$delivery_Attempt_fail->id)->where('shipment_id',$shipment->id)->orderBy('id','asc')->get();
              if(count($status_logs) == 0)
              {
                 $status_logs = ShipmentStatusLog::where('shipment_id',$shipment->id)->orderBy('id','asc')->get();
              }
            } 
            if(!empty($cancel_shipmet_By_admin))
            {
              $cancel_id = $cancel_shipmet_By_admin->id;
              $status_logs = ShipmentStatusLog::where('id','>',$cancel_shipmet_By_admin->id)->where('shipment_id',$shipment->id)->orderBy('id','asc')->get();
              if(count($status_logs) == 0)
              {
                 $status_logs = ShipmentStatusLog::where('shipment_id',$shipment->id)->orderBy('id','asc')->get();
              }
              else
              {
                $return = 1;
                $cancel_id = $cancel_shipmet_By_admin->id;
              }
            }
            /*else if(!empty($cancel_shipmet_By_admin) && !empty($cancel_shipmet_By_rider))
            {
              if($cancel_shipmet_By_admin->id > $cancel_shipmet_By_rider->id)
              {

              }
              $status_logs = ShipmentStatusLog::where('id','>',$cancel_shipmet_By_rider->id)->where('shipment_id',$shipment->id)->orderBy('id','asc')->get();
              if(count($status_logs) == 0)
              {
                 $status_logs = ShipmentStatusLog::where('shipment_id',$shipment->id)->orderBy('id','asc')->get();
              }
            }*/
            /*else if(!empty($delivery_Attempt_fail) && !empty($cancel_shipmet_By_rider))
            {
                if(($delivery_Attempt_fail->id > $cancel_shipmet_By_rider->id))
                {
                   $status_logs = ShipmentStatusLog::where('id','>=',$delivery_Attempt_fail->id)->where('shipment_id',$shipment->id)->orderBy('id','asc')->get();
                }
                elseif($cancel_shipmet_By_rider->id > $delivery_Attempt_fail->id)
                {
                  $status_logs = ShipmentStatusLog::where('id','>=',$cancel_shipmet_By_rider->id)->where('shipment_id',$shipment->id)->orderBy('id','asc')->get();
                }
            }*/
            else
            {
               $status_logs = ShipmentStatusLog::where('shipment_id',$shipment->id)->orderBy('id','asc')->get();
            }
            
            $status_logs = ShipmentStatusLog::where('shipment_id',$shipment->id)->orderBy('id','asc')->get();
            if(!empty($status_logs))
            {
               $cancel_status = 0;
               foreach ($status_logs as $key => $value) {
                 $status_logs[$key]->created_date =  Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->setTimezone('Asia/Dhaka')->format('d M Y h:i A');
                 if($value->status == 4 || $value->status == 3)
                 {
                  if($value->updated_by == "Rider")
                  {
                    $rider = DeliveryRiders::find($value->updated_by_id);
                    $status_logs[$key]->note = str_replace('Rider',$rider->name, $status_logs[$key]->note);
                  }
                 }

                  if($value->status == 10)
                  {
                     $status_logs[$key]->note = $value->reason;
                  }

                  if($value->status == 12)
                  {
                    if($value->updated_by == "Customer")
                    {
                      $rider = DeliveryRiders::find($value->updated_by_id);
                      $status_logs[$key]->note = str_replace('Customer',$rider->name, $status_logs[$key]->note);
                    }
                     $cancel_status = 1;
                  }
                 
                  if($value->status == 8 && $cancel_status == 1)
                  {
                     $status_logs[$key]->note = "shipment prepare for return";
                  }
                   if(($value->status == 4 && $cancel_status == 1) || ($value->status == 5 && $cancel_status == 1))
                   {

                    $assign = ShipmentAssignStatus::where('shipment_id',$value->shipment_id)->orderBy('id','desc')->first();
                    $rider = DeliveryRiders::find($assign->rider_id);
                    $status_logs[$key]->note = "(".$rider->name.") on the way to return. Call rider for latest update (".$rider->mobile.")";
                 }
                 if($value->status == 6 && $cancel_status == 1)
                  {
                     $status_logs[$key]->note = "Shipment Returned";
                  }

                 /* if(($value->status > $cancel_id) && $return == 1 && $value->status == 5)
                  {
                     $assign = ShipmentAssignStatus::where('shipment_id',$value->shipment_id)->orderBy('id','desc')->first();
                    $rider = DeliveryRiders::find($assign->rider_id);
                    $status_logs[$key]->note = "(".$rider->name.") on the way to return. Call rider for latest update (".$rider->mobile.")";
                  }*/
                 if($value->status == 5)
                  {
                  	 if(($cancel_id !=0) && ($value->id > $cancel_id))
	                  {
	                     $assign = ShipmentAssignStatus::where('shipment_id',$value->shipment_id)->orderBy('id','desc')->first();
	                    $rider = DeliveryRiders::find($assign->rider_id);
	                    $status_logs[$key]->note = "(".$rider->name.") on the way to merchant address for return. Call rider for latest update (".$rider->mobile.")";
	                  }
	                  else
	                  {
	                  	 $assign = ShipmentAssignStatus::where('shipment_id',$value->shipment_id)->orderBy('id','desc')->first();
		                    $rider = DeliveryRiders::find($assign->rider_id);
                        if(!empty($rider))
                        {
                          $status_logs[$key]->note = "(".$rider->name.") on the way to customer location. Call rider for latest update (".$rider->mobile.")";
                        }
		                    
	                  }
                   
                  }
                  if($return == 1 && $value->status == 6)
                  {
                     $status_logs[$key]->note = "Shipment Returned";
                  }
               }
            }
            $shipment->status_logs = $status_logs;
           // $shipment->created_at = date('Y-m-d',strtotime($shipment->created_at));
            return response()->json(['message' =>'success','data'=>$shipment],200);
        }catch(ModelNotFoundException $m){
             return response()->json(['error' => 'shipment not found'], 404);
        }catch (Exception $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }
    }


    public function shipment_otp(Request $request)
    {
        $this->validate($request, [            
            'id' => 'required|exists:shipments,id',
            'otp_to' => 'required|in:1,2'
        ]);

         try {
            $shipment = Shipments::whereHas('rider',function($query)
            {
                $query->where('rider_id',Auth::user()->id);
            })->where('id',$request->id)->firstOrFail();
            $shipment->otp='4343';
            $shipment->save();
            $otp_type='receiver';
            $mobile=$shipment->contact_no;
            if($request->otp_to==1){
                $otp_type='merchant';
                $mobile=$shipment->merchant->mobile;
            }
            $message='OTP has been sent on '.$otp_type.' mobile. Please ask the otp and continue';
            /*Note- Here you need to write send otp code after get sms api from client */

           /* $msg="Your DRiViLL verification code is ".$shipment->otp.". Please do not share this code with anyone."; 
            sendSms($mobile,$msg);*/
          
            return response()->json(['message' =>$message,'otp'=>$shipment->otp],200);
        }catch(ModelNotFoundException $m){
             return response()->json(['error' => 'shipment not found'], 404);
        }catch (Exception $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }
    }

     /*public function paymentHistory()
    {
        //print_r(Auth::user());die;
        //return Auth::user()->id;
        //$data = Shipments::where('merchant_id', 29)->orderBy('created_at','desc')->whereIn('status', ['6','7'])->get();
        $data = Shipments::where('merchant_id', Auth::user()->id)->orderBy('created_at','desc')->whereIn('status', ['6','7'])->get();

        //print_r($data);die;

        $rdata = [];
        if(!empty($data))
        {
            foreach ($data as $key => $value) {
              $merchant = Merchants::select('payment_methods.name','merchants.name as merchant_name')->join('payment_methods','merchants.payment_method','=','payment_methods.id')->where('merchants.id',$value->merchant_id)->first();

              $statuslog = ShipmentStatusLog::where('id',$value->id)->first();

              $rdata[$key]['shipment_no'] = $value->shipment_no;
              $rdata[$key]['paid_by'] = @$merchant['merchant_name'];
              $rdata[$key]['cod_amount'] = $value->cod_amount;
              $rdata[$key]['date'] = $statuslog->created_at;
              //$rdata[$key]['payment_method'] = 'COD';
              $rdata[$key]['payment_method'] = @$merchant['name'];
            }
        }

        $resp['history'] = $rdata;
        $resp['message']="success";
        return response()->json($resp, 200);
    }*/

     public function paymentHistory()
    {
        //$merchant_id = 27;
        $merchant_id = Auth::user()->id;
        /*$data = Shipments::select('merchant_payment_accounts.*','shipments.shipment_no')->join('merchant_payment_accounts','merchant_payment_accounts.shipment_id','=','shipments.id')->where('merchant_payment_accounts.merchant_id', $merchant_id)->orderBy('created_at','desc')->paginate(1);*/
        $data = MerchantPaymentAccount::select('merchant_payment_accounts.*')->where('merchant_id', $merchant_id)->groupBy('txn_id','merchant_id')->latest()->paginate(10);
        $rdata = [];
        if(!empty($data))
        { 
            
            foreach ($data as $key => $value) {
               $total_pay = 0;
              $admin = Admin::where('id',$value->paid_by)->first();
              $data[$key]['shipment_no'] = $value->txn_id;
              $data[$key]['paid_by'] = $admin->name;
              $getAllShipment = MerchantPaymentAccount::where('txn_id',$value->txn_id)->where('merchant_id',$value->merchant_id)->pluck('shipment_id');
              $cod_amount = Shipments::whereIn('id',$getAllShipment)->sum('cod_amount');
              $shipment_cost = Shipments::whereIn('id',$getAllShipment)->sum('shipment_cost');
              $amount = $cod_amount - $shipment_cost;
              $total_pay = $total_pay + $amount;
              //$data[$key]['cod_amount'] = $value->pay_amount;
              $data[$key]['cod_amount'] = $total_pay;
              $data[$key]['date'] = Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->setTimezone('Asia/Dhaka')->format('d M Y h:i A');
              $data[$key]['payment_method'] = payment_mode($value->payment_mode);
              unset($value->payment_mode);
              unset($value->shipment_id);
              unset($value->merchant_id);
              unset($value->status);
              unset($value->pay_amount);
              unset($value->created_at);
              unset($value->updated_at);
            }
        }

        $resp['history'] = $data;
        $resp['message']="success";
        return response()->json($resp, 200);
    }

   public function shippingHistory()
    {
        //$merchant_id = 27;
        $merchant_id = Auth::user()->id;
        $data = Shipments::select('shipment_no','receiver_name','product_detail','cod_amount','created_at')->where('merchant_id', $merchant_id)->whereIn('status', ['6','7'])->orderBy('created_at','desc')->paginate(10);
        $rdata = [];
        //print_r($data['data']);die;
        if(!empty($data))
        {
            foreach ($data as $key => $value) {
              $data[$key]['shipment_no'] = $value->shipment_no;
              $data[$key]['delivered_to'] = $value->receiver_name;
              $data[$key]['product_detail'] = $value->product_detail;
              $data[$key]['cod_amount'] = $value->cod_amount;
              $data[$key]['date'] = $value->created_at;
              unset($value->receiver_name);
              unset($value->created_at);
            }
        }

        $resp['history'] = $data;
        $resp['message']="success";
        return response()->json($resp, 200);
    }

    /*public function earnPay()
    {
        //$merchant_id = 36;
        $merchant_id = Auth::user()->id;
        $merchant_payment_data = MerchantPaymentAccount::select('merchant_payment_accounts.*')->where('merchant_id', $merchant_id)->orderBy('created_at','desc')->first();
        if(!empty($merchant_payment_data))
        {
           $last_pay_date = date('Y-m-d',strtotime($merchant_payment_data->created_at));
           $total_Shipments = Shipments::select('shipment_no','receiver_name','product_detail','cod_amount','created_at')->where('merchant_id', $merchant_id)->whereIn('status', ['6','7'])->whereDate('created_at','>',$last_pay_date)->get();

           $total_cod_collected = $total_Shipments->sum('cod_amount');
           if(count($total_Shipments) > 0)
           {
           $start_date = date('d, M Y',strtotime($total_Shipments[0]->created_at));
           //$start_date = date('d, M Y');
           }
           else
           {
             $start_date = date('d, M Y');
           }
            $end_date = date('d, M Y');
        }
        else
        {
           $total_Shipments = Shipments::select('shipment_no','receiver_name','product_detail','cod_amount','created_at')->where('merchant_id', $merchant_id)->whereIn('status', ['6','7'])->orderBy('created_at','desc')->get();

           $total_cod_collected = $total_Shipments->sum('cod_amount');

           if(count($total_Shipments) > 0)
           {           
             $start_date = date('d, M Y',strtotime($total_Shipments[count($total_Shipments)-1]->created_at));
           }
           else
           {
             $start_date = date('d, M Y');
           }
           $end_date = date('d, M Y');
        }


        $sql = Shipments::select(DB::raw('DATE(created_at) as date'), DB::raw('count(created_at) as count'))->where('merchant_id',$merchant_id)->orderBy('created_at','desc');

        $sql1=clone $sql;
        $sql2=clone $sql;
        $sql3=clone $sql;
        $sql4=clone $sql;

        $shipmentlist = $sql->whereIn('status', ['6','7'])->groupBy('date')->paginate(5);

        $resp['completed']= $sql1->whereIn('status', ['6','7'])->count('shipments.id');

        $resp['return']= $sql2->where('status',8)->count('shipments.id');

        $resp['pending']= $sql3->where('status',0)->count('shipments.id');

        $resp['total']= $sql4->count('shipments.id');


        $resp['start_date'] = $start_date;
        $resp['end_date'] = $end_date;
        $resp['total_cod_collected'] = $total_cod_collected;
        $resp['shipments'] = $shipmentlist;
        $resp['message']="success";
        return response()->json($resp, 200);
    }*/

    public function earnPay()
    {
        //$merchant_id = 36;
        $merchant_id = Auth::user()->id;
        $merchant_payment_data = MerchantPaymentAccount::select('merchant_payment_accounts.*')->where('merchant_id', $merchant_id)->orderBy('created_at','desc')->first();

        $shipment_ids = MerchantPaymentAccount::where('merchant_id', Auth::user()->id)->where('status', "1")->pluck('shipment_id')->toArray();

        $total_Shipments = Shipments::select('shipment_no','receiver_name','product_detail','cod_amount','created_at')->whereNotIn('id',$shipment_ids)->where('merchant_id', $merchant_id)->whereIn('status', ['6','7'])->get();

         $total_cod_collected = $total_Shipments->sum('cod_amount');

         $shipment_cost = Shipments::select('shipment_no','receiver_name','product_detail','cod_amount','created_at')->where('merchant_id', $merchant_id)->whereNotIn('id',$shipment_ids)->whereIn('status', ['6','7'])->sum('shipment_cost');

         $merchant_payment = MerchantPaymentAccount::where('merchant_id', $merchant_id)->sum('pay_amount');

         //$total_payment = $total_cod_collected - $merchant_payment - $shipment_cost;
         $total_payment = $total_cod_collected - $shipment_cost;
         /*if(($total_cod_collected - $total_payment) ==  $merchant_payment)
          {
            $total_payment = 0;
          }*/

        if(!empty($merchant_payment_data))
        {
           $start_date = date('d, M Y',strtotime($merchant_payment_data->created_at));
            $end_date = date('d, M Y');
        }
        else
        {
           $start_date = date('d, M Y');
           $end_date = date('d, M Y');
        }

        $sql = Shipments::select(DB::raw('DATE(created_at) as date'), DB::raw('count(created_at) as count'))->where('merchant_id',$merchant_id)->orderBy('created_at','desc');

        $sql1=clone $sql;
        $sql2=clone $sql;
        $sql3=clone $sql;
        $sql4=clone $sql;

        $shipmentlist = $sql->whereIn('status', ['6','7'])->groupBy('date')->paginate(5);

        $resp['completed']= $sql1->whereIn('status', ['6','7'])->count('shipments.id');

        $resp['return']= $sql2->whereIn('status',['8','9'])->count('shipments.id');

        $resp['pending']= $sql3->where('status',0)->count('shipments.id');

        $resp['total']= $sql4->count('shipments.id');


        $resp['start_date'] = $start_date;
        $resp['end_date'] = $end_date;
        $resp['total_cod_collected'] = (int)$total_payment;
        $resp['shipments'] = $shipmentlist;
        $resp['message']="success";
        return response()->json($resp, 200);
    }

   /* public function shippingDatabase(Request $request)
    {
        $sql = DB::table('shipments')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->select('shipments.cod_amount',DB::raw('DATE(dri_shipment_status_logs.created_at) as date'), DB::raw('count(dri_shipment_status_logs.created_at) as count'))->where('shipments.merchant_id',Auth::user()->id)->groupBy('date');
        
        if($request->filter) {
            switch (strtolower($request->filter)) {
                case 'today':
                    $today = Carbon::today()->format('Y-m-d');
                    $sql = $sql->whereDate('shipment_status_logs.created_at',"=", $today);
                    break;
                case 'weekly':
                    $date_from = Carbon::now()->subDays(7)->format('Y-m-d');
                    $date_to = Carbon::today()->format('Y-m-d');
                    $sql = $sql->whereDate('shipment_status_logs.created_at',">=", $date_from)->whereDate('shipment_status_logs.created_at',"<=", $date_to);
                    break;
                case 'monthly':
                    $date_from = Carbon::now()->subDays(30)->format('Y-m-d');
                    $date_to = Carbon::today()->format('Y-m-d');
                    $sql = $sql->whereDate('shipment_status_logs.created_at',">=", $date_from)->whereDate('shipment_status_logs.created_at',"<=", $date_to);
                    break;
            }      

        }

        else if($request->from_date && $request->to_date) {
                    $date_from = date('Y-m-d', strtotime($request->from_date));
                    $date_to = date('Y-m-d', strtotime($request->to_date));
                    $sql = $sql->whereDate('shipment_status_logs.created_at',">=", $date_from)->whereDate('shipment_status_logs.created_at',"<=", $date_to);
        }

        $sql1=clone $sql;
        $sql2=clone $sql;

        $total_sales = $sql1->whereIn('shipment_status_logs.status', ['6','7'])->get();
        $return_sales = $sql2->whereIn('shipment_status_logs.status', ['8','9'])->get();


        $cod_collected = 0;
        $total = [];
        if(!empty($total_sales))
        {
            foreach ($total_sales as $key => $value) {
              $cod_collected += $value->cod_amount;
              $total_sales[$key]->total_sales = $value->count;
              unset($value->cod_amount);
              unset($value->count);
            }
        }
        if(!empty($return_sales))
        {
            foreach ($return_sales as $key => $value) {
              $return_sales[$key] = $value;
              $return_sales[$key]->return_sales = $value->count;
              unset($value->cod_amount);
              unset($value->count);
            }
        }

        $resp['delivery_amount']= $cod_collected;
        $resp['total_sales']= $total_sales;
        $resp['return_sales']= $return_sales;

        $resp['message']="success";
        return response()->json($resp, 200);
    }*/

     public function shippingDatabase(Request $request)
    {
        //return Auth::user()->id;
      //DB::enableQueryLog();

        if($request->filter) {

           $sql = Shipments::join(DB::raw('(select shipment_id, Max(created_at) as date,count(created_at) as count from dri_shipment_assign_status GROUP BY shipment_id) max_user'),'shipment_id','shipments.id', DB::raw('count(dri_shipment_status_logs.created_at) as count'))->select('shipments.*','date as date','count as count')->where('merchant_id',Auth::user()->id);

            switch (strtolower($request->filter)) {
                case 'today':
                    $today = Carbon::today()->format('Y-m-d');
                    /*$sql =  DB::table('shipments')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->select('shipments.cod_amount',DB::raw('DATE(dri_shipment_status_logs.created_at) as date'), DB::raw('count(dri_shipment_status_logs.created_at) as count'))->where('shipments.merchant_id',Auth::user()->id)->whereDate('shipment_status_logs.created_at',"=", $today);*/
                    $sql = $sql->whereDate(DB::raw('max_user.date'),"=", $today);
                    break;
                case 'weekly':
                    /*$date_from = Carbon::now()->subDays(7)->format('Y-m-d');
                    $date_to = Carbon::today()->format('Y-m-d');
                    $sql = DB::table('shipments')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->select('shipments.cod_amount',DB::raw('DATE(dri_shipment_status_logs.created_at) as date'), DB::raw('count(dri_shipment_status_logs.created_at) as count'))->whereDate('shipment_status_logs.created_at',">=", $date_from)->whereDate('shipment_status_logs.created_at',"<=", $date_to)->where('shipments.merchant_id',Auth::user()->id)->groupBy(DB::raw('DATE_FORMAT(dri_shipment_status_logs.created_at,"%a")'));*/

                     /*$dto = new DateTime();
                     $week = $dto->format("W");
                     $year = $dto->format("Y");
                     $dto->setISODate($year,$week);
                     $date_from = $dto->format('Y-m-d');
                     $dto->modify('+6 days');
                     $date_to = $dto->format('Y-m-d');*/
                     $now = Carbon::now();
                     $date_from = $now->startOfWeek()->format('Y-m-d');
                     $date_to = $now->endOfWeek()->format('Y-m-d');
                     $sql = $sql->whereDate(DB::raw('max_user.date'),">=", $date_from)->whereDate(DB::raw('max_user.date'),"<=", $date_to);
                    break;
                case 'monthly':
                    /*$date_from = Carbon::now()->subDays(365)->format('Y-m-d');
                    $date_to = Carbon::today()->format('Y-m-d');*/
                   /* $sql = DB::table('shipments')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->select('shipments.cod_amount',DB::raw('DATE_FORMAT(dri_shipment_status_logs.created_at,"%b") as month'), DB::raw('count(dri_shipment_status_logs.created_at) as count'))->whereDate('shipment_status_logs.created_at',">=", $date_from)->whereDate('shipment_status_logs.created_at',"<=", $date_to)->where('shipments.merchant_id',Auth::user()->id)->groupBy(DB::raw('DATE_FORMAT(dri_shipment_status_logs.created_at,"%b")'));*/

                    /*$sql = DB::table('shipments')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->select('shipments.cod_amount')->whereDate('shipment_status_logs.created_at',">=", $date_from)->whereDate('shipment_status_logs.created_at',"<=", $date_to)->where('shipments.merchant_id',Auth::user()->id);*/

                    $date = Date('F, Y'); 
                    $date_from = date('Y-m-01', strtotime($date));
                    $date_to = date('Y-m-t', strtotime($date)); 
                    $sql = $sql->whereDate(DB::raw('max_user.date'),">=", $date_from)->whereDate(DB::raw('max_user.date'),"<=", $date_to);

                    break;
            }      

        }



        $sql1=clone $sql;
        $sql2=clone $sql;

        $total_sales = $sql1->whereIn('shipments.status', ['6','7'])->get();
        $return_sales = $sql2->whereIn('shipments.status', ['8','9'])->get();


        //dd(DB::getQueryLog());

        $cod_collected = 0;
        $total = [];
        if(!empty($total_sales))
        {
            foreach ($total_sales as $key => $value) {
               $cod_collected += $value['cod_amount'];
            }
        }
  
        $total_sales_count = count($total_sales);
        $return_sales_count = count($return_sales);
        $count_max= max($total_sales_count,$return_sales_count);
        if($count_max != 0)
        {
           for($i=0;$i<$count_max;$i++)
          {
            $result[$i]['date'] = @$return_sales[$i]->date?@$return_sales[$i]->date:@$total_sales[$i]->date;
            $result[$i]['date'] = date('Y-m-d',strtotime($result[$i]['date']));
            $result[$i]['total_sales'] = @$total_sales[$i]->count?@$total_sales[$i]->count:0;
            $result[$i]['return_sales'] = @$return_sales[$i]->count?@$return_sales[$i]->count:0;
          }
        }
        else
        {
          $result = array(array('date' => '', 'total_sales' => 0, 'return_sales' => 0));
        }
       
        //$result = array_merge_recursive($total_sales, $return_sales);
          $graph=[];
        if(!empty($request->filter) && $request->filter == 'monthly'){
           $loopperiod = 12; 

           for($i=1; $i <= $loopperiod ; $i++) 
                { 

                    $month = date('M', mktime(0,0,0,$i, 1, date('Y')));
                    $date_from = date('Y-m-01', mktime(0,0,0,$i, 1, date('Y')));
                    $date_to  = date("Y-m-t", mktime(0,0,0,$i, 1, date('Y')));
                    /*$sqlmonth = DB::table('shipments')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->whereDate('shipment_status_logs.created_at',">=", $date_from)->whereDate('shipment_status_logs.created_at',"<=", $date_to)->where('shipments.merchant_id',Auth::user()->id);*/
                   $sqlmonth = Shipments::join(DB::raw('(select shipment_id, Max(created_at) as date from dri_shipment_assign_status GROUP BY shipment_id) max_user'),'shipment_id','shipments.id')->select('shipments.*','date')->where('merchant_id',Auth::user()->id)->whereDate(DB::raw('max_user.date'),">=", $date_from)->whereDate(DB::raw('max_user.date'),"<=", $date_to);

                     $sql1=clone $sqlmonth;

                    $total_sales = $sqlmonth->whereIn('shipments.status', ['6','7'])->count('shipments.id');
                    $return_sales = $sql1->whereIn('shipments.status', ['8','9'])->count('shipments.id');

                        $graph_array = array(
                         'date' => $month,
                         'total_sales' => $total_sales,
                         'return_sales' => $return_sales,
                        );
                        array_push($graph, $graph_array);
                }

        }
        if(!empty($request->filter) && $request->filter == 'weekly'){
          // print_r($result );die;
         // $result = array_merge_recursive($total_sales, $return_sales);
           $loopperiod = 7; 
           $now = Carbon::now();
           $start_date = $now->startOfWeek()->format('Y-m-d');
           $end_date = $now->endOfWeek()->format('Y-m-d');
           /*$interval = DateInterval::createFromDateString('1 day');
           $period = new DatePeriod($start_date, $interval, $end_date);*/


           $begin = new DateTime($start_date);
           $end = new DateTime($end_date);

           $interval = DateInterval::createFromDateString('1 day');
           $period = new DatePeriod($begin, $interval, $end);

           //for($i=0; $i < $loopperiod ; $i++) 
            for($dt = $begin; $dt <= $end; $dt->modify('+1 day')){
                { 
                    //$date = date("d M", strtotime("-$i day")); 
                    //$date = date("Y-m-d", strtotime("-$i day"));
                    $date = $dt->format("Y-m-d");
                    $userfind = array_search($date, array_column($result, 'date'));
                    $returnsalesfind = array_search($date, array_column($result, 'date'));
                    /*$redate = date("d M", strtotime("-$i day")); 
                    $day = date("D", strtotime("-$i day")); */
                    $redate = $dt->format("d M");
                    $day = $dt->format("D"); 
                   
                    if (false !== $userfind) {
                        $graph_array = array(
                         //'current_date' => $user[$userfind]['current_date'],
                         'date' => $day,
                         'total_sales' => (!empty($result[$userfind]['total_sales']))?$result[$userfind]['total_sales']:0,
                         'return_sales' => (!empty($result[$returnsalesfind]['return_sales']))?$result[$returnsalesfind]['return_sales']:0,
                        );
                         array_push($graph, $graph_array);
                    }
                    else
                    {
                        $json=  array(
                            'date' => $day,
                            'total_sales' => 0,
                            'return_sales' => 0,
                        );
                        array_push($graph, (object)$json); 
                    }
                }
                //$resp['graph']= $graph;

              /*$cod_collected = DB::table('shipments')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->select('shipments.cod_amount')->whereDate('shipment_status_logs.created_at',">=", $date_from)->whereDate('shipment_status_logs.created_at',"<=", $date_to)->where('shipments.merchant_id',Auth::user()->id)->whereIn('shipment_status_logs.status', ['6','7'])->sum('cod_amount');*/

              $cod_collected = Shipments::join(DB::raw('(select shipment_id, Max(created_at) as date from dri_shipment_assign_status GROUP BY shipment_id) max_user'),'shipment_id','shipments.id')->select('shipments.*','date')->where('merchant_id',Auth::user()->id)->whereDate(DB::raw('max_user.date'),">=", $date_from)->whereDate(DB::raw('max_user.date'),"<=", $date_to)->whereIn('shipments.status', ['6','7'])->sum('cod_amount');

        } }
        if(!empty($request->filter) && $request->filter == 'today'){
          
           $cod_collected =  Shipments::join(DB::raw('(select shipment_id, Max(created_at) as date from dri_shipment_assign_status GROUP BY shipment_id) max_user'),'shipment_id','shipments.id')->select('shipments.*','date')->where('merchant_id',Auth::user()->id)->whereDate(DB::raw('max_user.date'),"=", $today)->whereIn('shipments.status', ['6','7'])->sum('cod_amount');

          $graph = @$result;
        }
  
        $resp['result']= $graph;
        $resp['delivery_amount']= (int)$cod_collected;
        /*$resp['total_sales']= $total_sales;
        $resp['return_sales']= $return_sales;*/

        $resp['message']="success";
        return response()->json($resp, 200);
    }

    
     public function paymentbreakdown(Request $request)
    {
       

        /*$sql = Shipments::select('shipments.*')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->where('shipments.merchant_id',Auth::user()->id)->groupBy('shipment_status_logs.shipment_id')->groupBy('shipment_status_logs.status');*/

        $sql = Shipments::join(DB::raw('(select shipment_id, Max(created_at) as date from dri_shipment_assign_status GROUP BY shipment_id) max_user'),'shipment_id','shipments.id')->select('shipments.*','date as created_at','date as max_date')->where('merchant_id',Auth::user()->id);

         $sql7=clone $sql;
         $sql8=clone $sql;

       // $total_cod_collected = Shipments::select('shipment_no','receiver_name','product_detail','cod_amount','created_at')->where('merchant_id', Auth::user()->id)->whereIn('status', ['6','7'])->sum('cod_amount');

        //$merchant_payment = MerchantPaymentAccount::where('merchant_id', Auth::user()->id)->sum('pay_amount');
         
       $shipment_ids = MerchantPaymentAccount::where('merchant_id', Auth::user()->id)->where('status', "1")->pluck('shipment_id')->toArray();
       $merchantgetdata = Shipments::where('merchant_id',Auth::user()->id)->whereIn('id',$shipment_ids)->whereIn('status',['6','7'])->orderBy('created_at','desc')->get();

       $merchant_payment = $m_cod_amount = $m_shipment_cost = 0;
        if(!empty($merchantgetdata))
        {
            foreach ($merchantgetdata as $key => $value) {
              $m_cod_amount += $value->cod_amount;
              if($value->cod_amount != 0)
              {
                 $m_shipment_cost += $value->shipment_cost;
              } 
            }
        }
           $merchant_payment = $m_cod_amount - $m_shipment_cost;

        //$drivills_commissions= $sql8->whereIn('shipment_status_logs.status', ['6','7'])->get();
        $drivills_commissions= $sql8->whereNotIn('id',$shipment_ids)->whereIn('shipments.status', ['6','7'])->get();

         $drivills_commission = $total_cod_collected = 0;
        if(!empty($drivills_commissions))
        {
            foreach ($drivills_commissions as $key => $value) {
              $total_cod_collected += $value->cod_amount;
              $drivills_commission += $value->shipment_cost;
            }
        }

        //$resp['available_payout'] = $total_cod_collected - $merchant_payment -  $drivills_commission;

        $resp['available_payout'] = (int)($total_cod_collected - $drivills_commission);

        $resp['drivills_commission'] = (int)$drivills_commission;
        if($resp['available_payout'] ==  $resp['drivills_commission'])
        {
          $resp['available_payout'] = 0;
        }
        
        if($request->filter) {
            switch (strtolower($request->filter)) {
                case 'today':
                    $today = Carbon::today()->format('Y-m-d');
                    //$sql = $sql->whereDate('shipment_status_logs.created_at',"=", $today);
                    $sql = $sql->whereDate(DB::raw('max_user.date'),"=", $today);
                    break;
                case 'weekly':
                    /*$date_from = Carbon::now()->subDays(7)->format('Y-m-d');
                    $date_to = Carbon::today()->format('Y-m-d');*/
                     $dto = new DateTime();
                     $week = $dto->format("W");
                     $year = $dto->format("Y");
                     $dto->setISODate($year,$week);
                     $date_from = $dto->format('Y-m-d');
                     $dto->modify('+6 days');
                     $date_to = $dto->format('Y-m-d');
                    $sql = $sql->whereDate(DB::raw('max_user.date'),">=", $date_from)->whereDate(DB::raw('max_user.date'),"<=", $date_to);
                    /*$sql = $sql->whereDate('shipment_status_logs.created_at',">=", $date_from)->whereDate('shipment_status_logs.created_at',"<=", $date_to);*/
                    break;
                case 'monthly':
                   /* $date_from = Carbon::now()->subDays(30)->format('Y-m-d');
                    $date_to = Carbon::today()->format('Y-m-d');
                    $sql = $sql->whereDate('shipment_status_logs.created_at',">=", $date_from)->whereDate('shipment_status_logs.created_at',"<=", $date_to);*/
                    $date = Date('F, Y'); 
                    $date_from = date('Y-m-01', strtotime($date));
                    $date_to = date('Y-m-t', strtotime($date)); 
                    $sql = $sql->whereDate(DB::raw('max_user.date'),">=", $date_from)->whereDate(DB::raw('max_user.date'),"<=", $date_to);
                    break;
            }      

        }

        else if($request->from_date && $request->to_date) {
                    $date_from = date('Y-m-d', strtotime($request->from_date));
                    $date_to = date('Y-m-d', strtotime($request->to_date));
                    /*$sql = $sql->whereDate('shipment_status_logs.created_at',">=", $date_from)->whereDate('shipment_status_logs.created_at',"<=", $date_to);*/
                    $sql = $sql->whereDate(DB::raw('max_user.date'),">=", $date_from)->whereDate(DB::raw('max_user.date'),"<=", $date_to);
        }

        $sql1=clone $sql;
        $sql2=clone $sql;
        $sql3=clone $sql;
        $sql4=clone $sql;
        $sql5=clone $sql;
        $sql6=clone $sql;
        
        //$resp['picked_up']= count($sql->where('shipment_status_logs.status', 3)->get());

        $resp['delivered']= count($sql1->whereIn('shipments.status', ['6','7'])->get());

        $resp['cancelled']= count($sql2->where('shipments.status',8)->get());

        $resp['pending']= count($sql3->where('shipments.status',0)->get());

        $resp['shipped']= count($sql4->where('shipments.status', 5)->get());
       
        $getdata = $sql1->whereIn('shipments.status', ['6','7'])->get();
        $available_payout = $shipment_cost = 0;
        if(!empty($getdata))
        {
            foreach ($getdata as $key => $value) {
              $available_payout += $value->cod_amount;
              $shipment_cost += $value->shipment_cost;
            }
        }
        //$resp['cod_to_deposit']= $cod_to_deposit - $riderpayment;
       /* $merchantwithdrow = MerchantDepositAmount::where('merchant_id', Auth::user()->id)->where('status', "1")->sum('amount');

        $resp['total_cod_earned']= $available_payout - $merchantwithdrow;*/

        /*$available_payout = $sql5->whereIn('shipment_status_logs.status', ['6','7'])->sum('cod_amount');

        $drivill_service_charge = $sql6->whereIn('shipment_status_logs.status', ['6','7'])->sum('shipment_cost');*/

        $drivill_service_charge = $shipment_cost;

        //$resp['drivills_commission']= $drivill_service_charge;
       /*if($request->filter == 'today')
        {
          $resp['total_available_for_payout']= $available_payout - $drivill_service_charge;
        }
        else
        {
           if($available_payout > 0 && $drivill_service_charge > 0)
           {            
              //$resp['total_available_for_payout']= abs($available_payout - $drivill_service_charge - $merchant_payment);
              $resp['total_available_for_payout']= abs($available_payout - $drivill_service_charge);
              $resp['total_available_for_payout']= abs($resp['available_payout']);
           }
           else
           {
              $resp['total_available_for_payout']= $available_payout - $drivill_service_charge;
           } 
        }*/
        
        $resp['total_available_for_payout']= (int)abs($resp['available_payout']);

        $resp['refund_from_drivill']= (int)($available_payout - $drivill_service_charge);

        $resp['cash_collected'] = (int)$available_payout;

        $resp['drivill_service_charge']= (int)$drivill_service_charge;

        $resp['message']="success";
        return response()->json($resp, 200);
    }

     public function withdrawRequest()
    {
        try{

           $amount = Shipments::select('shipments.*')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->where('shipments.merchant_id',Auth::user()->id)->groupBy('shipment_status_logs.shipment_id')->groupBy('shipment_status_logs.status')->whereIn('shipment_status_logs.status', ['6','7'])->sum('cod_amount');

           $drivills_commissions = Shipments::select('shipments.*')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->where('shipments.merchant_id',Auth::user()->id)->groupBy('shipment_status_logs.shipment_id')->groupBy('shipment_status_logs.status')->whereIn('shipment_status_logs.status', ['6','7'])->get();

          $total_cod_collected = Shipments::select('shipment_no','receiver_name','product_detail','cod_amount','created_at')->where('merchant_id', Auth::user()->id)->whereIn('status', ['6','7'])->sum('cod_amount');

          $merchant_payment = MerchantPaymentAccount::where('merchant_id', Auth::user()->id)->sum('pay_amount');

           $drivills_commission = 0;
          if(!empty($drivills_commissions))
          {
              foreach ($drivills_commissions as $key => $value) {
                $drivills_commission += $value->shipment_cost;
              }
          }

            $available_payout = $total_cod_collected - $merchant_payment -  $drivills_commission;
            if($available_payout < 100)
            {
               return response()->json(['error' => 'Withdraw limit should be minimum 100Tk.'], 404);
            }

            $today_date = date('Y-m-d');
            $alreadyexist = MerchantWithdrawRequest::where('merchant_id',Auth::user()->id)->whereDate('created_at',"=", $today_date)->first();
            if(!empty($alreadyexist))
            {
               return response()->json(['error' => 'Today you already sent request'], 404);
            }

            $withdrawRequest = New MerchantWithdrawRequest;
            $withdrawRequest->merchant_id = Auth::user()->id; 
            $withdrawRequest->amount = $amount; 
            $withdrawRequest->save();
            return response()->json(['message' =>'Withdraw Request Sent Successfully'],200);
        }catch(ModelNotFoundException $m){
             return response()->json(['error' => 'Withdraw Request Not found'], 404);
        }catch (Exception $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }

    }

     public function complain(Request $request)
    {

    $this->validate($request, [            
            'shipment_id' => 'required',            
            'complain' => 'required',            
        ]);

        try{
            $already = Help::where('shipment_id',$request->shipment_id)->where('merchant_id',Auth::user()->id)->get();
            if(count($already) > 0)
            {
               return response()->json(['error' => 'Complain already sent for these shipment'], 400);
            }
            $help = New Help;       
            $help->merchant_id = Auth::user()->id; 
            $help->shipment_id = $request->shipment_id; 
            $help->complain = $request->complain; 
            $help->save();
             return response()->json(['message' =>'Complain Saved Successfully','data'=>$help],200);
            }
        catch (Exception $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }
    }

    public function weightProductList()
    {
      $data['product_type'] = ProductType::where('status','Active')->get();
      $weight = array(
        array('id' => '500 GM', 'name' => '500 GM'),
        array('id' => '1 KG', 'name' => '1 KG'),
        array('id' => '2 KG', 'name' => '2 KG'),
        array('id' => '3 KG', 'name' => '3 KG'),
        array('id' => '4 KG', 'name' => '4 KG'),
        array('id' => '5 KG', 'name' => '5 KG'),
        array('id' => '6 KG', 'name' => '6 KG'),
        array('id' => '7 KG', 'name' => '7 KG'),
        array('id' => 'Upto 7 KG', 'name' => 'Upto 7 KG'),
      );
     /* $weight = array(
        array('id' => 1, 'name' => '500 GM'),
        array('id' => 2, 'name' => '1 KG'),
        array('id' => 3, 'name' => '2 KG'),
        array('id' => 4, 'name' => '3 KG'),
        array('id' => 5, 'name' => '4 KG'),
        array('id' => 6, 'name' => '5 KG'),
        array('id' => 7, 'name' => '6 KG'),
        array('id' => 8, 'name' => '7 KG'),
        array('id' => 9, 'name' => 'Upto 7 KG'),
      );*/
      $data['weight_list'] = $weight;
      return response()->json(['message' =>'list loaded Successfully','data'=>$data],200);
    }

     public function notificationList()
    {
      $data = ShipNotification::select('ship_notifications.id','ship_notifications.rider_id','ship_notifications.shipment_id','ship_notifications.is_viewed','ship_notifications.created_at','notifications.message','notifications.id as noti_id')->join('notifications','notifications.id','=','ship_notifications.notification_id')->where('merchant_id', Auth::user()->id)->orderBy('created_at','desc')->get();
      if(!empty($data))
      {
        foreach ($data as $key => $value) {
          $shipment = Shipments::find($value->shipment_id);
          $rider = DeliveryRiders::find($value->rider_id);
          $data[$key]->message = str_replace("{{tracking_number}}",$shipment->shipment_no,$value->message);
          $data[$key]->message = str_replace("{{rider_name}}",@$rider->name,$value->message);
          if($value->noti_id == 4)
          {
             $shipment_cost = $shipment->shipment_cost/2;
             $data[$key]->message = str_replace("{{cod_amount}}",'Tk.'.$shipment_cost,$value->message);
          }
          else
          {
            $data[$key]->message = str_replace("{{cod_amount}}",'Tk.'.$shipment->cod_amount,$value->message);
          }
          unset($value->noti_id);
        }
      }
      return response()->json(['message' =>'list loaded Successfully','data'=>$data],200);
    }

    public function notificationRead($notification_id)
    {
       $notification = ShipNotification::find($notification_id);
       $notification->is_viewed = "1";
       $notification->save();
       return response()->json(['message' =>'Notification Read Successfully'],200);
    }
    public function sendNotificaton()
    {
       //$token = "cMPN6PthQK616fS2yEEI5N:APA91bHVjK-Qlt_P38bpi5OnGO6_Bys8GcxwB6fNfvdglOVjkssm_NILGMKb1lo6fdCfYuFgABdL0GSk8g9S3LKrq4pZCWkKLOZIVl60H9htJDl8Wb5FHKqyXzXsNbzwVkQdHFNBP9Iz";

      $token = "cMPN6PthQK616fS2yEEI5N:APA91bEprkwwxps8rWA1W8L0c-Jlh6unaOdCFEgi63_-5KWotQ55SKrlBVu3uuaX2Zm6xhDdpR-gkJAvSDNY0f2Oa6RFErPHSeT4sBlqCm6BjhsBVOzeqQRAx1AxRUptGSiotblSq764";
       $data = array(
         'title' => 'Hello',
         'body' => 'for testing'
       );
       return sendNotification($token,$data);
    }

    public function productViewDetail($txn_id)
    {
       $getAllShipment = MerchantPaymentAccount::where('txn_id',$txn_id)->where('merchant_id',Auth::user()->id)->pluck('shipment_id');
       $shipments = Shipments::select('shipment_no','cod_amount','shipment_cost')->whereIn('id',$getAllShipment)->get();
       return response()->json(['message' =>'list loaded Successfully','data'=>$shipments],200);
    }

    public function account(Request $request)
    {
        $this->validate($request, [            
            'acc_holder_name' => 'required',
            'bank_name' => 'required',
            'branch_name' => 'required',
            'account_number' => 'required',
            //'routing_name' => 'required',
        ],['acc_holder_name.required' => 'The account holder name field is required.']);

        try{
            
            $user = New MerchantAccount; 
            $user->merchant_id = Auth::user()->id; 
            $user->acc_holder_name = $request->acc_holder_name; 
            $user->bank_name = $request->bank_name; 
            $user->branch_name = $request->branch_name; 
            $user->account_number = $request->account_number; 
            $user->routing_name = " "; 
            $user->save(); 
            return response()->json(['message' =>'Account Detail Saved Successfully','data'=>$user],200);
            }
        catch (Exception $e) {
            return response()->json(['error' => 'Error in saving the Account Detail'], 400);
        }
    }
}
