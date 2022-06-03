<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Storage;
use App\models\admin\Hubs;
use App\models\Shipments;
use App\models\admin\HubDepositAmount;
use DB;
use App\models\admin\DeliveryRiders;
use Illuminate\Support\Facades\Validator;

class HubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $hub=Auth::guard('hub')->user();
        $hub_id=$hub->id;
        /*$shipments = Shipments::whereHas('rider_status',function($query) use($hub_id)
        {
           // $query->where('hub_id',$hub->id);
            $riders_ids = DeliveryRiders::select('id')->where('hub_id',$hub_id)->pluck('id')->toArray();
           $query->where('updated_by_id',$riders_ids);
        })->orderBy('created_at','desc')->get();*/

    
        $shipments = Shipments::whereHas('rider',function($query) use($hub_id)
        {
           // $query->where('hub_id',$hub->id);
           $riders_ids = DeliveryRiders::select('id')->where('hub_id',$hub_id)->pluck('id')->toArray();
           $query->where('rider_id',$riders_ids);
        })->orderBy('created_at','desc')->get();

        //echo "<pre>";
        //print_r($shipments);die;
        
        $res['ongoingd']  = $shipments->whereIn('status', [5,10])->count('id');
        $res['delivered'] = $shipments->whereIn('status', [6,7])->count('id');
        $res['total_order'] = $shipments->whereNotIn('status',[0,11])->count('id');

         $earnings = Shipments::whereHas('rider',function($query) use($hub_id)
        {
           // $query->where('hub_id',$hub->id);
            $riders_ids = DeliveryRiders::select('id')->where('hub_id',$hub_id)->pluck('id')->toArray();
           // $riders_ids = array_merge($riders_ids,[1]);
           $query->where('rider_id',$riders_ids)->whereIn('status',['6','7']);
        })->whereIn('status',['6','7'])->get();

        $total_earnings = $shipment_cost = 0;
        if(!empty($earnings))
        {
            foreach($earnings as $key => $value) {
              $total_earnings += $value->cod_amount;
              $shipment_cost += $value->shipment_cost;
            }
        }

        $res['total_earnings'] = $total_earnings;
        $hubdeposite = HubDepositAmount::where('hub_id', $hub->id)->where('status', "1")->sum('amount');
        $res['cod_to_deposit']= $total_earnings - $hubdeposite;
        $res['drivills_commission']= ($res['cod_to_deposit'] == 0)?0:$shipment_cost;
        return view('hub.dashboard',compact('res'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit_profile()
    {
        return view('hub.account.edit-profile');
    }  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('hub.account.profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile_update(Request $request)
    {
        $hub = Auth::guard('hub')->user();
        $this->validate($request,[
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'email' => 'required|max:255|email|unique:hubs,email,'.$hub->id.',id',
            'phone' => 'required|digits_between:8,12|unique:hubs,phone,'.$hub->id.',id',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'supervisor_name' => 'required|max:255',            
            'address' => 'required|max:255',            
            'sup_phone' => 'required|digits_between:8,12|unique:hubs,sup_phone,'.$hub->id.',id',
            'picture'     => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'sup_picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'sup_nid_pic' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'sup_tin_pic' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'tl_picture'  => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'sup_tin_no'  => 'required',
            'sup_nid_no'  => 'required',
            'thana'       => 'required',
            'district'    => 'required',
            'division'    => 'required',
        ]);

        try{            
           if($request->hasFile('picture')) {
                Storage::delete($hub->picture);
                $hub->picture = $request->picture->store('hubs');
            }
            if($request->hasFile('sup_picture')) {
                Storage::delete($hub->sup_picture);
                $hub->sup_picture = $request->sup_picture->store('hubs/supervisor');
            }
            if($request->hasFile('sup_nid_pic')) {
                Storage::delete($hub->sup_nid_pic);
                $hub->sup_nid_pic = $request->sup_nid_pic->store('hubs/supervisor/nidpic');
            }
            if($request->hasFile('sup_tin_pic')) {
                Storage::delete($hub->sup_tin_pic);
                $hub->sup_tin_pic = $request->sup_tin_pic->store('hubs/supervisor/tinpic');
            }
            if($request->hasFile('tl_picture')) {
                Storage::delete($hub->tl_picture);
                $hub->tl_picture = $request->tl_picture->store('hubs/tlpicture');
            }

            $hub->name = $request->name;
            $hub->email = $request->email;            
            $hub->supervisor_name = $request->supervisor_name;            
            $hub->phone = $request->phone;            
            $hub->sup_phone = $request->sup_phone;            
            $hub->sup_tin_no = $request->sup_tin_no;            
            $hub->sup_nid_no = $request->sup_nid_no;            
            $hub->address = $request->address;            
            $hub->thana = $request->thana;            
            $hub->district = $request->district;            
            $hub->division = $request->division; 
            $hub->latitude = $request->latitude;            
            $hub->longitude = $request->longitude;           
            $hub->save();
            return redirect()->back()->with('flash_success','Profile Updated Successfully');
        }
        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function password()
    {
        return view('hub.account.change-password');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function password_update(Request $request)
    {
        $this->validate($request,[
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        try {

           $Hub = Hubs::find(Auth::guard('hub')->user()->id);

            if(password_verify($request->old_password, $Hub->password))
            {
                if($request->old_password==$request->password)
                {
                    return back()->with('flash_error','New password could not be same as current password!');
                }
                $Hub->password = bcrypt($request->password);
                $Hub->save();
                return redirect()->back()->with('flash_success','Password has been updated successfully');
            }else{
                return back()->with('flash_error','Old password are incorrect!');
            }
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

       public function dashboard_filter(Request $request)
    {
        $hub=Auth::guard('hub')->user();

        $shipment_ids = Shipments::whereHas('rider_status',function($query) use($hub)
        {
            //$query->where('hub_id',$hub->id);
            $riders_ids = DeliveryRiders::select('id')->where('hub_id',$hub->id)->pluck('id')->toArray();
           $query->where('updated_by_id',$riders_ids);/*->orWhereIn('updated_by_id',[1,10]);*/
        })->whereIn('status', [6,7])->orderBy('created_at','desc')->pluck('id');

        if($request->filter) {
             $date_array=$delivered=$ongoingd=$total=$total_earnings=[];
                     $total_earnings=0;

            switch (strtolower($request->filter)) {
                case 'today':
                    $today = Carbon::today()->format('Y-m-d');
                    $sql =  DB::table('shipments')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->select('shipments.cod_amount',DB::raw('DATE(dri_shipment_status_logs.created_at) as date'), DB::raw('count(dri_shipment_status_logs.created_at) as count'))->whereDate('shipment_status_logs.created_at',"=", $today);
                    break;
                case 'weekly':
                    $loopperiod = 7; 
                    for($i=1; $i <= $loopperiod ; $i++) 
                            { 

                                $date = date("Y-m-d", strtotime("-$i day"));
                                $sqlmonth = DB::table('shipments')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->whereDate('shipment_status_logs.created_at',"=", $date)->whereIn('shipments.id',$shipment_ids);

                                 $sql1=clone $sqlmonth;
                                 $total_sql=clone $sqlmonth;
                                $earning_sql=clone $sqlmonth;

                                $total_delivered = $sqlmonth->whereIn('shipment_status_logs.status', ['6','7'])->count('shipments.id');
                               // dd(DB::getQueryLog());

                                $ongoing_delivery = $sql1->where('shipments.status', 5)->groupBy('shipments.id')->count('shipments.id');
                                $total_shipments = $total_sql->where('shipment_status_logs.status','!=',0)->groupBy('shipments.id')->count('shipments.id');

                                 $shipments = $earning_sql->whereIn('shipment_status_logs.status', ['6','7'])->groupBy('shipments.id')->get();

                                  if(!empty($shipments))
                                {
                                    foreach ($shipments as $key => $value) {
                                       $total_earnings += $value->cod_amount;
                                    }
                                }

                                     array_push($date_array, $date);
                                     array_push($delivered, $total_delivered);
                                     array_push($ongoingd, $ongoing_delivery);
                                     array_push($total, $total_shipments);
                                    // array_push($total_earnings, $total_earning);
                                    
                            }
                    break;
                case 'monthly':
                    $loopperiod = 12; 
                    for($i=1; $i <= $loopperiod ; $i++) 
                            { 
                                $month = date('M', mktime(0,0,0,$i, 1, date('Y')));
                                $date_from = date('Y-m-01', mktime(0,0,0,$i, 1, date('Y')));
                                $date_to  = date("Y-m-t", mktime(0,0,0,$i, 1, date('Y')));
                                $sqlmonth = DB::table('shipments')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->whereDate('shipment_status_logs.created_at',">=", $date_from)->whereDate('shipment_status_logs.created_at',"<=", $date_to)->whereIn('shipments.id',$shipment_ids);

                                 $sql1=clone $sqlmonth;
                                 $total_sql=clone $sqlmonth;
                                 $earning_sql=clone $sqlmonth;

                                $total_delivered = $sqlmonth->whereIn('shipment_status_logs.status', ['6','7'])->count('shipments.id');
                               
                                //dd(DB::getQueryLog());

                                $ongoing_delivery = $sql1->where('shipments.status', 5)->groupBy('shipments.id')->count('shipments.id');
                                $total_shipments = $total_sql->where('shipments.status','!=',0)->groupBy('shipments.id')->count('shipments.id');
                          
                                   $shipments = $earning_sql->whereIn('shipment_status_logs.status', ['6','7'])->groupBy('shipments.id')->get();

                                     array_push($date_array, $month);
                                     array_push($delivered, $total_delivered);
                                     array_push($ongoingd, $ongoing_delivery);
                                     array_push($total, $total_shipments);
                                    // array_push($total_earnings, $total_earning);

                                if(!empty($shipments))
                                {
                                    foreach ($shipments as $key => $value) {
                                       $total_earnings += $value->cod_amount;
                                    }
                                }
                                    
                            }
                            break;
            }      

        }
  
        $resp['date_array']= $date_array;
        //$resp['total_shipments']= array_sum($total);
        $resp['total_shipments']= array_sum($delivered) + array_sum($ongoingd);
        $resp['total']= $total;
        $resp['delivered']= $delivered;
        $resp['ongoingd']= $ongoingd;
        $resp['delivery_amount']= $total_earnings;
        $resp['delivery_ratio']= ($resp['total_shipments']>0)?number_format(((int)$delivered/(int)$resp['total_shipments'])*100,2):0;
     
        $resp['message']="success";
        return response()->json($resp, 200);
    }


    public function depositAmount(Request $request)
    {
        $hub_id = Auth::guard('hub')->user()->id;
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['status' => false,'message' => $validator->errors()->first()]);  
        }

        try{

            $getdata = Shipments::whereHas('rider',function($query) use($hub_id)
                        {
                            $query->where('hub_id',$hub_id);
                        })->whereIn('status',['6','7'])->get();

            $cod_to_deposit = $shipment_cost = 0;
            if(!empty($getdata))
            {
                foreach ($getdata as $key => $value) {
                  $cod_to_deposit += $value->cod_amount;
                  $shipment_cost += $value->shipment_cost;
                }
            }
            //$resp['cod_to_deposit']= $cod_to_deposit - $riderpayment;
            $hubdeposite = HubDepositAmount::where('hub_id', $hub_id)->where('status', "1")->sum('amount');
            $cod_to_deposit= $cod_to_deposit - $hubdeposite;
            if($cod_to_deposit <= 0)
            {
              return response()->json(['status' => false,'message' => "You can't deposite amount"]);  
            }
            if($cod_to_deposit < $request->amount)
            {
              return response()->json(['status' => false,'message' => "You can't deposite amount greater to your total deposited amount"]);  
            }
            if($request->amount <= 0)
            {
              return response()->json(['status' => false,'message' => "Please enter a valid amount"]);  
            }

            $amount=New HubDepositAmount;
            $amount->amount=$request->amount;
            $amount->hub_id=$hub_id;
            $amount->save();
            return response()->json(['status' => true,'message' =>'Amount Deposited Successfully'],200);
        }catch(ModelNotFoundException $m){
             return response()->json(['error' => 'Amount Deposit not found'], 404);
        }catch (Exception $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }
    }
}
