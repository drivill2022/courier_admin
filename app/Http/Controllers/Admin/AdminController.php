<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Storage;
use App\models\admin\Admin;
use App\models\admin\DeliveryRiders;
use App\models\ShipmentAssignStatus;
use App\models\RiderCurrentLocation;
use App\models\Shipments;
use DB;
use Carbon\Carbon;
use DateTime;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request,$type='')
    {
        //$res['total_earnings'] = Shipments::whereIn('status',['6','7'])->sum('cod_amount');
        $earnings = Shipments::whereIn('status',['6','7'])->get();
        $res['delivered'] = Shipments::whereIn('status',['6','7'])->count('id');
        $res['ongoingd'] = Shipments::where('status',5)->count('id');
        $res['total_order'] = Shipments::whereNotIn('status',[0,11])->count('id');
        $total_earnings = 0;
        if(!empty($earnings))
        {
            foreach($earnings as $key => $value) {
              $total_earnings += $value->cod_amount;
            }
        }
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

       return view('admin.dashboard',compact('res'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit_profile()
    {
        return view('admin.account.edit-profile');
    }  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('admin.account.profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile_update(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $this->validate($request,[
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'email' => 'required|max:255|email|unique:admins,email,'.$admin->id.',id',
            'mobile' => 'required|max:10|unique:admins,mobile,'.$admin->id.',id',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);

        try{            
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->address = $request->address;
            $admin->mobile = $request->mobile;
            if($request->hasFile('picture')){
                Storage::delete($admin->picture);
                $admin->picture = $request->picture->store('admin/profile');  
            }
            $admin->save();
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
        return view('admin.account.change-password');
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

           $Admin = Admin::find(Auth::guard('admin')->user()->id);

            if(password_verify($request->old_password, $Admin->password))
            {
                if($request->old_password==$request->password)
                {
                    return back()->with('flash_error','New password could not be same as current password!');
                }
                $Admin->password = bcrypt($request->password);
                $Admin->save();
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


    /**
     * Map of all Users and Drivers.
     *
     * @return \Illuminate\Http\Response
     */
    public function map_index()
    {
       //$riders = DeliveryRiders::select('latitude','longitude','address')->where('longitude', '!=', null)->where('latitude', '!=', null)->get();

        //return $riders = RiderCurrentLocation::orderBy('id', 'desc')->distinct('rider_id')->get();

       //$riders = DB::select('select t.* from (SELECT * FROM dri_rider_current_locations ORDER BY id DESC) as t group by `t`.`rider_id`');

       //$riders = collect($riders)->map(function($x){ return (array) $x; })->toArray(); 
      //DB::enableQueryLog()

       /*$riders = DB::table('rider_current_locations')->select('*')
            ->from(DB::raw('(SELECT * FROM dri_rider_current_locations ORDER BY id DESC) as t'))
            ->groupBy('rider_id')->orderBy('id','desc')->get();*/
    
         $riders_arr = DeliveryRiders::select('id')->get()->toArray();

         $ids = array_column($riders_arr, 'id');

         //$riders = array();

        /*$riders = DB::table('rider_current_locations')->select('*')
            ->from(DB::raw('(SELECT * FROM dri_rider_current_locations ORDER BY id DESC) as t'))->whereIn('rider_id',$ids)->groupBy('rider_id')->orderBy('id','desc')->get();*/

        $rider_ids = implode(',', $ids);
        $riders = [];
       
        if(!empty($ids))
        {
              $sql = "select * from dri_rider_current_locations,(select rider_id,max(created_at) as created_at from dri_rider_current_locations group by rider_id) max_user where dri_rider_current_locations.rider_id=max_user.rider_id and dri_rider_current_locations.created_at=max_user.created_at and dri_rider_current_locations.rider_id in (".$rider_ids.")";
              $riders = DB::select($sql);
        }

           // dd(DB::getQueryLog());

        if(!empty($riders))
        {
            foreach ($riders as $key => $value) {
              $drider = DeliveryRiders::find($value->rider_id);
              $riders[$key]->rider_name =  $drider->name;
               //$riders[$key]->picture =  img($drider->picture);
               $riders[$key]->picture =  asset('public/rider-icon.png');
            }
        }

       /*  $riders = array_map(function ($value) {
            return (array)$value;
        }, $riders);*/

       //dd(DB::getQueryLog());


       //echo "<pre>"; print_r( $riders);die;

        //$riders = (object) $riders;

       return view('admin.map.index',compact('riders'));
    }
    public function getRiderByHub($hub_id)
    {
        /*$riders = DeliveryRiders::select('latitude','longitude','address')->where('longitude', '!=', null)->where('latitude', '!=', null)->where('hub_id', '=', $hub_id)->get();*/

         $riders_arr = DeliveryRiders::select('id')->where('hub_id', '=', $hub_id)->get()->toArray();

         $ids = array_column($riders_arr, 'id');

        /*$riders = DB::table('rider_current_locations')->select('*')
            ->from(DB::raw('(SELECT * FROM dri_rider_current_locations ORDER BY id DESC) as t'))->whereIn('rider_id',$ids)->groupBy('rider_id')->orderBy('id','desc')->get()->toArray();*/

        $rider_ids = implode(',', $ids);
        $riders = [];
       
        if(!empty($ids))
        {
              $sql = "select * from dri_rider_current_locations,(select rider_id,max(created_at) as created_at from dri_rider_current_locations group by rider_id) max_user where dri_rider_current_locations.rider_id=max_user.rider_id and dri_rider_current_locations.created_at=max_user.created_at and dri_rider_current_locations.rider_id in (".$rider_ids.")";
              $riders = DB::select($sql);
        }
       
        if(!empty($riders))
        {
            foreach ($riders as $key => $value) {
              $drider = DeliveryRiders::find($value->rider_id);
              $riders[$key]->rider_name =  $drider->name;
              //$riders[$key]->picture =  img($drider->picture);
              $riders[$key]->picture =  asset('public/rider-icon.png');
            }
        }

      /*$data['location'] = $riders;
      $data['riders'] = $riders_arr;*/

       // return json_encode($data);
     /* $riders = array_map(function ($value) {
        return (array)$value;
    }, $riders);*/
      return $riders;
    }

    /**
     * Map of all Users and Drivers.
     *
     * @return \Illuminate\Http\Response
     */
    public function map_ajax()
    {
        try {

            $Providers = DeliveryRiders::where('latitude', '!=', 0)
                    ->where('longitude', '!=', 0)
                    ->with('service')
                    ->get();

            $Users = User::where('latitude', '!=', 0)
                    ->where('longitude', '!=', 0)
                    ->get();

            for ($i=0; $i < sizeof($Users); $i++) { 
                $Users[$i]->status = 'user';
            }

            $All = $Users->merge($Providers);

            return $All;

        } catch (Exception $e) {
            return [];
        }
    }

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

                    $shipment_ids = ShipmentAssignStatus::whereDate('created_at',"=", $today)->pluck('shipment_id');

                    $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->whereIn('shipment_id',$shipment_ids)->groupBy('shipment_id')->pluck('max_id');

                    $sql = Shipments::join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids)->whereDate('shipment_assign_status.created_at',"=", $today);

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

                                 $shipment_ids = ShipmentAssignStatus::whereDate('created_at',"=", $date)->pluck('shipment_id');

                                 $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->whereIn('shipment_id',$shipment_ids)->groupBy('shipment_id')->pluck('max_id');

                                 $sqlmonth = Shipments::join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids)->whereDate('shipment_assign_status.created_at',"=", $date);

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

                               $shipment_ids = ShipmentAssignStatus::whereDate('created_at',">=", $date_from)->whereDate('created_at',"<=", $date_to)->pluck('shipment_id');

                                 $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->whereIn('shipment_id',$shipment_ids)->groupBy('shipment_id')->pluck('max_id');

                                 $sqlmonth = Shipments::join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids)->whereDate('shipment_assign_status.created_at',">=", $date_from)->whereDate('shipment_assign_status.created_at',"<=", $date_to);


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
