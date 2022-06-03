<?php

namespace App\Http\Controllers\Merchant\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\admin\Merchants;
use App\models\admin\DeliveryRiders;
use App\models\admin\Seller;
use App\models\Shipments;
use App\models\admin\MerchantPaymentAccount;
use App\models\admin\RiderPaymentAccount;
use App\models\admin\RiderDepositAmount;
use App\models\admin\HubDepositAmount;
use App\models\MerchantWithdrawRequest;
use Auth;
use Carbon\Carbon;
use DateTime;
use App\models\admin\Hubs;
use App\models\admin\Admin;
use DB;

class EarningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchantpaymentlist = MerchantPaymentAccount::where('status','1')->latest()->get();
        if(!empty($merchantpaymentlist))
        {
            foreach ($merchantpaymentlist as $key => $value) {
                $merchant = Merchants::find($value->merchant_id);
                $merchantpaymentlist[$key]->merchant_name = $merchant->name;
            }
        }
        $riderpaymentlist = RiderPaymentAccount::where('status','1')->latest()->get();
        if(!empty($riderpaymentlist))
        {
            foreach ($riderpaymentlist as $key => $value) {
                $rider = DeliveryRiders::find($value->rider_id);
                $riderpaymentlist[$key]->rider_name = $rider->name;
            }
        }
        $merchant_total_pay = $merchantpaymentlist->sum('pay_amount');
        $rider_total_pay = $riderpaymentlist->sum('pay_amount');
        $total_pay = $merchant_total_pay + $rider_total_pay;
        return view('admin.earnings.index',compact('merchantpaymentlist','merchant_total_pay','total_pay','riderpaymentlist','rider_total_pay'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
       
    }

     public function store(Request $request)
    {
        $this->validate($request, [            
            'payment_mode' => 'required',
            'merchant' => 'required',
            'pay_amount'=>'required|lte:currn_amount|gt:0',
            //'status'=>'required',
        ],['pay_amount.lte' => 'Pay Amount shuold be less then or equal to current amount']);

        try{
                    
            $payment_acc = New MerchantPaymentAccount;           
            $payment_acc->payment_mode = $request->payment_mode;           
            //$payment_acc->shipment_id = $request->shipment;        
            $payment_acc->txn_id = uniqid('#',true);           
            $payment_acc->merchant_id = $request->merchant;           
            $payment_acc->pay_amount = $request->pay_amount;           
            //$payment_acc->status = $request->status;  
            $payment_acc->status = "1";  
            $payment_acc->paid_by = Auth::guard('admin')->user()->id;  
            $payment_acc->save();         
                    
            return redirect()->route('merchant.merchant_transaction')->with('flash_success',' Created Successfully');
            }
        catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage());
        }
    }

     public function show($id)
    {
        
    }

    public function edit($id)
    {

    }
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
    {
        //
    }

     public function merchant_payment($merchant_id="")
    {
        $merchants = Merchants::orderBy('created_at','desc')->get();  
        $riders = DeliveryRiders::orderBy('created_at','desc')->get(); 
        $sellers = Seller::orderBy('created_at','desc')->get(); 
       /* $shipments = Shipments::with(['merchant','rider','rider.rider'])->orderBy('created_at','desc')->where('status', 7)->get();*/
        //$shipments = Shipments::with(['merchant','rider','rider.rider'])->orderBy('created_at','desc')->get();
       $paid_cod = 0;
       $shipments = [];
       if($merchant_id != '')
       {
           $shipments = Shipments::where('merchant_id',$merchant_id)->whereIn('status',['6','7'])->orderBy('created_at','desc')->get();
           $paid_cod = MerchantPaymentAccount::where('merchant_id', $merchant_id)->sum('pay_amount');
       }
       /*else
       {
           $shipments = Shipments::whereIn('status',['6','7'])->orderBy('created_at','desc')->get();
       }*/
        
            return view('merchant.earnings.merchant-payment',compact('merchants','sellers','shipments','riders','paid_cod'));
    }

     public function merchant_transaction(Request $request,$type)
    {
        
        $merchant_id = Auth::guard('merchant')->user()->id;
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
                        if($merchant_id != '')
                        {
                          $merchantpaymentlist = MerchantPaymentAccount::selectRaw("*,max(created_at) as max_date,DATE_FORMAT(created_at, '%Y-%m-%d') AS created_date")->where('status','1')->where('merchant_id',$merchant_id)->whereDate('created_at',"=", $today)->groupBy('txn_id','merchant_id','created_date')->latest()->get();
                        }
                        else
                        {
                          $merchantpaymentlist = MerchantPaymentAccount::selectRaw("*,max(created_at) as max_date,DATE_FORMAT(created_at, '%Y-%m-%d') AS created_date")->where('status','1')->whereDate('created_at',"=", $today)->groupBy('txn_id','merchant_id','created_date')->latest()->get();
                        }
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
                        if($merchant_id != '')
                        {
                          $merchantpaymentlist = MerchantPaymentAccount::selectRaw("*,max(created_at) as max_date,DATE_FORMAT(created_at, '%Y-%m-%d') AS created_date")->where('status','1')->where('merchant_id',$merchant_id)->whereDate('created_at',">=", $date_from)->whereDate('created_at',"<=", $date_to)->groupBy('txn_id','merchant_id','created_date')->latest()->get();
                        }
                        else
                        {
                          $merchantpaymentlist = MerchantPaymentAccount::selectRaw("*,max(created_at) as max_date,DATE_FORMAT(created_at, '%Y-%m-%d') AS created_date")->where('status','1')->whereDate('created_at',">=", $date_from)->whereDate('created_at',"<=", $date_to)->groupBy('txn_id','merchant_id','created_date')->latest()->get();
                        }
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
                        
                       if($merchant_id != '')
                        {
                          $merchantpaymentlist = MerchantPaymentAccount::selectRaw("*,max(created_at) as max_date,DATE_FORMAT(created_at, '%Y-%m-%d') AS created_date")->where('status','1')->where('merchant_id',$merchant_id)->whereDate('created_at',">=", $date_from)->whereDate('created_at',"<=", $date_to)->groupBy('txn_id','merchant_id','created_date')->latest()->get();
                        }
                        else
                        {
                          $merchantpaymentlist = MerchantPaymentAccount::selectRaw("*,max(created_at) as max_date,DATE_FORMAT(created_at, '%Y-%m-%d') AS created_date")->where('status','1')->whereDate('created_at',">=", $date_from)->whereDate('created_at',"<=", $date_to)->groupBy('txn_id','merchant_id','created_date')->latest()->get();
                        }
                        break;
                }      

            }
        
        $total_pay = 0;
        if(!empty($merchantpaymentlist))
        {
            foreach ($merchantpaymentlist as $key => $value) {
                $merchant = Merchants::find($value->merchant_id);
                $merchantpaymentlist[$key]->merchant_name = $merchant->name;
                $merchantpaymentlist[$key]->buss_name = $merchant->buss_name;
                $getAllShipment = MerchantPaymentAccount::where('txn_id',$value->txn_id)->whereDate('created_at',$value->created_at)->where('merchant_id',$value->merchant_id)->pluck('shipment_id');
                $merchantpaymentlist[$key]->shipment = Shipments::whereIn('id',$getAllShipment)->get();
                $cod_amount = Shipments::whereIn('id',$getAllShipment)->sum('cod_amount');
                $shipment_cost = Shipments::whereIn('id',$getAllShipment)->sum('shipment_cost');
                $amount = $cod_amount - $shipment_cost;
                $merchantpaymentlist[$key]->amount = $amount;
                $total_pay = $total_pay + $amount;
            }
        }
        $riderpaymentlist = RiderPaymentAccount::where('status','1')->latest()->get();
        if(!empty($riderpaymentlist))
        {
            foreach ($riderpaymentlist as $key => $value) {
                $rider = DeliveryRiders::find($value->rider_id);
                $riderpaymentlist[$key]->rider_name = $rider->name;
            }
        }
       /* $merchant_total_pay = $merchantpaymentlist->sum('pay_amount');
        $rider_total_pay = $riderpaymentlist->sum('pay_amount');*/
        //$total_pay = $merchant_total_pay + $rider_total_pay;
        $filter = @$request->filter;
        $type = @$type;
        return view('merchant.reports.payment-history',compact('merchantpaymentlist','total_pay','riderpaymentlist','filter','type'));
    }

    public function merchant_earning_statement(Request $request,$type,$merchant_id='')
        {
            try{
            $merchant_id = Auth::guard('merchant')->user()->id;

           /* $sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipments.shipment_cost','shipment_assign_status.created_at','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->where('shipments.merchant_id',$merchant_id)->groupBy('shipment_assign_status.shipment_id');*/

            $sql = Shipments::join(DB::raw('(select shipment_id, Max(created_at) as date from dri_shipment_assign_status GROUP BY shipment_id) max_user'),'shipment_id','shipments.id')->select('shipments.*','date as created_at','date as max_date')->where('merchant_id',$merchant_id);
          
            $paid_cod = MerchantPaymentAccount::where('merchant_id', $merchant_id)->sum('pay_amount');

             $shipment_ids = MerchantPaymentAccount::where('merchant_id', $merchant_id)->where('status', "1")->pluck('shipment_id')->toArray();

            /*****/

        $sql8=clone $sql;
        $sql9=clone $sql;

        $total_cod_collected = Shipments::select('shipment_no','receiver_name','product_detail','cod_amount','created_at')->where('merchant_id', $merchant_id)->whereIn('status', ['6','7'])->sum('cod_amount');

        //$total_cod_collected = $sql8->whereIn('shipment_status_logs.status', ['6','7'])->sum('cod_amount');

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

        /*****/
            
        
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
                        $sql = $sql->whereDate(DB::raw('max_user.date'),"=", $today);
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
                        $sql = $sql->whereDate(DB::raw('max_user.date'),">=", $date_from)->whereDate(DB::raw('max_user.date'),"<=", $date_to);
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
                        
                        $sql = $sql->whereDate(DB::raw('max_user.date'),">=", $date_from)->whereDate(DB::raw('max_user.date'),"<=", $date_to);
                        break;
                }      

            }
            else
            {
              abort(404,'Page not found');
            }
            
            $sql = $sql->orderBy(DB::raw('max_user.date'),'desc');

            $sql1=clone $sql;
            $sql2=clone $sql;
            $sql3=clone $sql;
            
            $resp['picked_up']= count($sql->where('shipments.status', 3)->get());

            $resp['delivered']= count($sql1->whereIn('shipments.status', ['6','7'])->get());

            $resp['cancelled']= count($sql2->where('shipments.status',8)->get());

            $resp['pending']= count($sql3->where('shipments.status',0)->get());

            $available_payout = $cod_collected = $shipment_cost = 0;
            $getdata = $sql1->get();
             if($merchant_id != '')
            {
            if(!empty($getdata))
            {
                foreach ($getdata as $key => $value) {
                  $cod_collected += $value->cod_amount;
                   $available_payout += $value->cod_amount;
                  /*if($value->cod_amount > 0)
                  {*/
                    $shipment_cost += $value->shipment_cost;
                  //}
                  $merchant = Merchants::find($value->merchant_id);
                  $getdata[$key]->merchant_name = @$merchant->name;
                }
            }
          }

            $drivill_service_charge = $shipment_cost;
            $resp['total_available_for_payout']= abs($resp['available_payout']);
            $resp['refund_from_drivill']= $available_payout - $drivill_service_charge;
            $resp['cash_collected'] = $available_payout;
            $resp['drivill_service_charge']= $drivill_service_charge;

            $resp['total_cod_collected']= $cod_collected;
            $resp['total_earning']= $cod_collected - $shipment_cost;
            $resp['pending_cod']= ($cod_collected>0)?$cod_collected - $paid_cod:$cod_collected;
            $resp['statement']= $getdata;
            $resp['filter']= @$request->filter;
            $resp['merchant_id']= @$merchant_id;
            $merchants=Merchants::where('status','Active')->orderBy('name','asc')->get();
            $resp['merchants']= $merchants;
        
           return view('merchant.reports.earning-statement',compact('resp'));
            }
            catch (Exception $e) {
                return back()->with('flash_error', $e->getMessage());
            }
        }


           public function merchant_shipment_report(Request $request,$type,$merchant_id='')
        {
            try{
            /*$sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->where('shipments.merchant_id',Auth::guard('merchant')->user()->id)->groupBy('shipment_assign_status.shipment_id');*/

            $sql = Shipments::join(DB::raw('(select shipment_id, Max(created_at) as date from dri_shipment_assign_status GROUP BY shipment_id) max_user'),'shipment_id','shipments.id')->select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','date as created_at','date as max_date','shipments.merchant_id')->where('shipments.merchant_id',Auth::guard('merchant')->user()->id);

        
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
                        $sql = $sql->whereDate(DB::raw('max_user.date'),"=", $today);
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
                        $sql = $sql->whereDate(DB::raw('max_user.date'),">=", $date_from)->whereDate(DB::raw('max_user.date'),"<=", $date_to);
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
                        
                        $sql = $sql->whereDate(DB::raw('max_user.date'),">=", $date_from)->whereDate(DB::raw('max_user.date'),"<=", $date_to);
                        break;
                }      

            }
            else
            {
              abort(404,'Page not found');
            }

            $sql = $sql->orderBy(DB::raw('max_user.date'),'desc');

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
            //$getdata = $sql4->whereIn('shipments.status',[5,6,8,9])->get();
            $getdata = $sql4->whereNotIn('shipments.status',[0,11])->get();
            
            if(!empty($getdata))
            {
                foreach ($getdata as $key => $value) {
                  $cod_collected += $value->cod_amount;
                  $merchant = Merchants::find($value->merchant_id);
                  $getdata[$key]->merchant_name = @$merchant->name;
                }
            }

            $resp['total_cod_collected']= $cod_collected;
            $resp['statement']= $getdata;
            $resp['filter']= @$request->filter;
            $resp['merchant_id']= @$merchant_id;
            $merchants=Merchants::where('status','Active')->orderBy('name','asc')->get();
            $resp['merchants']= $merchants;
        
           return view('merchant.reports.shipment-report',compact('resp'));
            }
            catch (Exception $e) {
                return back()->with('flash_error', $e->getMessage());
            }
        }

         public function withdraw_request()
        {
            $merchantwithdrawlist = MerchantWithdrawRequest::select('merchant_withdraw_requests.*','merchants.name')->join('merchants','merchants.id','merchant_withdraw_requests.merchant_id')->latest()->get();
            //echo '<pre>'; print_r($merchantwithdrawlist);die;
            return view('admin.earnings.withdraw-request',compact('merchantwithdrawlist'));
        }

       public function hub_earning_statement(Request $request,$type,$hub_id='')
        {
            try{

            $sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_status_logs.created_at','shipment_status_logs.updated_by_id','shipments.merchant_id')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->groupBy('shipment_status_logs.shipment_id')->groupBy('shipment_status_logs.status');
            if($hub_id != '')
            {
                $riders_ids = DeliveryRiders::select('id')->where('hub_id',$hub_id)->get()->toArray();
                $rider_id = array_column($riders_ids, 'id');
                $sql = $sql->whereIn('updated_by_id',$rider_id);
            }
        
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
                        $sql = $sql->whereDate('shipment_status_logs.created_at',"=", $today);
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
                        $sql = $sql->whereDate('shipment_status_logs.created_at',">=", $date_from)->whereDate('shipment_status_logs.created_at',"<=", $date_to);
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
                        
                        $sql = $sql->whereDate('shipment_status_logs.created_at',">=", $date_from)->whereDate('shipment_status_logs.created_at',"<=", $date_to);
                        break;
                }      

            }
            else
            {
              abort(404,'Page not found');
            }

            $sql1=clone $sql;
            $sql2=clone $sql;
            $sql3=clone $sql;
            
            $resp['picked_up']= count($sql->where('shipment_status_logs.status', 3)->get());

            $resp['delivered']= count($sql1->whereIn('shipment_status_logs.status', ['6','7'])->get());

            $resp['cancelled']= count($sql2->where('shipment_status_logs.status',8)->get());

            $resp['pending']= count($sql3->where('shipment_status_logs.status',0)->get());

            $cod_collected = 0;
            $getdata = $sql1->get();
            if(!empty($getdata))
            {
                foreach ($getdata as $key => $value) {
                  $cod_collected += $value->cod_amount;
                  $rider = DeliveryRiders::find($value->updated_by_id);
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
        
           return view('admin.hubs.earning-statement',compact('resp'));
            }
            catch (Exception $e) {
                return back()->with('flash_error', $e->getMessage());
            }
        }

        public function withdrawRequest()
          {
              try{

                $merchant_id = Auth::guard('merchant')->user()->id;

                 $amount = Shipments::select('shipments.*')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->where('shipments.merchant_id',$merchant_id)->groupBy('shipment_assign_status.shipment_id')->groupBy('shipment_assign_status.status')->whereIn('shipment_assign_status.status', ['6','7'])->sum('cod_amount');

                 $drivills_commissions = Shipments::select('shipments.*')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->where('shipments.merchant_id',$merchant_id)->groupBy('shipment_assign_status.shipment_id')->groupBy('shipment_assign_status.status')->whereIn('shipment_assign_status.status', ['6','7'])->get();

                $total_cod_collected = Shipments::select('shipment_no','receiver_name','product_detail','cod_amount','created_at')->where('merchant_id', $merchant_id)->whereIn('status', ['6','7'])->sum('cod_amount');

                $merchant_payment = MerchantPaymentAccount::where('merchant_id', $merchant_id)->sum('pay_amount');

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
                     return response()->json(['status'=>false,'message' => 'Withdraw limit should be minimum 100Tk.'], 200);
                  }

                  $today_date = date('Y-m-d');
                  $alreadyexist = MerchantWithdrawRequest::where('merchant_id',$merchant_id)->whereDate('created_at',"=", $today_date)->first();
                  if(!empty($alreadyexist))
                  {
                     return response()->json(['status'=>false,'message' => 'Today you already sent request'], 200);
                  }

                  $withdrawRequest = New MerchantWithdrawRequest;
                  $withdrawRequest->merchant_id = $merchant_id; 
                  $withdrawRequest->amount = $amount; 
                  $withdrawRequest->save();
                  return response()->json(['status'=>true,'message' =>'Withdraw Request Sent Successfully'],200);
              }catch(ModelNotFoundException $m){
                   return response()->json(['status'=>false,'message' => 'Withdraw Request Not found'], 404);
              }catch (Exception $e) {
                  return response()->json(['status'=>false,'message' => 'something went wrong'], 400);
              }

          }

          function notifications()
          {

            $merchant_id = Auth::guard('merchant')->user()->id;
            $data = \App\models\ShipNotification::select('ship_notifications.id','ship_notifications.rider_id','ship_notifications.shipment_id','ship_notifications.is_viewed','ship_notifications.created_at','notifications.message')->join('notifications','notifications.id','=','ship_notifications.notification_id')->where('merchant_id', $merchant_id)->orderBy('created_at','desc')->get();
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
              return view('merchant.notifications.list',compact('data'));
          }

          function notificationDetail($id)
          {
            $merchant_id = Auth::guard('merchant')->user()->id;
            $value = \App\models\ShipNotification::select('ship_notifications.id','ship_notifications.rider_id','ship_notifications.shipment_id','ship_notifications.is_viewed','ship_notifications.created_at','notifications.message')->join('notifications','notifications.id','=','ship_notifications.notification_id')->where('ship_notifications.id', $id)->first();

            $value->is_viewed = "1";
            $value->save();
              
                  $shipment = \App\models\Shipments::find($value->shipment_id);
                  $rider = \App\models\admin\DeliveryRiders::find($value->rider_id);
                  $value->message = str_replace("{{tracking_number}}",$shipment->shipment_no,$value->message);
                  $value->message = str_replace("{{rider_name}}",$rider->name,$value->message);
                  $value->message = str_replace("{{cod_amount}}",'Tk.'.$shipment->cod_amount,$value->message);


              
              return view('merchant.notifications.detail',compact('value'));
          }
}
