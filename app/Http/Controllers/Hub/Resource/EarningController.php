<?php

namespace App\Http\Controllers\Hub\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\admin\Merchants;
use App\models\admin\DeliveryRiders;
use App\models\admin\Seller;
use App\models\Shipments;
use App\models\admin\MerchantPaymentAccount;
use App\models\admin\RiderPaymentAccount;
use App\models\admin\RiderDepositAmount;
use App\models\ShipmentAssignStatus;
use App\models\admin\HubDepositAmount;
use App\models\MerchantWithdrawRequest;
use Auth;
use Carbon\Carbon;
use DateTime;
use App\models\admin\Hubs;

class EarningController extends Controller
{

     public function rider_shipment_report(Request $request,$type,$rider_id='')
        {
            try{

            $hub_id=Auth::guard('hub')->user()->id;
            $riders = DeliveryRiders::where('hub_id',$hub_id)->pluck('id')->toArray(); 

            /*$sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipment_assign_status.rider_id','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->groupBy('shipment_assign_status.shipment_id');*/

            $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->where('hub_id',$hub_id)->groupBy('shipment_id')->pluck('max_id');

            $sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipment_assign_status.rider_id','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids);

            if($rider_id != '')
            {
                //$sql = $sql->where('updated_by_id',$rider_id);
                $sql = $sql->where('rider_id',$rider_id);
            }
            else
            {
                //$sql = $sql->whereIn('updated_by_id',$riders);
                $sql = $sql->whereIn('rider_id',$riders);
            }

             //$sql = $sql->where('hub_id',$hub_id);
        
            if(!empty($type) && in_array($type, array('daily','weekly','monthly'))) {
                switch (strtolower($type)) {
                    case 'daily':
                        if($request->filter)
                        {
                           $today = Carbon::createFromFormat('Y-m-d', $request->filter);
                        }
                        else
                        {
                          $today = Carbon::today()->format('Y-m-d');
                        }
                        $sql = $sql->whereDate('shipment_assign_status.created_at',"=", $today);
                        break;
                    case 'weekly':
                        if($request->filter)
                        {
                            $filter = explode('-',$request->filter);
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
                        $sql = $sql->whereDate('shipment_assign_status.created_at',">=", $date_from)->whereDate('shipment_assign_status.created_at',"<=", $date_to);
                        break;
                    case 'monthly':
                        if($request->filter)
                        {
                         $date_from = date('Y-m-01', strtotime($request->filter));
                         $date_to = date('Y-m-t', strtotime($request->filter)); 
                        }
                        else
                        {
                          $date = Date('F, Y'); 
                          $date_from = date('Y-m-01', strtotime($date));
                          $date_to = date('Y-m-t', strtotime($date)); 
                        }
                        
                        $sql = $sql->whereDate('shipment_assign_status.created_at',">=", $date_from)->whereDate('shipment_assign_status.created_at',"<=", $date_to);
                        break;
                }      

            }
            else
            {
              abort(404,'Page not found');
            }

             $sql = $sql->orderBy('shipment_assign_status.created_at','desc');

            $sql1=clone $sql;
            $sql2=clone $sql;
            $sql3=clone $sql;
            $sql4=clone $sql;
            $sql5=clone $sql;
            $sql6=clone $sql;
            $sql7=clone $sql;

            $resp['ongoingd']= count($sql->whereIn('shipments.status',[5,10])->get());
            $resp['return']= count($sql1->where('shipments.status', 9)->get());

            $resp['completed']= count($sql2->whereIn('shipments.status', [6,7])->get());

            $resp['cancelled']= count($sql3->where('shipments.status',8)->get());
            $resp['unassign']= count($sql7->where('shipments.status',1)->get());
            $resp['ongoing']= count($sql5->whereIn('shipments.status',[2,3])->get());
            $resp['transit']= count($sql6->whereIn('shipments.status',[4,12])->get());

             // dd(DB::getQueryLog());

            $resp['total']= $resp['completed'] + $resp['ongoingd'] + $resp['return'] + $resp['cancelled'] + $resp['unassign'] + $resp['ongoing'] + $resp['transit'];

            $cod_collected = 0;
            $getdata = $sql4->whereNotIn('shipments.status',[0,11])->get();
            if(!empty($getdata))
            {
                foreach ($getdata as $key => $value) {
                  $cod_collected += $value->cod_amount;
                  $rider = DeliveryRiders::find($value->rider_id);
                  $getdata[$key]->rider_name = $rider->name;
                   $merchant = Merchants::find($value->merchant_id);
                  $getdata[$key]->merchant_name = $merchant->name;
                }
            }

            $resp['total_cod_collected']= $cod_collected;
            $resp['statement']= $getdata;
            $resp['filter']= @$request->filter;
            $resp['rider_id']= @$rider_id;
            $hub_id=Auth::guard('hub')->user()->id;
            $riders = DeliveryRiders::where('hub_id',$hub_id)->orderBy('created_at','desc')->get(); 
            //$riders = DeliveryRiders::orderBy('created_at','desc')->get(); 
            $resp['riders']= $riders;
        
           return view('hub.delivery-riders.shipment-report',compact('resp'));
            }
            catch (Exception $e) {
                return back()->with('flash_error', $e->getMessage());
            }
        }

     public function rider_earning_statement(Request $request,$type,$rider_id='')
        {
            try{

            $hub_id=Auth::guard('hub')->user()->id;
            $riders = DeliveryRiders::where('hub_id',$hub_id)->pluck('id'); 
            /*$sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipment_assign_status.rider_id','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->groupBy('shipment_assign_status.shipment_id')->groupBy('shipment_assign_status.status');*/

            
            $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->where('hub_id',$hub_id)->groupBy('shipment_id')->pluck('max_id');

            $sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipment_assign_status.rider_id','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids);

            if($rider_id != '')
            {
                $sql = $sql->where('rider_id',$rider_id);
            }
            else
            {
               $sql = $sql->whereIn('rider_id',$riders);
            }

             //$sql = $sql->where('hub_id',$hub_id);
        
            if(!empty($type) && in_array($type, array('daily','weekly','monthly'))) {
                switch (strtolower($type)) {
                    case 'daily':
                        if($request->filter)
                        {
                           $today = Carbon::createFromFormat('Y-m-d', $request->filter);
                        }
                        else
                        {
                          $today = Carbon::today()->format('Y-m-d');
                        }
                        $sql = $sql->whereDate('shipment_assign_status.created_at',"=", $today);
                        break;
                    case 'weekly':
                        if($request->filter)
                        {
                            $filter = explode('-',$request->filter);
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
                        $sql = $sql->whereDate('shipment_assign_status.created_at',">=", $date_from)->whereDate('shipment_assign_status.created_at',"<=", $date_to);
                        break;
                    case 'monthly':
                        if($request->filter)
                        {
                         $date_from = date('Y-m-01', strtotime($request->filter));
                         $date_to = date('Y-m-t', strtotime($request->filter)); 
                        }
                        else
                        {
                          $date = Date('F, Y'); 
                          $date_from = date('Y-m-01', strtotime($date));
                          $date_to = date('Y-m-t', strtotime($date)); 
                        }
                        
                        $sql = $sql->whereDate('shipment_assign_status.created_at',">=", $date_from)->whereDate('shipment_assign_status.created_at',"<=", $date_to);
                        break;
                }      

            }
            else
            {
              abort(404,'Page not found');
            }

            $sql = $sql->orderBy('shipment_assign_status.created_at','desc');

            $sql1=clone $sql;
            $sql2=clone $sql;
            $sql3=clone $sql;
            
            $resp['picked_up']= count($sql->where('shipments.status', 3)->get());

            $resp['delivered']= count($sql1->whereIn('shipments.status', ['6','7'])->get());

            $resp['cancelled']= count($sql2->where('shipments.status',8)->get());

            $resp['pending']= count($sql3->where('shipments.status',0)->get());

            $cod_collected = 0;
            $getdata = $sql1->get();
            if(!empty($getdata))
            {
                foreach ($getdata as $key => $value) {
                  $cod_collected += $value->cod_amount;
                  $rider = DeliveryRiders::find($value->rider_id);
                  $getdata[$key]->rider_name = $rider->name;
                  $merchant = Merchants::find($value->merchant_id);
                  $getdata[$key]->merchant_name = $merchant->name;
                }
            }

            $resp['total_cod_collected']= $cod_collected;
            $resp['statement']= $getdata;
            $resp['filter']= @$request->filter;
            $resp['rider_id']= @$rider_id;
            //$hub_id=Auth::guard('hub')->user()->id;

            $riders = DeliveryRiders::where('hub_id',$hub_id)->orderBy('created_at','desc')->get(); 
            $resp['riders']= $riders;
           return view('hub.delivery-riders.earning-statement',compact('resp'));
            }
            catch (Exception $e) {
                return back()->with('flash_error', $e->getMessage());
            }
        }


       public function hub_earning_statement(Request $request,$type)
        {
            try{

            $hub_id=Auth::guard('hub')->user()->id;

            /*$sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipment_assign_status.rider_id','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->groupBy('shipment_assign_status.shipment_id')->groupBy('shipment_assign_status.status');*/

            $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->where('hub_id',$hub_id)->groupBy('shipment_id')->pluck('max_id');

            $sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipment_assign_status.rider_id','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids);
           
            $riders_ids = DeliveryRiders::select('id')->where('hub_id',$hub_id)->get()->toArray();
            $rider_id = array_column($riders_ids, 'id');
           // $sql = $sql->whereIn('updated_by_id',$rider_id);
            $sql = $sql->whereIn('rider_id',$rider_id);
        
            if(!empty($type) && in_array($type, array('daily','weekly','monthly'))) {
                switch (strtolower($type)) {
                    case 'daily':
                        if($request->filter)
                        {
                           $today = Carbon::createFromFormat('Y-m-d', $request->filter);
                        }
                        else
                        {
                          $today = Carbon::today()->format('Y-m-d');
                        }
                        $sql = $sql->whereDate('shipment_assign_status.created_at',"=", $today);
                        break;
                    case 'weekly':
                        if($request->filter)
                        {
                            $filter = explode('-',$request->filter);
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
                        $sql = $sql->whereDate('shipment_assign_status.created_at',">=", $date_from)->whereDate('shipment_assign_status.created_at',"<=", $date_to);
                        break;
                    case 'monthly':
                        if($request->filter)
                        {
                         $date_from = date('Y-m-01', strtotime($request->filter));
                         $date_to = date('Y-m-t', strtotime($request->filter)); 
                        }
                        else
                        {
                          $date = Date('F, Y'); 
                          $date_from = date('Y-m-01', strtotime($date));
                          $date_to = date('Y-m-t', strtotime($date)); 
                        }
                        
                        $sql = $sql->whereDate('shipment_assign_status.created_at',">=", $date_from)->whereDate('shipment_assign_status.created_at',"<=", $date_to);
                        break;
                }      

            }
            else
            {
              abort(404,'Page not found');
            }

            $sql = $sql->orderBy('shipment_assign_status.created_at','desc');

            $sql1=clone $sql;
            $sql2=clone $sql;
            $sql3=clone $sql;
            
            $resp['picked_up']= count($sql->where('shipments.status', 3)->get());

            $resp['delivered']= count($sql1->whereIn('shipments.status', ['6','7'])->get());

            $resp['cancelled']= count($sql2->where('shipments.status',8)->get());

            $resp['pending']= count($sql3->where('shipments.status',0)->get());

            $cod_collected = 0;
            $getdata = $sql1->get();
            if(!empty($getdata))
            {
                foreach ($getdata as $key => $value) {
                  $cod_collected += $value->cod_amount;
                  $rider = DeliveryRiders::find($value->rider_id);
                  $getdata[$key]->rider_name = $rider->name;
                  $merchant = Merchants::find($value->merchant_id);
                  $getdata[$key]->merchant_name = $merchant->name;
                  $hub = Hubs::find($rider->hub_id);
                  $getdata[$key]->hub_name = $hub->name;
                }
            }

            $resp['total_cod_collected']= $cod_collected;
            $resp['statement']= $getdata;
            $resp['filter']= @$request->filter;
            $resp['hub_id']= @$hub_id;
        
           return view('hub.reports.earning-statement',compact('resp'));
            }
            catch (Exception $e) {
                return back()->with('flash_error', $e->getMessage());
            }
        }
         public function hub_shipment_report(Request $request,$type)
        {
            try{

            $hub_id=Auth::guard('hub')->user()->id;
            /*$sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipment_assign_status.rider_id','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->groupBy('shipment_assign_status.shipment_id');*/

            $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->where('hub_id',$hub_id)->groupBy('shipment_id')->pluck('max_id');

            $sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipment_assign_status.rider_id','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids);
            
                $riders_ids = DeliveryRiders::select('id')->where('hub_id',$hub_id)->get()->toArray();
                $rider_id = array_column($riders_ids, 'id');
                //$sql = $sql->whereIn('updated_by_id',$rider_id);
                $sql = $sql->whereIn('rider_id',$rider_id);
        
            if(!empty($type) && in_array($type, array('daily','weekly','monthly'))) {
                switch (strtolower($type)) {
                    case 'daily':
                        if($request->filter)
                        {
                           $today = Carbon::createFromFormat('Y-m-d', $request->filter);
                        }
                        else
                        {
                          $today = Carbon::today()->format('Y-m-d');
                        }
                        $sql = $sql->whereDate('shipment_assign_status.created_at',"=", $today);
                        break;
                    case 'weekly':
                        if($request->filter)
                        {
                            $filter = explode('-',$request->filter);
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
                        $sql = $sql->whereDate('shipment_assign_status.created_at',">=", $date_from)->whereDate('shipment_assign_status.created_at',"<=", $date_to);
                        break;
                    case 'monthly':
                        if($request->filter)
                        {
                         $date_from = date('Y-m-01', strtotime($request->filter));
                         $date_to = date('Y-m-t', strtotime($request->filter)); 
                        }
                        else
                        {
                          $date = Date('F, Y'); 
                          $date_from = date('Y-m-01', strtotime($date));
                          $date_to = date('Y-m-t', strtotime($date)); 
                        }
                        
                        $sql = $sql->whereDate('shipment_assign_status.created_at',">=", $date_from)->whereDate('shipment_assign_status.created_at',"<=", $date_to);
                        break;
                }      

            }
            else
            {
              abort(404,'Page not found');
            }

             $sql = $sql->orderBy('shipment_assign_status.created_at','desc');

            $sql1=clone $sql;
            $sql2=clone $sql;
            $sql3=clone $sql;
            $sql4=clone $sql;
            $sql5=clone $sql;
            $sql6=clone $sql;
            $sql7=clone $sql;

            $resp['ongoingd']= count($sql->whereIn('shipments.status',[5,10])->get());
            $resp['return']= count($sql1->where('shipments.status', 9)->get());

            $resp['completed']= count($sql2->whereIn('shipments.status', [6,7])->get());

            $resp['cancelled']= count($sql3->where('shipments.status',8)->get());
            $resp['ongoing']= count($sql5->whereIn('shipments.status',[2,3])->get());
            $resp['transit']= count($sql6->whereIn('shipments.status',[4,12])->get());
            $resp['unassign']= count($sql7->where('shipments.status',1)->get());

             // dd(DB::getQueryLog());

            $resp['total']= $resp['completed'] + $resp['ongoingd'] + $resp['return'] + $resp['cancelled'] + $resp['unassign'] + $resp['ongoing'] + $resp['transit'];

            $cod_collected = 0;
            $getdata = $sql4->whereNotIn('shipments.status',[0,11])->get();
            if(!empty($getdata))
            {
                foreach ($getdata as $key => $value) {
                  $cod_collected += $value->cod_amount;
                  $rider = DeliveryRiders::find($value->rider_id);
                  $getdata[$key]->rider_name = $rider->name;
                   $merchant = Merchants::find($value->merchant_id);
                  $getdata[$key]->merchant_name = $merchant->name;
                  $hub = Hubs::find($rider->hub_id);
                  $getdata[$key]->hub_name = $hub->name;
                }
            }

            $resp['total_cod_collected']= $cod_collected;
            $resp['statement']= $getdata;
            $resp['filter']= @$request->filter;
            $resp['hub_id']= @$hub_id;
        
           return view('hub.reports.shipment-report',compact('resp'));
            }
            catch (Exception $e) {
                return back()->with('flash_error', $e->getMessage());
            }
        }

  public function rider_deposit(Request $request,$rider_id='')
     {   
      //DB::enableQueryLog();
      $total_earnings = $shipment_cost =  $amount_deposite = 0;
      if($rider_id != '')
      { 
        /*$earnings = Shipments::select('id','shipment_no','cod_amount','shipment_cost')->whereHas('rider',function($query) use($rider_id)
        {
           $query->where('rider_id',$rider_id)->whereIn('status',['6','7']);
        })->whereIn('status',['6','7'])->get();*/
        $hub_id=Auth::guard('hub')->user()->id;
        $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->where('hub_id',$hub_id)->groupBy('shipment_id')->pluck('max_id');

        $earnings = Shipments::select('shipments.id','shipments.shipment_no','shipments.cod_amount','shipments.shipment_cost')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids)->whereIn('shipments.status',['6','7'])->where('rider_id',$rider_id)->orderBy('shipment_assign_status.created_at','desc')->get();

       // dd(DB::getQueryLog());

       /* echo "<pre>";
        print_r($earnings);die;*/

        //$amount_deposite = RiderDepositAmount::where('rider_id', $rider_id)->where('status', "1")->pluck('amount')->toArray();
        $amount_deposite = RiderDepositAmount::where('rider_id', $rider_id)->where('status', "1")->pluck('shipment_id')->toArray();
        $hubdeposite = RiderDepositAmount::where('rider_id', $rider_id)->where('status', "1")->sum('amount');

        $res = [];
        if(count($earnings) > 0)
        {
            foreach($earnings as $key => $value) {
              $res[$key]['shipment_no'] = $value->shipment_no;
              $res[$key]['shipment_id'] = $value->id;
              $res[$key]['total_earnings'] = $value->cod_amount;
              $res[$key]['shipment_cost'] = $value->shipment_cost;
              $res[$key]['pickup_date'] = date('d M Y',strtotime($value->pickup_date));
              $total_earnings += $value->cod_amount;
            }
        }
            //$total_earnings= $total_earnings - $hubdeposite;
       }


        $riderDepositList = @$res;
        $rider_id = @$rider_id;
         $hub_id=Auth::guard('hub')->user()->id;
        $amount_deposite = $amount_deposite?$amount_deposite:[];
        $riders = DeliveryRiders::where('hub_id',$hub_id)->orderBy('created_at','desc')->get(); 
       return view('hub.earnings.rider-deposit',compact('riderDepositList','rider_id','total_earnings','amount_deposite','riders','hubdeposite'));
    }

     public function changeRiderDepositStatus(Request $request)
        {
            try{

                $rider_deposit = New RiderDepositAmount;
                $rider_deposit->shipment_id = $request->shipment_id;  
                $rider_deposit->rider_id = $request->rider_id;  
                $rider_deposit->amount = $request->amount;  
                $rider_deposit->status = "1";  
                $rider_deposit->save();         
                        
                return $rider_deposit;
                }
            catch (Exception $e) {
                return back()->with('flash_error', $e->getMessage());
            }
        }
}
