<?php

namespace App\Http\Controllers\Merchant;

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
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ShipmentsImport;

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
        /*$shipments = Shipments::orderBy('created_at','desc')->get();
        return view('merchant.shipment.index',compact('shipments'));*/
        $shipments = Shipments::with(['merchant','rider','rider.rider','cancelBy'])->where('merchant_id',Auth::guard('merchant')->user()->id)->whereNotIn('status',[11])->orderBy('created_at','desc')->get();
        //$unassign  = $shipments->where('status', 0);
        $unassign  = $shipments->whereIn('status', [0,1]);
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
        return view('merchant.shipment.index',compact('shipments','unassign','ongoing','completed','transit','rejected','ongoingd','cancelled','revnue'));
    }

    /**
     * Display a listing of the upcoming shipment.
     *
     * @return \Illuminate\Http\Response
     */
    public function upcoming()
    {
        $shipments = Shipments::where('merchant_id',Auth::guard('merchant')->user()->id)->orderBy('created_at','desc')->where('pickup_date', '>=', date('Y-m-d H:i'))->whereIn('status', [1,2,3,4,5,10])->get();
        return view('merchant.shipment.upcoming',compact('shipments'));
    }
    /**
     * Display a listing of the track shipment.
     *
     * @return \Illuminate\Http\Response
     */
    public function track(Request $request)
    {
        $shipments = Shipments::whereNotIn('status',[0,11])->where('merchant_id',Auth::guard('merchant')->user()->id)->orderBy('created_at','desc');
        $shipment_no=$request->shipment_no?:'';
        if($shipment_no){
            $shipments =$shipments->where('shipment_no','like','%'.$request->shipment_no.'%');
        }
        $shipments = $shipments->get();
        return view('merchant.shipment.track',compact('shipments','shipment_no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $merchant = Auth::guard('merchant')->user();
        return view('merchant.shipment.create',compact('merchant'));
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
           's_address'=>'required',
           'd_address'=>'required',
           //'shipment_type'=>'required',
           'shipment_cost'=>'nullable',
           'cod_amount'=>'required',
           'pickup_date'=>'required',
        ]);

        try{
            $shipment = $request->all();
            $shipment['pickup_date'] = date('Y-m-d H:i:s',strtotime($request->pickup_date));
            $shipment['merchant_id'] = Auth::guard('merchant')->user()->id;

            $shipment = Shipments::create($shipment); 
            /*$shipment->shipment_no = '#SPM'.sprintf('%08d', $shipment->id);
            $shipment->save();*/
            $shipment->status='1';
             ShipmentStatusLog::create([
                    'shipment_id'=>$shipment->id,
                    'status'=>1,
                    'updated_by'=>'Merchant',
                    'updated_by_id'=>Auth::guard('merchant')->user()->id,
                    'updated_ip'=>$request->ip(),
                    'reason'=>"",
                    'note'=>'Pickup Request By Merchant'
                ]);
            $shipment->shipment_no = '#DC'.sprintf('%04d', $shipment->id);
            $shipment->save();

            /*return redirect()->route('merchant.shipment.request-for-pickup',$shipment->id)->with('flash_success','Shipment Created Successfully'); */

            return redirect()->route('merchant.shipment.index')->with('flash_success','Shipment Created Successfully'); 
            
            //return redirect()->route('merchant.shipment.index')->with('flash_success','Shipment Created Successfully');
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
            return view('merchant.shipment.details',compact('shipment'));
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
            return view('merchant.shipment.edit',compact('shipment'));
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {}

    public function cancel_shipment(Request $request,$id)
    {
        $shipment = Shipments::findOrFail($id);
        $reasons = ShipmentReason::where('reason_for',4)->latest()->get();
        return view('merchant.shipment.cancel-shipment',compact('shipment','reasons'));
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
                    'updated_by'=>"Merchant",
                    'updated_by_id'=>Auth::guard('merchant')->user()->id,
                    'updated_ip'=>$request->ip(),
                    'reason'=>$request->reason,
                    'cash_status'=>@$request->cash_status,
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
                    'updated_by_id'=>Auth::guard('merchant')->user()->id,
                    'updated_ip'=>$request->ip(),
                    'reason'=>$request->reason,
                    'cash_status'=>@$request->cash_status,
                    'note'=>'Shipment Cancelled By Merchant'
                ]);
            }

            /*$shipment->status='8';
            $shipment->save();
            $shipment->status_log= ShipmentStatusLog::create([
                'shipment_id'=>$shipment->id,
                'status'=>8,
                'updated_by'=>"Merchant",
                'updated_by_id'=>Auth::guard('merchant')->user()->id,
                'updated_ip'=>$request->ip(),
                'reason'=>$request->reason,
                'cash_status'=>@$request->cash_status,
                'note'=>'Shipment Cancelled By Merchant'
            ]);*/
             /* $assign = ShipmentAssignStatus::where('shipment_id',$shipment->id)->orderBy('id','desc')->first();
              $noti = New ShipNotification;
              $noti->shipment_id = $shipment->id;
              $noti->merchant_id = $shipment->merchant_id;
              $noti->rider_id = $assign->rider_id;
              $noti->notification_id = 4;
              $noti->hub_id = $assign->hub_id;
              $noti->save();*/

              // send push notification
              /*$notification = Notification::find(4);
              $notification->message = str_replace("{{tracking_number}}",$shipment->shipment_no,$notification->message);
              $notification->message = str_replace("{{cod_amount}}",'Tk.'.$shipment->cod_amount,$notification->message);
              $merchant = Merchants::find($shipment->merchant_id);
              $data = array('title' => 'Shipment Cancelled','body' => $notification->message);
              sendNotification($merchant->device_token,$data);*/

            return redirect()->route('merchant.shipment.index')->with('flash_success', 'Shipment Cancel successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Shipment Not Found');
        }
    }
      public function shipmentUpdate(Request $request, $id)
    {
        $this->validate($request, [                      
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
            'shipment_cost' => 'required',
            'note' => 'required|max:255',
        ]);
       
        $msg = 'Shipment updated successfully';
        try {
                $shipment = Shipments::findOrFail($id);
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
                $shipment->shipment_no = '#DC'.sprintf('%04d', $shipment->id);
                $shipment->save();

            //return redirect()->back()->with('flash_success', $msg);  
            return redirect()->route('merchant.shipment.index')->with('flash_success', $msg);   
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Shipment Not Found');
        }
    }

    public function request_for_pickup(Request $request,$id)
    {
        try {
            $distance = \Setting::get('hub_search_radius', '10');
            $latitude = Auth::guard('merchant')->user()->latitude;
            $longitude = Auth::guard('merchant')->user()->longitude;
            $select = \DB::raw("*, ROUND(IF((1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),0 ),2) as distance");
            $hubs = Hubs::select($select)->where('status', 'Active')
            ->whereRaw("IF((1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),0 ) <= $distance")
            ->get();

            $shipment = Shipments::find($id);
            return view('merchant.shipment.request-for-pickup',compact('hubs','shipment'));
        }catch(ModelNotFoundException $m){
             return back()->with('flash_error', 'Hubs Not Found');
        }
    }
    public function post_request_for_pickup(Request $request)
    {
        $this->validate($request, [            
           'shipment_id' => 'required',
           'hub'=>'required',
        ]);

        try{
                $shipment = Shipments::find($request->shipment_id);
                ShipmentStatusLog::create([
                    'shipment_id'=>$shipment->id,
                    'status'=>1,
                    'updated_by'=>'Merchant',
                    'updated_by_id'=>Auth::guard('merchant')->user()->id,
                    'updated_ip'=>$request->ip(),
                    'reason'=>$request->reason,
                    'note'=>$request->note?:'Pickup Request By Merchant'
                ]);
                $shipment->status='1';
                $shipment->save();
                if($request->hub) {
                    ShipmentAssignStatus::create([
                        'shipment_id'=>$shipment->id,
                        'hub_id'=>$request->hub,
                        'rider_id'=>$request->rider?:0,
                        'status'=>$shipment->status
                    ]);
                }
            
            return redirect()->route('merchant.shipment.index')->with('flash_success','Shipment sent for pickup Successfully');
        }
        catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage());
        }
    }

     public function shipmentImportPost(Request $request)
    {
        try {
         $this->validate($request, [
           'product_type'=>'required',
           'excel_file'=>'required|mimes:xlsx,xls',
        ]);

         $merchant_id = Auth::guard('merchant')->user()->id;

         $merchant = Merchants::find($merchant_id);
         $data = array(
           'merchant_id' => $merchant_id,
           'product_type' => $request->product_type,
           's_address' => $merchant->address,
           's_latitude' => $merchant->latitude,
           's_longitude' => $merchant->longitude,
           's_thana' => $merchant->thana,
           's_district' => $merchant->district,
           's_division' => $merchant->division,
         );
         Excel::import(new ShipmentsImport($data), $request->file('excel_file'));
         return redirect()->back()->with('flash_success', "Shipments imported successfully"); 
         } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();
             
             foreach ($failures as $failure) {
                 $failure->row(); // row that went wrong
                 $failure->attribute(); // either heading key (if using heading row concern) or column index
                 $failure->errors(); // Actual error messages from Laravel validator
                 $columns = $failure->values(); // The values of the row that has failed.

             }
             return redirect()->back()->with('flash_error', $failure->errors()[0]);
        }   
    }
     public function shipmentImport()
    {
        $merchants=Merchants::where('status','Active')->orderBy('name','asc')->get();
        return view('merchant.shipment.import',compact('merchants'));
    }
}
