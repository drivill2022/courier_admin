<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Storage;
use App\models\admin\Merchants;
use App\models\admin\MerchantPaymentAccount;
use App\models\Shipments;
use DB;
use Carbon\Carbon;
use App\models\ShipmentAssignStatus;
use DateTime;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $earnings = Shipments::whereIn('status',['6','7'])->where('merchant_id',Auth::guard('merchant')->user()->id)->get();
        $res['delivered'] = Shipments::whereIn('status',['6','7'])->where('merchant_id',Auth::guard('merchant')->user()->id)->count('id');
        $res['ongoingd'] = Shipments::where('status',5)->where('merchant_id',Auth::guard('merchant')->user()->id)->count('id');
        $res['total_order'] = Shipments::where('merchant_id',Auth::guard('merchant')->user()->id)->whereNotIn('status',[11])->count('id');
        /*if(!empty($earnings))
        {
            foreach($earnings as $key => $value) {
              $total_earnings += $value->cod_amount;
            }
        }*/
        $getAllShipment = MerchantPaymentAccount::where('merchant_id',Auth::guard('merchant')->user()->id)->pluck('shipment_id');
        $cod_amount = Shipments::whereIn('id',$getAllShipment)->sum('cod_amount');
        $shipment_cost = Shipments::whereIn('id',$getAllShipment)->sum('shipment_cost');
        $total_earnings = $cod_amount - $shipment_cost;

        $res['total_earnings'] = $total_earnings;

        $res['total_earnings'] = $total_earnings;
        if($request->type == 'daily')
        {
            $res['date_filter'] = date('Y-m-d',strtotime($request->filter));
        }
        else
        {
            $res['date_filter'] = $request->filter;
        }
        
        $res['type'] = $request->type;

       return view('merchant.dashboard',compact('res'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit_profile()
    {

        return view('merchant.account.edit-profile');
    }  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {

        return view('merchant.account.profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile_update(Request $request)
    {
        $id = Auth::guard('merchant')->user()->id;
        $this->validate($request,[                      
            'name' => 'required|max:255',            
            'address' => 'required|max:255',            
            'email' => 'nullable|unique:merchants,email,'.$id.',id|email|max:255',
            'mobile' => 'required|digits_between:8,12|unique:merchants,mobile,'.$id.',id',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'business_logo' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'fb_page' => 'required',
            'thana' => 'nullable',
            'district' => 'nullable',
            'division' => 'nullable',
             'nid_number' => 'required',
            'buss_name' => 'required|max:255',            
            'buss_phone' => 'digits_between:8,14|unique:merchants,buss_phone,'.$id.',id',
            'buss_address' => 'required|max:255',            
            'payment_method' => 'required',
            'product_type' => 'required',
            'trade_lic_no' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);

        try{            
            $user = Merchants::findOrFail($id);
            if($request->hasFile('picture')) {
                Storage::delete($user->picture);
                $user->picture = $request->picture->store('merchant/profile');
            }
            if($request->hasFile('business_logo')) {
                Storage::delete($user->business_logo);
                $user->business_logo = $request->business_logo->store('merchant/business-logo');
            }if($request->hasFile('trade_lic_no')) {
                Storage::delete($user->trade_lic_no);
                $user->trade_lic_no = $request->trade_lic_no->store('merchant/trade-lic-pic');
            }
            $user->name = $request->name;
            $user->email = $request->email;            
            $user->mobile = $request->mobile;            
            $user->address = $request->address;            
            $user->latitude = $request->latitude;            
            $user->longitude = $request->longitude;            
            $user->fb_page = $request->fb_page;            
            $user->thana = $request->thana;            
            $user->district = $request->district;            
            $user->division = $request->division;
            $user->nid_number=$request->nid_number;
            $user->buss_name=$request->buss_name;
            $user->buss_address=$request->buss_address;
            $user->buss_phone=$request->buss_phone;
            $user->payment_method=$request->payment_method;
            $user->product_type=implode(',',$request->product_type);          
            $user->save();
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
        return view('merchant.account.change-password');
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

           $Merchant = Merchants::find(Auth::guard('merchant')->user()->id);

            if(password_verify($request->old_password, $Merchant->password))
            {
                if($request->old_password==$request->password)
                {
                    return back()->with('flash_error','New password could not be same as current password!');
                }
                $Merchant->password = bcrypt($request->password);
                $Merchant->save();
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
     /* public function dashboard_filter(Request $request)
    {
        if($request->filter) {
             $date_array=$delivered=$ongoingd=$total=$total_earnings=[];
                     $total_earnings=0;

            switch (strtolower($request->filter)) {
                case 'today':
                    //$today = Carbon::today()->format('Y-m-d');
                    $today = date('Y-m-d');
                    $sql =  DB::table('shipments')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->select('shipments.cod_amount',DB::raw('DATE(dri_shipment_status_logs.created_at) as date'), DB::raw('count(dri_shipment_status_logs.created_at) as count'))->whereDate('shipment_status_logs.created_at',"=", $today)->where('merchant_id',Auth::guard('merchant')->user()->id);

                     $sql1=clone $sql;
                     $total_sql=clone $sql;
                     $earning_sql=clone $sql;

                     $total_delivered = $sql->whereIn('shipment_status_logs.status', ['6','7'])->count('shipments.id');
                               
                     $ongoing_delivery = $sql1->where('shipments.status', 5)->groupBy('shipments.id')->count('shipments.id');
                    
                    $total_shipments = $total_sql->where('shipment_status_logs.status','!=',0)->groupBy('shipments.id')->count('shipments.id');  

                    $shipments = $earning_sql->whereIn('shipment_status_logs.status', ['6','7'])->groupBy('shipments.id')->get();

                     array_push($delivered, $total_delivered);
                     array_push($ongoingd, $ongoing_delivery);

                      if(!empty($shipments))
                    {
                        foreach ($shipments as $key => $value) {
                           $total_earnings += $value->cod_amount;
                        }
                    }
                         array_push($total, $total_shipments);

                    break;
                case 'weekly':
                    $loopperiod = 7; 
                    for($i=1; $i <= $loopperiod ; $i++) 
                            { 

                                $date = date("Y-m-d", strtotime("-$i day"));
                                $sqlmonth = DB::table('shipments')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->whereDate('shipment_status_logs.created_at',"=", $date)->where('merchant_id',Auth::guard('merchant')->user()->id);

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
                                DB::enableQueryLog();


                                $month = date('M', mktime(0,0,0,$i, 1, date('Y')));
                                $date_from = date('Y-m-01', mktime(0,0,0,$i, 1, date('Y')));
                                $date_to  = date("Y-m-t", mktime(0,0,0,$i, 1, date('Y')));
                                $sqlmonth = DB::table('shipments')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->whereDate('shipment_status_logs.created_at',">=", $date_from)->whereDate('shipment_status_logs.created_at',"<=", $date_to)->where('merchant_id',Auth::guard('merchant')->user()->id);

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
    }*/


     public function dashboard_filter(Request $request)
    {
        if($request->filter) {
             $date_array=$delivered=$ongoingd=$total=$total_earnings=[];
                     $total_earnings=0;

            switch (strtolower($request->filter)) {
                case 'today':
                    //$today = Carbon::today()->format('Y-m-d');
                    //$today = $request->date_filter;
                    if($request->date_filter)
                    {
                       $today = Carbon::createFromFormat('Y-m-d', $request->date_filter);
                    }
                    else
                    {
                      $today = Carbon::today()->format('Y-m-d');
                        }
                    /*$sql =  DB::table('shipments')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->select('shipments.cod_amount',DB::raw('DATE(dri_shipment_status_logs.created_at) as date'), DB::raw('count(dri_shipment_status_logs.created_at) as count'))->whereDate('shipment_status_logs.created_at',"=", $today);*/

                    $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->groupBy('shipment_id')->pluck('max_id');

                    $sql = Shipments::join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids)->whereDate('shipment_assign_status.created_at',"=", $today)->where('merchant_id',Auth::guard('merchant')->user()->id);

                     $sql1=clone $sql;
                     $total_sql=clone $sql;
                     $earning_sql=clone $sql;

                     $total_delivered = $sql->whereIn('shipments.status', ['6','7'])->count('shipments.id');
                               
                     $ongoing_delivery = $sql1->where('shipments.status', 5)->count('shipments.id');
                    
                    $total_shipments = $total_sql->where('shipments.status','!=',0)->count('shipments.id');  

                    $shipments = $earning_sql->whereIn('shipments.status', ['6','7'])->get();

                     array_push($delivered, $total_delivered);
                     array_push($ongoingd, $ongoing_delivery);

                    if(!empty($shipments))
                    {
                        foreach ($shipments as $key => $value) {
                           $total_earnings += $value->cod_amount;
                        }
                    }
                    array_push($total, $total_shipments);

                    break;
                case 'weekly':
                    //$loopperiod = 7; 
                     if($request->date_filter)
                    {
                        $filter = explode('-',$request->date_filter);
                        $dto = new DateTime();
                        $dto->setISODate($filter[0],substr($filter[1],-2));
                        $date_from = $dto->format('Y-m-d');
                        $dto->modify('+6 days');
                        $date_to = $dto->format('Y-m-d');

                    }
                    else
                    {
                       $dto = new DateTime();
                       $week = $dto->format("W");
                       $year = $dto->format("Y");
                       $dto->setISODate($year,$week);
                       $date_from = $dto->format('Y-m-d');
                       $dto->modify('+6 days');
                       $date_to = $dto->format('Y-m-d');
                    }
                    $date_from_s = strtotime($date_from);
                    $date_to_e = strtotime($date_to);

                    while($date_from_s <= $date_to_e) 
                            { 

                                //$date = date("Y-m-d", strtotime("-$i day"));
                                $date = date("Y-m-d", $date_from_s);
                                /*$sqlmonth = DB::table('shipments')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->whereDate('shipment_status_logs.created_at',"=", $date);*/

                                 $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->groupBy('shipment_id')->pluck('max_id');

                                 $sqlmonth = Shipments::join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids)->whereDate('shipment_assign_status.created_at',"=", $date)->where('merchant_id',Auth::guard('merchant')->user()->id);

                                 $sql1=clone $sqlmonth;
                                 $total_sql=clone $sqlmonth;
                                $earning_sql=clone $sqlmonth;

                                $total_delivered = $sqlmonth->whereIn('shipments.status', ['6','7'])->count('shipments.id');
                               // dd(DB::getQueryLog());

                                $ongoing_delivery = $sql1->where('shipments.status', 5)->count('shipments.id');
                                $total_shipments = $total_sql->where('shipments.status','!=',0)->count('shipments.id');

                                 $shipments = $earning_sql->whereIn('shipments.status', ['6','7'])->get();

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

                               $date_from_s = strtotime('+1 day', $date_from_s);
                                    
                            }
                    break;
                case 'yearly':
                    $loopperiod = 12; 
                    for($i=1; $i <= $loopperiod ; $i++) 
                            { 
                                if($request->date_filter)
                                {
                                    $year = $request->date_filter; 
                                }
                                else
                                {
                                   $year = Date('Y');
                                }
                                $month = date('M', mktime(0,0,0,$i, 1, $year));
                                $date_from = date('Y-m-01', mktime(0,0,0,$i, 1, $year));
                                $date_to  = date("Y-m-t", mktime(0,0,0,$i, 1, $year));
                                /*$sqlmonth = DB::table('shipments')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->whereDate('shipment_status_logs.created_at',">=", $date_from)->whereDate('shipment_status_logs.created_at',"<=", $date_to);*/

                                $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->groupBy('shipment_id')->pluck('max_id');

                                 $sqlmonth = Shipments::join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids)->whereDate('shipment_assign_status.created_at',">=", $date_from)->whereDate('shipment_assign_status.created_at',"<=", $date_to)->where('merchant_id',Auth::guard('merchant')->user()->id);


                                 $sql1=clone $sqlmonth;
                                 $total_sql=clone $sqlmonth;
                                 $earning_sql=clone $sqlmonth;

                                $total_delivered = $sqlmonth->whereIn('shipments.status', ['6','7'])->count('shipments.id');
                               
                                //dd(DB::getQueryLog());

                                $ongoing_delivery = $sql1->where('shipments.status', 5)->count('shipments.id');
                                $total_shipments = $total_sql->where('shipments.status','!=',0)->count('shipments.id');
                          
                                   $shipments = $earning_sql->whereIn('shipments.status', ['6','7'])->get();

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
}
