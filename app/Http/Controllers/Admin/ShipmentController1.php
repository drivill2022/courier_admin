<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Storage;
use App\models\Shipments;
use App\models\ShipmentAssignStatus;
use App\models\ShipmentStatusLog;
use App\models\admin\Merchants;
use App\models\admin\Hubs;
use App\models\admin\DeliveryRiders;
use App\models\admin\District;
use App\models\admin\Thana;
use App\models\admin\ShipmentReason;
use App\models\ShipNotification;
use App\models\Notification;
use App\models\RiderNotification;

class ShipmentController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($hub_id = '')
    {
        $shipments = Shipments::with(['merchant','rider','rider.rider','cancelBy'])->whereNotIn('status',[0,11])->orderBy('created_at','desc');
        if($hub_id != '')
        {
            $shipments = $shipments->whereHas('rider',function($query) use($hub_id)
            {
               $query->where('hub_id',$hub_id);
            });
        }
      
        $shipments = $shipments->get();
        //$unassign  = $shipments->where('status', 0);
        $unassign  = $shipments->where('status', 1);
        $ongoing   = $shipments->whereIn('status', [2,3]);
        $transit   = $shipments->whereIn('status', [4,12]);
        //$transit   = $shipments->whereIn('status', [4,10]);
        /*$ongoingd   = $shipments->whereIn('status', [5,6]);
        $completed = $shipments->where('status', 7);*/
       // $ongoingd   = $shipments->where('status', 5);
        $ongoingd   = $shipments->whereIn('status', [5,10]);
        $completed = $shipments->whereIn('status', [6,7]);
        $cancelled = $shipments->where('status', 8);
        $rejected  = $shipments->where('status', 9);
        $revnue=$shipments->sum('shipment_cost');
        //echo "<pre>"; print_r($cancelled);die;
        return view('admin.shipments.index',compact('shipments','unassign','ongoing','completed','transit','rejected','ongoingd','cancelled','revnue','hub_id'));
    }


    /**
     * Display a listing of the upcoming shipment.
     *
     * @return \Illuminate\Http\Response
     */
    public function upcoming()
    {
        $shipments = Shipments::orderBy('created_at','desc')->where('pickup_date', '>=', date('Y-m-d H:i'))->whereIn('status', [1,2,3,4,5,10])->get();
        return view('admin.shipments.upcoming',compact('shipments'));
    }
    /**
     * Display a listing of the transfer shipment.
     *
     * @return \Illuminate\Http\Response
     */
    public function transfer(Request $request,$id)
    {
        $shipment = Shipments::findOrFail($id);
        $merchants=Merchants::where('status','Active')->orderBy('name','asc')->get();
        $hubs=Hubs::where('status','Active')->orderBy('name','asc')->get();

        return view('admin.shipments.transfer',compact('shipment','merchants','hubs'));
    }
    /**
     * Display a listing of the assign rider for shipment.
     *
     * @return \Illuminate\Http\Response
     */
    public function assign_rider(Request $request,$id)
    {
        $shipment = Shipments::findOrFail($id);
        //echo "<pre>";print_r($shipment);die;
        $merchants=Merchants::where('status','Active')->orderBy('name','asc')->get();
        $hubs=Hubs::where('status','Active')->orderBy('name','asc')->get();

        return view('admin.shipments.assign-rider',compact('shipment','merchants','hubs'));
    }
    /**
     * Display a listing of the cancel for shipment.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel_shipment(Request $request,$id)
    {
        $shipment = Shipments::findOrFail($id);
        $reasons = ShipmentReason::where('reason_for',1)->latest()->get();
        return view('admin.shipments.cancel-shipment',compact('shipment','reasons'));
    }
    /**
     * Display a listing of the track shipment.
     *
     * @return \Illuminate\Http\Response
     */
    public function track(Request $request)
    {
        $shipments = Shipments::orderBy('created_at','desc');
        $shipment_no=$request->shipment_no?:'';
        if($shipment_no){
            $shipments =$shipments->where('shipment_no','like','%'.$request->shipment_no.'%');
        }
        $shipments = $shipments->get();
        return view('admin.shipments.track',compact('shipments','shipment_no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $merchants=Merchants::where('status','Active')->orderBy('name','asc')->get();
        return view('admin.shipments.create',compact('merchants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'receiver_name' => 'required|max:255',            
           'contact_no' => 'required|digits_between:8,12',            
           'product_detail' => 'required|max:255',            
           'product_type' => 'required|max:255',
           'product_weight' => 'required|max:255',
           //'note' => 'required|max:255',
           's_thana' => 'required',
           's_district' => 'required',
           's_division' => 'required',
           'd_thana' => 'required',
           'd_district' => 'required',
           'd_division' => 'required',
           's_address'=>'required',
           'd_address'=>'required',
           //'shipment_type'=>'required',
           'shipment_cost'=>'nullable',
           'merchant'=>'required',
           'cod_amount'=>'required',
           'pickup_date'=>'required',
        ]);

        try{
            $shipment = $request->all();
            $shipment['merchant_id'] = $request->merchant;
            $shipment['pickup_date'] = date('Y-m-d H:i:s',strtotime($request->pickup_date));

            //$shipment['shipment_no'] = rand(1,9999);
            //$shipment['pickup_date'] = date('Y-m-d H:i:s',strtotime('+1 day'));
            //$shipment['pickup_date'] = date("Y-m-d H:i:s", strtotime('+20 hours'));
            //$shipment['pickup_date'] = date('Y-m-d H:i:s',strtotime('+1 day'));
            $shipment['status'] = 1;    

            //print_r($shipment); die;
            //$shipment['shipment_cost'] =110*$shipment['shipment_type'];
            $shipment = Shipments::create($shipment);
            /*$shipment->shipment_no = '#SPM'.sprintf('%08d', $shipment->id);
            $shipment->save();*/
            $shipment->shipment_no = '#DC'.sprintf('%04d', $shipment->id);
            $shipment->save();
            
            return redirect()->route('admin.shipments.index')->with('flash_success','Shipment Created Successfully');
            }
        catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $shipment = Shipments::locationData()->findOrFail($id);
            return view('admin.shipments.details',compact('shipment'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $shipment = Shipments::findOrFail($id);
            $shipment->pickup_date = date('m/d/Y',strtotime($shipment->pickup_date));

            $merchants=Merchants::where('status','Active')->orderBy('name','asc')->get();
            return view('admin.shipments.edit',compact('shipment','merchants'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	$rules = [                      
            //'shipment_no' => 'required_if:status,4|max:150|unique:shipments,shipment_no,'.$id.',id',
            'shipment_no' => 'required_if:status,4,5,6,8|nullable|max:150|unique:shipments,shipment_no,'.$id,            
            'shipment_cost' => 'required_if:status,4,5,6,8',            
            'rider' => 'required|max:255',            
            'hub' => 'required|max:255',            
            'assign' => 'required|in:1,2',            
            'receiver_name' => 'required_if:assign,2|max:255',            
            'product_detail' => 'required_if:assign,2|max:255',            
            'merchant' => 'required_if:assign,2|max:255',            
            'contact_no' => 'required_if:assign,2|digits_between:8,12',            
            'd_address' => 'required_if:assign,2|max:255',
            's_address' => 'required_if:assign,2|max:255',
            'product_weight' => 'required_if:assign,2|max:255',
            'product_type' => 'required_if:assign,2|max:255',
            'product_type' => 'required_if:assign,2|max:255',
            'product_type' => 'required_if:assign,2|max:255',
            'note' => 'required_if:assign,2|max:255',
            's_thana' => 'required_if:assign,2',
            's_district' => 'required_if:assign,2',
            's_division' => 'required_if:assign,2',
            'd_thana' => 'required_if:assign,2',
            'd_district' => 'required_if:assign,2',
            'd_division' => 'required_if:assign,2',
            'status' => 'required_if:assign,2',
            'cod_amount' => 'required',
            //'shipment_type' => 'required_if:assign,2'
        ];

        /*if($request->has('shipment_cost'))
        {
        	if($request->shipment_cost != '')
        	{
        	   $rules['shipment_cost'] = 'lt:cod_amount';
        	}
        }*/

        $this->validate($request, $rules,
        [
         'shipment_no.required_if' => 'The shipment tracking number field is required',
         'shipment_cost.required_if' => 'The shipment cost field is required',
        ]);

        $msg = 'Shipment updated successfully';
       
       
         

        try {
            $shipment = Shipments::findOrFail($id);
            //return $request->rider;

            if($shipment->status == 8)
            {
             $shipmentlaststatus= ShipmentAssignStatus::where('shipment_id',$shipment->id)->orderBy('created_at', 'desc')->first();
             if(!empty($shipmentlaststatus) && $request->status == 2)
             {
                $request->status = $shipmentlaststatus->status;
             }
            } 
            //return $request->status;

            if($request->assign ==2) {
                $shipment->merchant_id = $request->merchant;
                $shipment->receiver_name=$request->receiver_name;
                $shipment->product_detail=$request->product_detail;
                $shipment->contact_no=$request->contact_no;
                $shipment->s_address=$request->s_address;
                $shipment->d_address=$request->d_address;
                $shipment->product_weight=$request->product_weight;
                $shipment->product_type=$request->product_type;
               // $shipment->pickup_date=$request->pickup_date;
                $shipment->note=$request->note;
                $shipment->s_thana=$request->s_thana;
                $shipment->d_thana=$request->d_thana;
                $shipment->s_district=$request->s_district;
                $shipment->d_district=$request->d_district;
                $shipment->s_division=$request->s_division; 
                $shipment->d_division=$request->d_division; 
                $shipment->s_latitude=$request->s_latitude; 
                $shipment->d_latitude=$request->d_latitude; 
                $shipment->s_longitude=$request->s_longitude; 
                $shipment->d_longitude=$request->d_longitude;

                //$msg = 'Shipment Assigned Successfully';
               // $msg = 'Shipment updated successfully';
            }
            //$shipment->shipment_type=$request->shipment_type; 
            $shipment->shipment_cost=$request->shipment_cost; 
            $shipment->cod_amount=$request->cod_amount;
            //$shipment->shipment_no=$request->shipment_no; 
            //if($shipment->status == $request->status) {
               if($shipment->status == 4)
               {
                  $sts = ($request->status == 4)?5:$request->status;
               }
               else
               {
                  $sts = $request->status;
               }
              
               ShipmentStatusLog::create([
                'shipment_id'=>$shipment->id,
                'status'=>$sts,
                //'status'=> $request->status,
                'updated_by'=>'Admin',
                'updated_by_id'=>Auth::guard('admin')->user()->id,
                'updated_ip'=>$request->ip(),
                'reason'=>'',
                'note'=>'Shipment '.shipment_status($sts).' By Admin'
            ]);
               $shipment->status=$sts; 


          /*}
          else
          {
             $shipment->status=$request->status; 
          }*/
            
            //$shipment->status=($request->status == 4)?5:$request->status; 
           // $shipment->status=$request->status; 

            $shipment->shipment_no = '#DC'.sprintf('%04d', $shipment->id);
            
            $shipment->save();
            /*$rider=ShipmentAssignStatus::where('shipment_id',$shipment->id)->where('hub_id',$request->hub)->where('rider_id',$request->rider)->where('status',$shipment->status)->first();
            if(!$rider) {*/
                ShipmentAssignStatus::create([
                    'shipment_id'=>$shipment->id,
                    'hub_id'=>$request->hub,
                    'rider_id'=>$request->rider,
                    'status'=>$sts
                ]);
            /*}else{
               $rider->status=$shipment->status;
               $rider->save();
            }*/
            if($sts == 5) { 
                 $msg = 'Shipment Assigned Successfully';
                 $notification_sms = Notification::find(1);
                 $notification_sms->message = str_replace("{{tracking_number}}",$shipment->shipment_no,$notification_sms->message); 
                  $rider = DeliveryRiders::find($request->rider);
                 $notification_sms->message = str_replace("{{rider_name}}",$rider->name,$notification_sms->message);
                  $mobile=$shipment->contact_no;
                  sendSms($mobile,$notification_sms->message);

                  // send push 
                  $noti = New ShipNotification;
                  $noti->shipment_id = $shipment->id;
                  $noti->merchant_id = $shipment->merchant_id;
                  $noti->rider_id = $request->rider;
                  $noti->notification_id = 2;
                  $noti->hub_id =$request->hub;
                  $noti->save();
                  $notification = Notification::find(2);
                  $title = 'Shipment Assigned for delivery';
            }
            if($sts == 4) { 
                  $noti = New ShipNotification;
                  $noti->shipment_id = $shipment->id;
                  $noti->merchant_id = $shipment->merchant_id;
                  $noti->rider_id = $request->rider;
                  $noti->notification_id = 7;
                  $noti->hub_id =$request->hub;
                  $noti->save();
                  $notification = Notification::find(7);
                  $title = 'Shipment transited for delivery';
            }
            // send rider notification
            if($request->status ==2) {
                  $msg = 'Shipment Assigned Successfully';
                 /* $noti = New ShipNotification;
                  $noti->shipment_id = $shipment->id;
                  $noti->merchant_id = $shipment->merchant_id;
                  $noti->rider_id = $request->rider;
                  $noti->notification_id = 2;
                  $noti->hub_id =$request->hub;
                  $noti->save();
                  $notification = Notification::find(2);
                  $title = 'Shipment Assigned';*/ 
                  $message = config('constants.assign_rider_noti');
                  $noti = New RiderNotification;
                  $noti->shipment_id = $shipment->id;
                  $noti->rider_id = $request->rider;
                  $noti->notification = $message;
                  $noti->save();
                  $title = 'Shipment Assigned';
                  $rider = DeliveryRiders::find($request->rider);
                  $data = array('title' => $title,'body' => $message);
                  sendNotification($rider->device_token,$data);
            } 
            if($request->status ==4) {
                  $message = config('constants.assign_deliver_rider_noti');
                  $noti = New RiderNotification;
                  $noti->shipment_id = $shipment->id;
                  $noti->rider_id = $request->rider;
                  $noti->notification = $message;
                  $noti->save();
                  $title = 'Shipment Assigned';
                  $rider = DeliveryRiders::find($request->rider);
                  $data = array('title' => $title,'body' => $message);
                  sendNotification($rider->device_token,$data);
            }
             // send rider notification
            if($request->status == 6) {
                  $noti = New ShipNotification;
                  $noti->shipment_id = $shipment->id;
                  $noti->merchant_id = $shipment->merchant_id;
                  $noti->rider_id = $request->rider;
                  $noti->notification_id = 3;
                  $noti->hub_id =$request->hub;
                  $noti->save();
                  $notification = Notification::find(3);
                  $title = 'Shipment Delivered';
            }

             if($request->status == 4 || $request->status == 6) {
                  // send push notification
                  $notification->message = str_replace("{{tracking_number}}",$shipment->shipment_no,$notification->message);
                  $notification->message = str_replace("{{rider_name}}",$request->rider,$notification->message);
                  $notification->message = str_replace("{{cod_amount}}",'Tk.'.$shipment->cod_amount,$notification->message);
                  $merchant = Merchants::find($shipment->merchant_id);
                  $data = array('title' => $title,'body' => $notification->message);
                  sendNotification($merchant->device_token,$data);
              }

            return redirect()->route('admin.shipments.index')->with('flash_success', $msg);    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Shipment Not Found');
        }
    }


     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function shipment_transfer(Request $request, $id)
    {
        $this->validate($request, [
            'rider' => 'required|max:255',            
            'hub' => 'required|max:255',
        ]);
        try {
            $shipment = Shipments::findOrFail($id);
            $rider=ShipmentAssignStatus::where('shipment_id',$shipment->id)->where('hub_id',$request->hub)->where('rider_id',$request->rider)->first();
            if(!$rider) {
                ShipmentAssignStatus::create([
                    'shipment_id'=>$shipment->id,
                    'hub_id'=>$request->hub,
                    'rider_id'=>$request->rider,
                    'status'=>$shipment->status
                ]);
                ShipmentStatusLog::create([
                    'shipment_id'=>$shipment->id,
                    'status'=>$shipment->status,
                    'updated_by'=>'Admin',
                    'updated_by_id'=>Auth::guard('admin')->user()->id,
                    'updated_ip'=>$request->ip(),
                    'reason'=>'',
                    'note'=>'Shipment Transfer By Admin'
                ]);
            }
            return redirect()->route('admin.shipments.index')->with('flash_success', 'Shipment transfer successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Shipment Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         try {
            $shipment = Shipments::findOrFail($id);
            $shipment->delete();
            return back()->with('flash_success', 'Shipment deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Shipment Not Found');
        }
    }



    public function get_rider(Request $request,$hub)
    {
        $rider=DeliveryRiders::where('hub_id',$hub)->where('status', 'Active')->get();
        $op='<option value="">Select Rider</option>';
        if($rider->count()==0){
            return $op='<option value="">---No Rider In Selected Hub----</option>';
        }
        foreach($rider as $r){
            $op.='<option value="'.$r->id.'">'.ucwords($r->name).'</option>';
        }
        return $op;
    }
    public function get_district(Request $request,$division)
    {
        $rider=District::where('division_id',$division)->orderBy('name','asc')->get();
        $op='<option value="">Select District</option>';
        if($rider->count()==0){
            return $op='<option value="">---No District In Selected Division----</option>';
        }
        foreach($rider as $r){
            $op.='<option value="'.$r->id.'">'.ucwords($r->name).'</option>';
        }
        return $op;
    }
    public function get_thana(Request $request,$district)
    {
        $rider=Thana::where('district_id',$district)->orderBy('name','asc')->get();
        $op='<option value="">Select Thana</option>';
        if($rider->count()==0){
            return $op='<option value="">---No Thana In Selected District----</option>';
        }
        foreach($rider as $r){
            $op.='<option value="'.$r->id.'">'.ucwords($r->name).'</option>';
        }
        return $op;
    }
     public function cancel_shipment_admin(Request $request, $id)
    {
        $this->validate($request, [
            'reason' => 'required|max:255',            
            //'cash_status' => 'required|max:255',
            'note' => 'required|max:255',
        ]);
        try {
            $shipment = Shipments::findOrFail($id);
            if(in_array($shipment->status, ["1","2","3"]) || in_array($shipment->status, [1,2,3]))
            {
                $shipment->status='11';
                $shipment->save();
                $shipment->status_log= ShipmentStatusLog::create([
                    'shipment_id'=>$shipment->id,
                    'status'=>11,
                    'updated_by'=>"Admin",
                    'updated_by_id'=>Auth::guard('admin')->user()->id,
                    'updated_ip'=>$request->ip(),
                    'reason'=>$request->reason,
                    'cash_status'=>@$request->cash_status,
                    'note'=>'Shipment Cancelled By Admin'
                ]);
            }
            else
            {
                $shipment->status='8';
                $shipment->save();
                $shipment->status_log= ShipmentStatusLog::create([
                    'shipment_id'=>$shipment->id,
                    'status'=>8,
                    'updated_by'=>"Admin",
                    'updated_by_id'=>Auth::guard('admin')->user()->id,
                    'updated_ip'=>$request->ip(),
                    'reason'=>$request->reason,
                    'cash_status'=>@$request->cash_status,
                    'note'=>'Shipment Cancelled By Admin'
                ]);

                $assign = ShipmentAssignStatus::where('shipment_id',$shipment->id)->orderBy('id','desc')->first();
                  $noti = New ShipNotification;
                  $noti->shipment_id = $shipment->id;
                  $noti->merchant_id = $shipment->merchant_id;
                  $noti->rider_id = empty($assign)?0:$assign->rider_id;
                  $noti->notification_id = 4;
                  $noti->hub_id =  empty($assign)?0:$assign->hub_id;
                  $noti->save();

                  // send push notification
                  $notification = Notification::find(4);
                  $notification->message = str_replace("{{tracking_number}}",$shipment->shipment_no,$notification->message);
                  $shipment_cost = $shipment->shipment_cost/2;
                  $notification->message = str_replace("{{cod_amount}}",'Tk.'.$shipment_cost,$notification->message);
                  $merchant = Merchants::find($shipment->merchant_id);
                  $data = array('title' => 'Shipment Cancelled','body' => $notification->message);
                  sendNotification($merchant->device_token,$data);
            }
              

            return redirect()->route('admin.shipments.index')->with('flash_success', 'Shipment Cancel successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Shipment Not Found');
        }
    }

     public function shipmentUpdate(Request $request, $id)
    {
        $this->validate($request, [                      
            'merchant' => 'required|max:255',                       
            'receiver_name' => 'required|max:255',
            'contact_no' => 'required|digits_between:8,12',  
            's_address' => 'required|max:255',  
            's_thana' => 'required',
            's_district' => 'required',
            's_division' => 'required',
            'd_address' => 'required|max:255',    
            'd_thana' => 'required',
            'd_district' => 'required',
            'd_division' => 'required',
            'product_detail' => 'required|max:255',            
            'product_weight' => 'required|max:255',
            'product_type' => 'required|max:255',
            //'shipment_type' => 'required|max:255',
            'cod_amount' => 'required',
            //'shipment_cost' => 'required|lt:cod_amount',
            'shipment_cost' => 'required_if:status,4,5,6,8',
            'note' => 'required|max:255',
        ],[
         'shipment_cost.required_if' => 'The shipment cost field is required',
        ]);
       
        $msg = 'Shipment updated successfully';
        try {
            $shipment = Shipments::findOrFail($id);
           
                $shipment->merchant_id = $request->merchant;
                $shipment->receiver_name=$request->receiver_name;
                $shipment->contact_no=$request->contact_no;
                $shipment->s_address=$request->s_address;
                $shipment->s_thana=$request->s_thana;
                $shipment->s_district=$request->s_district;
                $shipment->s_division=$request->s_division; 
                $shipment->d_address=$request->d_address;
                $shipment->d_thana=$request->d_thana;
                $shipment->d_district=$request->d_district;
                $shipment->d_division=$request->d_division; 
                $shipment->s_latitude=$request->s_latitude; 
                $shipment->s_longitude=$request->s_longitude; 
                $shipment->d_latitude=$request->d_latitude; 
                $shipment->d_longitude=$request->d_longitude;
                $shipment->product_detail=$request->product_detail;
                $shipment->product_weight=$request->product_weight;
                $shipment->product_type=$request->product_type;
                //$shipment->shipment_type=$request->shipment_type;
                $shipment->cod_amount=$request->cod_amount;
                $shipment->shipment_cost=$request->shipment_cost; 
                $shipment->note=$request->note;
                if($shipment->status != $request->status) {
                       ShipmentStatusLog::create([
                        'shipment_id'=>$shipment->id,
                        'status'=> $request->status,
                        'updated_by'=>'Admin',
                        'updated_by_id'=>Auth::guard('admin')->user()->id,
                        'updated_ip'=>$request->ip(),
                        'reason'=>'',
                        'note'=>'Shipment '.shipment_status($request->status).' By Admin'
                    ]);
                  }
                $shipment->status=$request->status;
                $shipment->shipment_no = '#DC'.sprintf('%04d', $shipment->id);
                $shipment->pickup_date = date('Y-m-d H:i:s',strtotime($request->pickup_date));
                $shipment->save();

                if($request->status ==2) {
                  $assign = ShipmentAssignStatus::where('shipment_id',$shipment->id)->orderBy('id','desc')->first();
                  $noti = New ShipNotification;
                  $noti->shipment_id = $shipment->id;
                  $noti->merchant_id = $shipment->merchant_id;
                  $noti->rider_id = $assign->rider_id;
                  $noti->notification_id = 2;
                  $noti->hub_id = $assign->hub_id;
                  $noti->save();
                }
                if($request->status == 6) {
                      $assign = ShipmentAssignStatus::where('shipment_id',$shipment->id)->orderBy('id','desc')->first();
                      $noti = New ShipNotification;
                      $noti->shipment_id = $shipment->id;
                      $noti->merchant_id = $shipment->merchant_id;
                      $noti->rider_id = $assign->rider_id;
                      $noti->notification_id = 3;
                      $noti->hub_id = $assign->hub_id;
                      $noti->save();
                }


            //return redirect()->back()->with('flash_success', $msg);  
            return redirect()->route('admin.shipments.index')->with('flash_success', $msg);   
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Shipment Not Found');
        }
    }

     public function transferToHub(Request $request,$id)
    {
        $shipment = Shipments::findOrFail($id);
        $merchants=Merchants::where('status','Active')->orderBy('name','asc')->get();
        $selectedhubs=Hubs::where('status','Active')->orderBy('name','asc')->get();

        $hubs=Hubs::where('id','!=',$shipment->rider->hub_id)->where('status','Active')->orderBy('name','asc')->get();

        return view('admin.shipments.transfer-to-hub',compact('shipment','merchants','selectedhubs','hubs'));
    }

    public function shipment_transfer_to_hub(Request $request, $id)
    {
        $this->validate($request, [
            'hub' => 'required|max:255',
        ]);
        try {
            $shipment = Shipments::findOrFail($id);
            /*$shipment->status = 1;
            $shipment->save();*/
            //$rider=ShipmentAssignStatus::where('shipment_id',$shipment->id)->where('hub_id',$request->hub)->orderBy('id','desc')->first();
            $rider=ShipmentAssignStatus::where('shipment_id',$shipment->id)->orderBy('id','desc')->first();
            if($rider->hub_id != $request->hub) {
                ShipmentAssignStatus::create([
                    'shipment_id'=>$shipment->id,
                    'hub_id'=>$request->hub,
                    'rider_id'=>0,
                    'status'=>$shipment->status
                ]);
                ShipmentStatusLog::create([
                    'shipment_id'=>$shipment->id,
                    'status'=>$shipment->status,
                    'updated_by'=>'Admin',
                    'updated_by_id'=>Auth::guard('admin')->user()->id,
                    'updated_ip'=>$request->ip(),
                    'reason'=>'',
                    'note'=>'Shipment Transfer By Admin'
                ]);
            }
            return redirect()->route('admin.shipments.index')->with('flash_success', 'Shipment transfer successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Shipment Not Found');
        }
    }

     public function editInfo($id)
    {
        $shipment = Shipments::findOrFail($id);
        $shipment->pickup_date = date('m/d/Y',strtotime($shipment->pickup_date));
        //echo "<pre>";print_r($shipment);die;
        $merchants=Merchants::where('status','Active')->orderBy('name','asc')->get();
        $hubs=Hubs::where('status','Active')->orderBy('name','asc')->get();

        return view('admin.shipments.edit-info',compact('shipment','merchants','hubs'));
    }
    public function updateInfo(Request $request,$id)
    {

        $rules = [                      
                        
            'rider' => 'required',            
            'hub' => 'required',            
            //'status' => 'required',
        ];

        $this->validate($request, $rules);

         $shipment = Shipments::findOrFail($id);
         $shipment_assign = ShipmentAssignStatus::find(@$shipment->rider->id);

         if(!empty($shipment_assign))
         {
             /*if($request->has('status'))
             {
                 $shipment->status = $request->status;
                 $shipment_assign->status = $request->status;
             }*/
             if($request->has('hub'))
             {
                $shipment_assign->hub_id = $request->hub;
             }
             if($request->has('rider'))
             {
                $shipment_assign->rider_id = $request->rider;
             }
             $shipment_assign->save();
          }

         /*if($request->has('pickup_date'))
         {
             $shipment->pickup_date = date('Y-m-d H:i:s',strtotime($request->pickup_date));
         }*/
         

         $shipment->save();         
         
         //return redirect()->back()->with('flash_success', "Shipment information updated successfully");   
         return redirect()->route('admin.shipments.index')->with('flash_success', "Shipment information updated successfully");    
    }
}
