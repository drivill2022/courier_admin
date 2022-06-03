<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Storage;
use App\models\Shipments;
use App\models\ShipmentAssignStatus;
use App\models\admin\Merchants;
use App\models\admin\Hubs;
use App\models\admin\DeliveryRiders;
use App\models\admin\ShipmentReason;
use App\models\ShipmentStatusLog;
use App\models\ShipNotification;
use App\models\Notification;

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
    public function index()
    {
        $hub=Auth::guard('hub')->user();
        $shipments = Shipments::whereHas('rider',function($query) use($hub)
        {
            $query->where('hub_id',$hub->id);
        })->whereNotIn('status',[0,11])->orderBy('created_at','desc')->get();
        /*$unassign = $shipments->where('status', 0);
        $ongoing = $shipments->whereNotIn('status', [0,2,3,4]); 
        $completed = $shipments->where('status', 4);
        $cancelled = $shipments->whereNotIn('status', [2,3]);
        return view('hub.shipments.index',compact('shipments','unassign','ongoing','completed','cancelled'));*/

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
        return view('hub.shipments.index',compact('shipments','unassign','ongoing','completed','transit','rejected','ongoingd','cancelled','revnue'));
    }


    /**
     * Display a listing of the upcoming shipment.
     *
     * @return \Illuminate\Http\Response
     */
    public function upcoming()
    {
        $hub=Auth::guard('hub')->user();
        $shipments = Shipments::whereHas('rider',function($query) use($hub)
        {
            $query->where('hub_id',$hub->id);
        })->orderBy('created_at','desc')->where('pickup_date', '>=', date('Y-m-d H:i'))->whereIn('status', [1,2,3,4,5,10])->get();
        return view('hub.shipments.upcoming',compact('shipments'));
    }
    /**
     * Display a listing of the transfer shipment.
     *
     * @return \Illuminate\Http\Response
     */
    public function transfer(Request $request,$id)
    {
        $hub=Auth::guard('hub')->user();
        $shipment = Shipments::whereHas('rider',function($query) use($hub)
        {
            $query->where('hub_id',$hub->id);
        })->where('id',$id)->firstOrFail();
        $merchants=Merchants::where('status','Active')->orderBy('name','asc')->get();
        return view('hub.shipments.transfer',compact('shipment','merchants'));
    }
    /**
     * Display a listing of the assign rider for shipment.
     *
     * @return \Illuminate\Http\Response
     */
    public function assign_rider(Request $request,$id)
    {
        $hub=Auth::guard('hub')->user();
        $shipment = Shipments::whereHas('rider',function($query) use($hub)
        {
            $query->where('hub_id',$hub->id);
        })->where('id',$id)->firstOrFail();
        $merchants=Merchants::where('status','Active')->orderBy('name','asc')->get();

        return view('hub.shipments.assign-rider',compact('shipment','merchants'));
    }
    /**
     * Display a listing of the cancel for shipment.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel_shipment(Request $request,$id)
    {
        $hub=Auth::guard('hub')->user();
        $shipment = Shipments::whereHas('rider',function($query) use($hub)
        {
            $query->where('hub_id',$hub->id);
        })->where('id',$id)->firstOrFail();
        $reasons = ShipmentReason::where('reason_for',1)->latest()->get();
        return view('hub.shipments.cancel-shipment',compact('shipment','reasons'));
    }
    /**
     * Display a listing of the track shipment.
     *
     * @return \Illuminate\Http\Response
     */
    public function track(Request $request)
    {
        $hub=Auth::guard('hub')->user();
        $shipments = Shipments::whereNotIn('status',[0,11])->whereHas('rider',function($query) use($hub)
        {
            $query->where('hub_id',$hub->id);
        })->orderBy('created_at','desc');
        $shipment_no=$request->shipment_no?:'';
        if($shipment_no){
            $shipments =$shipments->where('shipment_no','like','%'.$request->shipment_no.'%');
        }
        $shipments = $shipments->get();
        return view('hub.shipments.track',compact('shipments','shipment_no'));
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
            $hub=Auth::guard('hub')->user();
            $shipment = Shipments::whereHas('rider',function($query) use($hub)
            {
                $query->where('hub_id',$hub->id);
            })->where('id',$id)->firstOrFail();
            return view('hub.shipments.details',compact('shipment'));
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
            $hub=Auth::guard('hub')->user();
            $shipment = Shipments::whereHas('rider',function($query) use($hub)
            {
                $query->where('hub_id',$hub->id);
            })->where('id',$id)->firstOrFail();
            $merchants=Merchants::where('status','Active')->orderBy('name','asc')->get();
            return view('hub.shipments.action',compact('shipment','merchants'));
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
        /*$this->validate($request, [                      
            'rider' => 'required|max:255',            
            'assign' => 'required|in:1,2',            
            'receiver_name' => 'required_if:assign,2|max:255',            
            'product_name' => 'required_if:assign,2|max:255',            
            'merchant' => 'required_if:assign,2|max:255',            
            'contact_no' => 'required_if:assign,2|digits_between:8,12',            
            'delivery_address' => 'required_if:assign,2|max:255',
            'product_weight' => 'required_if:assign,2|max:255',
            'product_size' => 'required_if:assign,2|max:255',
            'pickup_date' => 'required_if:assign,2',
            'note' => 'required_if:assign,2|max:255',
            'thana' => 'required_if:assign,2',
            'district' => 'required_if:assign,2',
            'division' => 'required_if:assign,2',
            'status' => 'required_if:assign,2',
        ]);*/

        $rules = [                      
            //'shipment_no' => 'required_if:status,4|max:150|unique:shipments,shipment_no,'.$id.',id',
            'shipment_no' => 'required_if:status,4|nullable|max:150|unique:shipments,shipment_no,'.$id,            
            'shipment_cost' => 'required_if:status,4',            
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
            //'shipment_type' => 'required_if:assign,2'
        ];

        $this->validate($request, $rules,
        [
         'shipment_no.required_if' => 'The shipment tracking number field is required',
         'shipment_cost.required_if' => 'The shipment cost field is required',
        ]);

        $msg = 'Shipment updated successfully';

        try {
            //return $request->status;
            $hub=Auth::guard('hub')->user();
            $shipment = Shipments::whereHas('rider',function($query) use($hub)
            {
                $query->where('hub_id',$hub->id);
            })->where('id',$id)->firstOrFail();
            //$shipment->status='1';
            //return $shipment->status;

            if($shipment->status == 8)
            {
             $shipmentlaststatus= ShipmentAssignStatus::where('shipment_id',$shipment->id)->orderBy('created_at', 'desc')->first();
             $request->status = $shipmentlaststatus->status;
            } 
            
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
            //$shipment->shipment_no=$request->shipment_no; 
            //if($shipment->status == $request->status) {
             $sts = ($request->status == 4)?5:$request->status;
               ShipmentStatusLog::create([
                'shipment_id'=>$shipment->id,
                //'status'=>($request->status == 4)?5:$request->status,
                'status'=> ($request->status == 4)?5:$request->status,
                'updated_by'=>'Admin',
                'updated_by_id'=>Auth::guard('hub')->user()->id,
                'updated_ip'=>$request->ip(),
                'reason'=>'',
                'note'=>'Shipment '.shipment_status($sts).' By Hub'
            ]);
               $shipment->status=($request->status == 4)?5:$request->status;
          /*}
          else
          {
             $shipment->status=$request->status; 
          }*/
            
            //$shipment->status=($request->status == 4)?5:$request->status; 
           // $shipment->status=$request->status; 
            
            $shipment->save();
            $rider=ShipmentAssignStatus::where('shipment_id',$shipment->id)->where('hub_id',$request->hub)->where('rider_id',$request->rider)->first();
            //if(!$rider) {
                ShipmentAssignStatus::create([
                    'shipment_id'=>$shipment->id,
                    'hub_id'=>$hub->id,
                    'rider_id'=>$request->rider,
                    'status'=>$shipment->status
                ]);
           /* }else{
               $rider->status=$shipment->status;
               $rider->save();
            }*/
            if($request->status ==4) { 
                 $msg = 'Shipment Assigned Successfully';
                 $notification_sms = Notification::find(1);
                 $notification_sms->message = str_replace("{{tracking_number}}",$shipment->shipment_no,$notification_sms->message); 
                  $mobile=$shipment->contact_no;
                  sendSms($mobile,$notification_sms->message);

                   //send push 
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
            if($request->status ==2) {
                  $msg = 'Shipment Assigned Successfully';
                  /*$noti = New ShipNotification;
                  $noti->shipment_id = $shipment->id;
                  $noti->merchant_id = $shipment->merchant_id;
                  $noti->rider_id = $request->rider;
                  $noti->notification_id = 2;
                  $noti->hub_id = $hub->id;
                  $noti->save();
                  $notification = Notification::find(2);
                  $title = 'Shipment Assigned';*/
            }
            if($request->status == 6) {
                  $noti = New ShipNotification;
                  $noti->shipment_id = $shipment->id;
                  $noti->merchant_id = $shipment->merchant_id;
                  $noti->rider_id = $request->rider;
                  $noti->notification_id = 3;
                  $noti->hub_id =$hub->id;
                  $noti->save();
                  $notification = Notification::find(3);
                  $title = 'Shipment Delivered';
            }

             if($request->status ==4 || $request->status == 6) {
                  // send push notification
                  $notification->message = str_replace("{{tracking_number}}",$shipment->shipment_no,$notification->message);
                  $notification->message = str_replace("{{rider_name}}",$request->rider,$notification->message);
                  $notification->message = str_replace("{{cod_amount}}",'Tk.'.$shipment->cod_amount,$notification->message);
                  $merchant = Merchants::find($shipment->merchant_id);
                  $data = array('title' => $title,'body' => $notification->message);
                  sendNotification($merchant->device_token,$data);
              }
              return redirect()->route('hub.shipments.index')->with('flash_success', $msg); 

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
            $hub=Auth::guard('hub')->user();
            $shipment = Shipments::whereHas('rider',function($query) use($hub)
            {
                $query->where('hub_id',$hub->id);
            })->where('id',$id)->firstOrFail();
            $shipment->delete();
            return back()->with('flash_success', 'Shipment deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Shipment Not Found');
        }
    }



    public function get_rider(Request $request)
    {
        $rider=DeliveryRiders::where('hub_id',Auth::guard('hub')->user()->id)->where('status', 'Active')->get();
        $op='<option value="">Select Rider</option>';
        if($rider->count()==0){
            return $op='<option value="">---No Rider In Selected Hub----</option>';
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
                    'updated_by'=>"Hub",
                    'updated_by_id'=>Auth::guard('hub')->user()->id,
                    'updated_ip'=>$request->ip(),
                    'reason'=>$request->reason,
                    'cash_status'=>@$request->cash_status,
                    'note'=>'Shipment Cancelled By Hub'
                ]);
            }
            else
            {
                $shipment->status='8';
                $shipment->save();
                $shipment->status_log= ShipmentStatusLog::create([
                    'shipment_id'=>$shipment->id,
                    'status'=>8,
                    'updated_by'=>"Hub",
                    'updated_by_id'=>Auth::guard('hub')->user()->id,
                    'updated_ip'=>$request->ip(),
                    'reason'=>$request->reason,
                    'cash_status'=>@$request->cash_status,
                    'note'=>'Shipment Cancelled By Hub'
                ]);
            }

            /*$shipment->status='8';
            $shipment->save();
            $shipment->status_log= ShipmentStatusLog::create([
                'shipment_id'=>$shipment->id,
                'status'=>8,
                'updated_by'=>"Hub",
                'updated_by_id'=>Auth::guard('hub')->user()->id,
                'updated_ip'=>$request->ip(),
                'reason'=>$request->reason,
                'cash_status'=>$request->cash_status,
                'note'=>'Shipment Cancelled By Hub'
            ]);*/
              $assign = ShipmentAssignStatus::where('shipment_id',$shipment->id)->orderBy('id','desc')->first();
              $noti = New ShipNotification;
              $noti->shipment_id = $shipment->id;
              $noti->merchant_id = $shipment->merchant_id;
              $noti->rider_id = @$assign->rider_id;
              $noti->notification_id = 4;
              $noti->hub_id = @$assign->hub_id;
              $noti->save();

              // send push notification
              $notification = Notification::find(4);
              $notification->message = str_replace("{{tracking_number}}",$shipment->shipment_no,$notification->message);
              $notification->message = str_replace("{{cod_amount}}",'Tk.'.$shipment->cod_amount,$notification->message);
              $merchant = Merchants::find($shipment->merchant_id);
              $data = array('title' => 'Shipment Cancelled','body' => $notification->message);
              sendNotification($merchant->device_token,$data);

            return redirect()->route('hub.shipments.index')->with('flash_success', 'Shipment Cancel successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Shipment Not Found');
        }
    }

}
