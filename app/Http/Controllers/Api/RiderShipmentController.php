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
use App\models\admin\ProductType;
use Illuminate\Support\Facades\Hash;
use App\Helper\ControllerHelper as Helper;
use App\models\admin\RiderPaymentAccount;
use App\models\admin\RiderDepositAmount;
use App\models\admin\Admin;
use App\models\RiderCurrentLocation;
use App\models\admin\ShipmentReason;
use App\models\admin\DeliveryRiders;
use App\models\ShipmentAssignStatus;
use App\models\ShipNotification;
use App\models\Notification;
use App\models\RiderNotification;
use Auth;
use Storage;
use Validator;
use Carbon\Carbon;
use DB;
use DateTime;

class RiderShipmentController extends Controller
{
     public function index(Request $request)
    {

        $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->groupBy('shipment_id')->pluck('max_id');
        
        $data = Shipments::locationData()->whereHas('rider',function($query)
        {
            $query->where('rider_id',Auth::user()->id);
        })->orderBy('updated_at','desc');

        $data = Shipments::select("shipments.*")->locationData()->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids)->where('rider_id',Auth::user()->id)->orderBy('shipment_assign_status.created_at','desc');
        if($request->status) {
            switch (strtolower($request->status)) {
                case 'pickup':
                    $data= $data->whereIn('shipment_assign_status.status', ['2','3']);
                    break;
                case 'deliver':
                    $data= $data->whereIn('shipment_assign_status.status', ['5','6','7','10','12']);
                    break;
            }            
        }
        $shipments =$data->get();
       /* $resp['picked_up']= Shipments::where('status', 3)->count('id');
        $resp['delivered']= Shipments::whereIn('status', ['6','7'])->count('id');*/
        if(!empty($shipments))
        {
            foreach ($shipments as $key => $value) {
                $product_type = ProductType::find($value->product_type);
                $shipments[$key]->product_type = $product_type->name;
                $shipments[$key]->d_address = FindReturnShipmentAddress($value->id);
            }
        }
        $resp['shipments'] =$shipments;

        $resp['message']="success";
        return response()->json($resp, 200);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        try{
            $shipment = Shipments::locationData()->with('rider.rider')->where('id',$id)
            ->whereHas('rider',function($query)
            {
                $query->where('rider_id',Auth::user()->id);
            })->firstOrFail();
            $shipment->status_logs = ShipmentStatusLog::where('shipment_id',$shipment->id)->get();
            $product_type = ProductType::find($shipment->product_type);
            $shipment->product_type = $product_type->name;
            return response()->json(['message' =>'success','data'=>$shipment],200);
        }catch(ModelNotFoundException $m){
             return response()->json(['error' => 'shipment not found'], 404);
        }catch (Exception $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }
    }

    public function status_update(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'id' => 'required|exists:shipments,id',
            //'status' => 'required|in:3,4,6,7'
            'status' => 'required|in:3,4,6,7,10'
            ],['otp.exists'=>'Please provide valid otp.']);

        /*$validator->sometimes('otp', 'required|integer|exists:shipments,otp', function($input) {
            return ($input->status == 3 || $input->status == 6);
        });*/

        $validator->sometimes('otp', 'required|integer|exists:shipments,otp', function($input) {
            return $input->status == 6;
        });
        if($validator->fails()) {
            return response()->json(["message"=> "The given data was invalid.",'errors' => $validator->errors()->all()],419); 
        }
        try{
            $shipment = Shipments::where('id',$request->id)
            ->whereHas('rider',function($query)
            {
                $query->where('rider_id',Auth::user()->id);
            })->firstOrFail();
            $shipment->status=$request->status;
            $shipment->save();
            $assign = ShipmentAssignStatus::where('shipment_id',$shipment->id)->orderBy('id','desc')->first();
             if($request->status != 10) {
             ShipmentAssignStatus::create([
                      'shipment_id'=>$shipment->id,
                      'hub_id'=>$assign->hub_id,
                      'rider_id'=> Auth::user()->id,
                      'status'=>$shipment->status
                   ]);
               }

            $note = ($request->status == 10)?'Shipment Cancelled By Customer':'Shipment '.shipment_status($request->status).' By Rider';
            $shipment->status_log = ShipmentStatusLog::create([
                'shipment_id'=>$shipment->id,
                'status'=>$request->status,
                'updated_by'=>($request->status == 10)?'Customer':'Rider',
                'updated_by_id'=>Auth::user()->id,
                'updated_ip'=>$request->ip(),
                'reason'=>@$request->reason,
                'note'=> $note
            ]);
            if($request->status == 6) {
                  $assign = ShipmentAssignStatus::where('shipment_id',$shipment->id)->orderBy('id','desc')->first();
                  
                  $noti = New ShipNotification;
                  $noti->shipment_id = $shipment->id;
                  $noti->merchant_id = $shipment->merchant_id;
                  $noti->rider_id = Auth::user()->id;
                  $noti->notification_id = 3;
                  $noti->hub_id = $assign->hub_id;
                  $noti->save();
 
                  // send push notification
                  $notification = Notification::find(3);
                  $notification->message = str_replace("{{tracking_number}}",$shipment->shipment_no,$notification->message);
                  $notification->message = str_replace("{{rider_name}}",Auth::user()->name,$notification->message);
                  $notification->message = str_replace("{{cod_amount}}",'Tk.'.$shipment->cod_amount,$notification->message);
                  $merchant = Merchants::find($shipment->merchant_id);
                  $data = array('title' => 'Shipment Delivered','body' => $notification->message);
                  sendNotification($merchant->device_token,$data);

            }
              if($request->status == 10) {
                  $notification = Notification::find(5);
                  $notification->message = str_replace("{{tracking_number}}",$shipment->shipment_no,$notification->message);
                  $notification->message = str_replace("{{rider_name}}",Auth::user()->name,$notification->message);
                  $mobile=$shipment->contact_no;
                  sendSms($mobile,$notification->message);

                  //$push_noti = Notification::find(6);
                  $push_noti = Notification::find(9);
                  $push_noti->message = str_replace("{{rider_phone_name}}",Auth::user()->mobile,$push_noti->message);
                  $push_noti->message = str_replace("{{tracking_number}}",$shipment->shipment_no,$push_noti->message);
                  $push_noti->message = str_replace("{{rider_name}}",Auth::user()->name,$push_noti->message);
                  $push_noti->message = str_replace("{{cod_amount}}",'Tk.'.$shipment->cod_amount,$push_noti->message);
                  $merchant = Merchants::find($shipment->merchant_id);
                  $data = array('title' => 'Delivery attempt failed','body' => $push_noti->message);
                  sendNotification($merchant->device_token,$data);

                  $assign = ShipmentAssignStatus::where('shipment_id',$shipment->id)->orderBy('id','desc')->first();
                  $noti = New ShipNotification;
                  $noti->shipment_id = $shipment->id;
                  $noti->merchant_id = $shipment->merchant_id;
                  $noti->rider_id = Auth::user()->id;
                  $noti->notification_id = 9;
                  $noti->hub_id = $assign->hub_id;
                  $noti->save();

              }
            return response()->json(['message' =>'Status updated successfully','data'=>$shipment],200);
        }catch(ModelNotFoundException $m){
             return response()->json(['error' => 'shipment not found'], 404);
        }catch (Exception $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }
    }


      /*
    |---------------------------------
    | Shipment cancelled by merchant
    |---------------------------------
    */

    public function cancel_reasons(Request $request)
      {
        $data['cancel_reasons'] = ShipmentReason::where('reason_for',2)->latest()->get();
        $data['message'] =$data['cancel_reasons']?"success":"No Record found";
        return response()->json($data, 200);
      }

    public function cancel(Request $request)
    {
        $this->validate($request, [            
            'id' => 'required|exists:shipments,id',
            'reason' => 'required|max:255'
        ]);
        try{
            $shipment=Shipments::where('id',$request->id)->whereHas('rider',function($query)
            {
                $query->where('rider_id',Auth::user()->id);
            })->firstOrFail();
            $shipment->status='12';
           /* if($request->reason == "Customer Not Available")
            {
              $shipment->status='10';
            }
            else
            {
              $shipment->status='8';
            }*/
            $shipment->save();
            
           /* $assign = ShipmentAssignStatus::where('shipment_id',$shipment->id)->orderBy('id','desc')->first();
            ShipmentAssignStatus::create([
                  'shipment_id'=>$shipment->id,
                  'hub_id'=>$assign->hub_id,
                  'rider_id'=> $assign->rider_id,
                  'status'=>$shipment->status
               ]);*/

            $shipment->status_log= ShipmentStatusLog::create([
                'shipment_id'=>$shipment->id,
                //'status'=>($request->reason == "Customer Not Available")?10:8,
                'status'=>12,
                'updated_by'=>"Customer",
                'updated_by_id'=>Auth::user()->id,
                'updated_ip'=>$request->ip(),
                'reason'=>$request->reason,
                'note'=>'Shipment Cancelled By Customer'
            ]);

                  $assign = ShipmentAssignStatus::where('shipment_id',$shipment->id)->orderBy('id','desc')->first();
                  $noti = New ShipNotification;
                  $noti->shipment_id = $shipment->id;
                  $noti->merchant_id = $shipment->merchant_id;
                  $noti->rider_id = Auth::user()->id;
                  $noti->notification_id = 4;
                  $noti->hub_id = $assign->hub_id;
                  $noti->save();

                  // send push notification
                  $notification = Notification::find(4);
                  $notification->message = str_replace("{{tracking_number}}",$shipment->shipment_no,$notification->message);
                  $notification->message = str_replace("{{rider_name}}",Auth::user()->name,$notification->message);
                  $notification->message = str_replace("{{cod_amount}}",'Tk.'.$shipment->cod_amount,$notification->message);
                  $merchant = Merchants::find($shipment->merchant_id);
                  $data = array('title' => 'Shipment Cancelled','body' => $notification->message);
                  sendNotification($merchant->device_token,$data);

            return response()->json(['message' =>'Shipment Cancelled Successfully','data'=>$shipment],200);
        }catch(ModelNotFoundException $m){
             return response()->json(['error' => 'shipment not found'], 404);
        }catch (Exception $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }

    }

     public function ridingStatement(Request $request)
    {
        /*$this->validate($request, [            
            'filter' => 'required'
        ]);*/
        //DB::enableQueryLog();

        /*$sql = Shipments::select('shipments.*')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->where('shipment_assign_status.rider_id',Auth::user()->id)->groupBy('shipment_assign_status.shipment_id');*/

        $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->groupBy('shipment_id')->pluck('max_id');

        $sql = Shipments::select('shipments.*')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids)->where('rider_id',Auth::user()->id);
        
        if($request->filter) {
            switch (strtolower($request->filter)) {
                case 'today':
                    $today = Carbon::today()->format('Y-m-d');
                    $sql = $sql->whereDate('shipment_assign_status.created_at',"=", $today);
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
                    $sql = $sql->whereDate('shipment_assign_status.created_at',">=", $date_from)->whereDate('shipment_assign_status.created_at',"<=", $date_to);
                    break;
                case 'monthly':
                    /*$date_from = Carbon::now()->subDays(30)->format('Y-m-d');
                    $date_to = Carbon::today()->format('Y-m-d');*/
                    $date = Date('F, Y'); 
                    $date_from = date('Y-m-01', strtotime($date));
                    $date_to = date('Y-m-t', strtotime($date)); 
                    $sql = $sql->whereDate('shipment_assign_status.created_at',">=", $date_from)->whereDate('shipment_assign_status.created_at',"<=", $date_to);
                    break;
            }      

        }

        else if($request->from_date && $request->to_date) {
                    $date_from = date('Y-m-d', strtotime($request->from_date));
                    $date_to = date('Y-m-d', strtotime($request->to_date));
                    $sql = $sql->whereDate('shipment_assign_status.created_at',">=", $date_from)->whereDate('shipment_assign_status.created_at',"<=", $date_to);
        }

        $sql1=clone $sql;
        $sql2=clone $sql;
        $sql3=clone $sql;
        
        $resp['picked_up']= count($sql->where('shipments.status', 3)->get());

        $resp['delivered']= count($sql1->whereIn('shipments.status', ['6','7'])->get());

        $resp['cancelled']= count($sql2->where('shipments.status',8)->get());

        $resp['pending']= count($sql3->where('shipments.status',0)->get());

        /*$resp['total_cod_earned']= $sql1->sum('cod_amount');

        $resp['total_cod_collected']= $sql1->sum('cod_amount');*/
        $cod_collected = 0;
        $getdata = $sql1->get();
        if(!empty($getdata))
        {
            foreach ($getdata as $key => $value) {
              $cod_collected += $value->cod_amount;
            }
        }

        $riderpayment = RiderPaymentAccount::where('rider_id', Auth::user()->id)->sum('pay_amount');
        $riderdeposite = RiderDepositAmount::where('rider_id', Auth::user()->id)->where('status', "1")->sum('amount');
        $resp['total_cod_earned']= $cod_collected;

        $resp['total_cod_collected']= $riderdeposite;
        //dd(DB::getQueryLog());

        $resp['message']="success";
        return response()->json($resp, 200);
    }

   
    /*public function paymentHistory()
    {
        //return Auth::user()->id;
        $data = Shipments::whereHas('rider',function($query)
        {
            $query->select('created_at')->where('rider_id',Auth::user()->id);
        })->orderBy('created_at','desc')->whereIn('status', ['6','7'])->get();
   
        $rdata = [];
        if(!empty($data))
        {
            foreach ($data as $key => $value) {
              $merchant = Merchants::select('payment_methods.name')->join('payment_methods','merchants.payment_method','=','payment_methods.id')->where('merchants.id',$value->merchant_id)->first();

              $statuslog = ShipmentStatusLog::where('id',$value->id)->first();

              $rdata[$key]['shipment_no'] = $value->shipment_no;
              $rdata[$key]['receiver_name'] = $value->receiver_name;
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
        //$rider_id = 27;
        $rider_id = Auth::user()->id;
        $data = RiderPaymentAccount::select('rider_payment_accounts.*')->where('rider_id', $rider_id)->orderBy('created_at','desc')->paginate(1);
        $rdata = [];
        if(!empty($data))
        {
            foreach ($data as $key => $value) {
              $admin = Admin::where('id',$value->paid_by)->first();
              $data[$key]['shipment_no'] = $value->txn_id;
              $data[$key]['paid_by'] = $admin->name;
              $data[$key]['cod_amount'] = $value->pay_amount;
              $data[$key]['date'] = $value->created_at;
              $data[$key]['payment_method'] = ($value->payment_mode == 0)?"Cash":"Card Payment";
              unset($value->payment_mode);
              unset($value->shipment_id);
              unset($value->rider_id);
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

    public function codStatement()
    {
        $rider_id = Auth::user()->id;
        //$rider_id = 43;
        /*$riderlastpayment = RiderPaymentAccount::select('rider_payment_accounts.*')->where('rider_id', $rider_id)->orderBy('created_at','desc')->first();

        $riderLastPaymentDate = $riderlastpayment->created_at;*/

        /*$data = Shipments::locationData()->whereHas('rider',function($query)
        {
            $query->where('rider_id',Auth::user()->id);
        })->orderBy('created_at','desc')->whereIn('status', ['6','7'])->paginate(5);*/


        $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->groupBy('shipment_id')->pluck('max_id');

        $data = Shipments::select('shipments.*')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids)->where('rider_id',Auth::user()->id)->whereIn('shipments.status', ['6','7'])->orderBy('shipment_assign_status.created_at','desc')->paginate(20);
        

      /*  $data = Shipments::select('shipment_no','receiver_name','product_detail','cod_amount','created_at')->whereHas('rider',function($query)
        {
            $query->where('rider_id',Auth::user()->id);
        })->orderBy('created_at','desc')->whereIn('status', ['6','7'])->paginate(1);*/
   
        $rdata = [];
        //print_r($data['data']);die;
        if(!empty($data))
        {
            foreach ($data as $key => $value) {
              $data[$key]['shipment_no'] = $value->shipment_no;
              $data[$key]['delivered_to'] = $value->receiver_name;
              $data[$key]['product_detail'] = $value->product_detail;
              $data[$key]['cod_amount'] = $value->cod_amount;
              $data[$key]['date'] = $value->created_at->setTimezone('Asia/Dhaka')->format('d M Y h:i A');;
              //unset($value->receiver_name);
              //unset($value->created_at);
            }
        }

        $resp['history'] = $data;

        $riderpayment = RiderPaymentAccount::where('rider_id', $rider_id)->where('status','1')->sum('pay_amount');

        /*$getdata = Shipments::select('shipments.*')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->where('shipment_assign_status.rider_id',Auth::user()->id)->groupBy('shipment_assign_status.shipment_id')->groupBy('shipment_assign_status.status')->whereIn('shipment_assign_status.status', ['6','7'])->get();*/

        /*$getdata = Shipments::select('shipments.*')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids)->whereIn('shipments.status', ['6','7'])->where('rider_id',Auth::user()->id)->get();*/

        $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->groupBy('shipment_id')->pluck('max_id');

        $getdata = Shipments::select('shipments.id','shipments.shipment_no','shipments.cod_amount','shipments.shipment_cost','shipments.pickup_date')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids)->whereIn('shipments.status',['6','7'])->where('rider_id',$rider_id)->orderBy('shipment_assign_status.created_at','desc')->get();

        $cod_to_deposit = $shipment_cost = 0;
        if(!empty($getdata))
        {
            foreach ($getdata as $key => $value) {
              $cod_to_deposit += $value->cod_amount;
              $shipment_cost += $value->shipment_cost;
            }
        }
        //$resp['cod_to_deposit']= $cod_to_deposit - $riderpayment;
        //return $cod_to_deposit;
        $riderdeposite = RiderDepositAmount::where('rider_id', $rider_id)->where('status', "1")->sum('amount');
        $resp['cod_to_deposit']= (int)$cod_to_deposit - (int)$riderdeposite;

        $resp['drivills_commission']= ($resp['cod_to_deposit'] == 0)?0:$shipment_cost;



        /*$resp['cod_to_deposit']= Shipments::join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->where('shipment_status_logs.updated_by_id',$rider_id)->sum('cod_amount');
        $resp['drivills_commission']= Shipments::join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->where('shipment_status_logs.updated_by_id',$rider_id)->sum('shipment_cost');*/
        $resp['message']="success";
        return response()->json($resp, 200);
    }

    public function depositAmount(Request $request)
    {
        $rider_id = Auth::user()->id;
        $this->validate($request, [            
            'amount' => 'required'
        ]);
        try{

            $getdata = Shipments::select('shipments.*')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->where('shipment_assign_status.rider_id',Auth::user()->id)->groupBy('shipment_assign_status.shipment_id')->groupBy('shipment_assign_status.status')->whereIn('shipment_assign_status.status', ['6','7'])->get();

            $cod_to_deposit = $shipment_cost = 0;
            if(!empty($getdata))
            {
                foreach ($getdata as $key => $value) {
                  $cod_to_deposit += $value->cod_amount;
                  $shipment_cost += $value->shipment_cost;
                }
            }
            //$resp['cod_to_deposit']= $cod_to_deposit - $riderpayment;
            $riderdeposite = RiderDepositAmount::where('rider_id', $rider_id)->where('status', "1")->sum('amount');
            $cod_to_deposit= $cod_to_deposit - $riderdeposite;
            if($cod_to_deposit <= 0)
            {
              return response()->json(['error' => "You can't deposite amount"], 404);  
            }
            if($cod_to_deposit < $request->amount)
            {
              return response()->json(['error' => "You can't deposite amount greater to your total deposited amount"], 404);  
            }
            if($request->amount <= 0)
            {
              return response()->json(['error' => "Please enter a valid amount"], 404);  
            }

            $amount=New RiderDepositAmount;
            $amount->amount=$request->amount;
            $amount->rider_id=$rider_id;
            $amount->save();
            return response()->json(['message' =>'Amount Deposited Successfully','data'=>$amount],200);
        }catch(ModelNotFoundException $m){
             return response()->json(['error' => 'Amount Deposit not found'], 404);
        }catch (Exception $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }
    }

    public function addCurrentLocation(Request $request)
    {
        $this->validate($request, [            
            'address' => 'required|max:255',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);
        try{
            $location = New RiderCurrentLocation;
            $location->rider_id = Auth::user()->id; 
            $location->address=$request->address;
            $location->latitude=$request->latitude;
            $location->longitude=$request->longitude;
            $location->save();
            return response()->json(['message' =>'Location Added Successfully','data'=>$location],200);
        }catch(ModelNotFoundException $m){
             return response()->json(['error' => 'Current Location Not found'], 404);
        }catch (Exception $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }

    }

    public function findNearestRider(Request $request)
    {
        /*$rider_id = Auth::user()->id; 
        $latitude = Auth::user()->latitude; 
        $longitude = Auth::user()->longitude;*/ 

        $this->validate($request, [            
            'latitude' => 'required',
            'longitude' => 'required'
        ]);
        try{
            $distance = \Setting::get('hub_search_radius', '10');
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $select = \DB::raw("*, ROUND(IF((1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),0 ),2) as distance");
            $hubs = DeliveryRiders::select($select)->where('status', 'Active')
            ->whereRaw("IF((1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),0 ) <= $distance")
            ->where('id','!=',Auth::user()->id)
            ->get();
            return response()->json(['message' =>'success','data'=>$hubs],200);
        }catch(ModelNotFoundException $m){
             return response()->json(['error' => 'Current Location Not found'], 404);
        }catch (Exception $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }

    }

    public function findNearestHub(Request $request)
    {
        //return "FDgdf";
        $this->validate($request, [            
            'latitude' => 'required',
            'longitude' => 'required'
        ]);
        try{
            $distance = \Setting::get('hub_search_radius', '10');
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $select = \DB::raw("*, ROUND(IF((1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),0 ),2) as distance");
            $hubs = Hubs::select($select)->where('status', 'Active')
            ->whereRaw("IF((1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),0 ) <= $distance")
            ->get();
            return response()->json(['message' =>'success','data'=>$hubs],200);
        }catch(ModelNotFoundException $m){
             return response()->json(['error' => 'Current Location Not found'], 404);
        }catch (Exception $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }

    }

     public function transfer_to_rider(Request $request)
    {
        $this->validate($request, [
            'shipment_id' => 'required',            
            'rider_id' => 'required',            
        ]);
        try {
            $shipment = Shipments::findOrFail($request->shipment_id);
            $rider=ShipmentAssignStatus::where('shipment_id',$request->shipment_id)->where('rider_id',Auth::user()->id)->first();
            if(!empty($rider)){
            /*  $rider=ShipmentAssignStatus::where('shipment_id',$request->shipment_id)->orderBy('id','desc')->first();
            if($rider->rider_id != Auth::user()->id){*/
                ShipmentAssignStatus::create([
                    'shipment_id'=>$shipment->id,
                    'hub_id'=>$rider->hub_id,
                    'rider_id'=>$request->rider_id,
                    'status'=>$shipment->status
                ]);
                ShipmentStatusLog::create([
                    'shipment_id'=>$shipment->id,
                    'status'=>$shipment->status,
                    'updated_by'=>'Rider',
                    'updated_by_id'=>Auth::user()->id,
                    'updated_ip'=>$request->ip(),
                    'reason'=>'',
                    'note'=>'Shipment Transfer By Rider'
                ]);
                ShipmentAssignStatus::where('shipment_id',$request->shipment_id)->where('rider_id',Auth::user()->id)->delete();
            }
            return response()->json(['message' =>'Shipment Transfer Successfully'],200);  
        } 
        catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }
    }

     public function transfer_to_hub(Request $request)
    {
        $this->validate($request, [
            'shipment_id' => 'required',            
            'hub_id' => 'required',            
        ]);
        try {
            $shipment = Shipments::findOrFail($request->shipment_id);
            $shipment->status = 4;
            $shipment->save();
            $rider=ShipmentAssignStatus::where('shipment_id',$request->shipment_id)->where('rider_id',Auth::user()->id)->first();
            if(!empty($rider)){
                ShipmentAssignStatus::create([
                    'shipment_id'=>$shipment->id,
                    'hub_id'=>$request->hub_id,
                    'rider_id'=>0,
                    'status'=>$shipment->status
                ]);
                ShipmentStatusLog::create([
                    'shipment_id'=>$shipment->id,
                    'status'=>$shipment->status,
                    'updated_by'=>'Rider',
                    'updated_by_id'=>Auth::user()->id,
                    'updated_ip'=>$request->ip(),
                    'reason'=>'',
                    'note'=>'Shipment Transfer By Rider'
                ]);
                ShipmentAssignStatus::where('shipment_id',$request->shipment_id)->where('rider_id',Auth::user()->id)->delete();
            }
            return response()->json(['message' =>'Shipment Transfer Successfully'],200);  
        } 
        catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }
    }

     public function notificationList()
    {
      $data = RiderNotification::where('rider_id', Auth::user()->id)->orderBy('created_at','desc')->get();
      if(!empty($data))
      {
        foreach ($data as $key => $value) {
          $shipment = Shipments::find($value->shipment_id);
          $data[$key]->message = $value->notification.'('.$shipment->shipment_no.')';
        }
      }
      return response()->json(['message' =>'list loaded Successfully','data'=>$data],200);
    }

    public function notificationRead($notification_id)
    {
       $notification = RiderNotification::find($notification_id);
       $notification->is_viewed = "1";
       $notification->save();
       return response()->json(['message' =>'Notification Read Successfully'],200);
    }

    public function ship_list(Request $request)
    {
        //DB::enableQueryLog();
        $data = Shipments::locationData()->whereHas('rider',function($query)
        {
            $query->where('rider_id',5);
        })->orderBy('created_at','desc');
        if($request->status) {
            switch (strtolower($request->status)) {
                case 'pickup':
                    $data= $data->whereIn('status', ['2','3']);
                    break;
                case 'deliver':
                    $data= $data->whereIn('status', ['5','6','7','10']);
                    break;
            }            
        }
        $shipments =$data->get();
        //dd(DB::getQueryLog());

       /* $resp['picked_up']= Shipments::where('status', 3)->count('id');
        $resp['delivered']= Shipments::whereIn('status', ['6','7'])->count('id');*/
        if(!empty($shipments))
        {
            foreach ($shipments as $key => $value) {
                $product_type = ProductType::find($value->product_type);
                $shipments[$key]->product_type = $product_type->name;
            }
        }
        $resp['shipments'] =$shipments;

        $resp['message']="success";
        return response()->json($resp, 200);
    }

}
