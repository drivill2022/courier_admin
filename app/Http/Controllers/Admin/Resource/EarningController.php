<?php

namespace App\Http\Controllers\Admin\Resource;

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
use App\models\ShipmentAssignStatus;
use Auth;
use Carbon\Carbon;
use DateTime;
use App\models\admin\Hubs;
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

            $cod_amount = Shipments::select('shipments.*')->where('merchant_id',$request->merchant)->whereIn('status', ['6','7'])->sum('cod_amount');

            $shipment_cost = Shipments::select('shipments.*')->where('merchant_id',$request->merchant)->whereIn('status', ['6','7'])->sum('shipment_cost');
           
            $merchantpayamount = MerchantPaymentAccount::where('merchant_id', $request->merchant)->sum('pay_amount');
            $remaining_amount = ((int)$cod_amount - (int)$merchantpayamount - (int)$shipment_cost);

            if($remaining_amount <= 0)
            {
              return redirect()->back()->with('flash_error','There is no amount to pay it should be greater than 0');
            }
            else if($request->pay_amount > $remaining_amount)
            {
              return redirect()->back()->with('flash_error',"Pay Amount shuold be less then or equal to current amount");
            }
                    
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
                    
            return redirect()->route('admin.merchant_transaction')->with('flash_success',' Created Successfully');
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
    public function payout_section()
    {
        $merchants = Merchants::orderBy('created_at','desc')->get();  
        $riders = DeliveryRiders::orderBy('created_at','desc')->get(); 
        $sellers = Seller::orderBy('created_at','desc')->get(); 
       /* $shipments = Shipments::with(['merchant','rider','rider.rider'])->orderBy('created_at','desc')->where('status', 7)->get();*/
        $shipments = Shipments::with(['merchant','rider','rider.rider'])->orderBy('created_at','desc')->get();
            return view('admin.earnings.payout-section',compact('merchants','sellers','shipments','riders'));
    }

     public function rider_earnings(Request $request)
    {
        $this->validate($request, [            
            'payment_mode' => 'required',
            'rider' => 'required',
            'pay_amount'=>'required|lte:currn_amount',
            //'status'=>'required',
        ],['pay_amount.lte' => 'Pay Amount shuold be less then or equal to current amount']);

        try{
                    
            $payment_acc = New RiderPaymentAccount;           
            $payment_acc->payment_mode = $request->payment_mode;           
            //$payment_acc->shipment_id = $request->shipment;        
            $payment_acc->txn_id = uniqid('#',true);           
            $payment_acc->rider_id = $request->rider;           
            $payment_acc->pay_amount = $request->pay_amount;           
            //$payment_acc->status = $request->status;  
            $payment_acc->status = "1";  
            $payment_acc->paid_by = Auth::guard('admin')->user()->id;  
            $payment_acc->save();         
                    
            return redirect()->route('admin.rider_transaction')->with('flash_success',' Created Successfully');
            }
        catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage());
        }
    }
     public function getMerchantRemAmt($merchant_id)
    {

        $shipment_ids = MerchantPaymentAccount::where('merchant_id', $merchant_id)->where('status', "1")->pluck('shipment_id')->toArray();

        $getdata = Shipments::select('shipments.*')->where('merchant_id',$merchant_id)->whereNotIn('id',$shipment_ids)->whereIn('status', ['6','7'])->get();

        /*$cod_amount = Shipments::select('shipments.*')->where('merchant_id',$merchant_id)->whereNotIn('id',$shipment_ids)->whereIn('status', ['6','7'])->sum('cod_amount');

        $shipment_cost = Shipments::select('shipments.*')->where('merchant_id',$merchant_id)->whereNotIn('id',$shipment_ids)->whereIn('status', ['6','7'])->sum('shipment_cost');*/

        $cod_amount = $shipment_cost = 0;
        if(!empty($getdata))
        {
            foreach ($getdata as $key => $value) {
              $cod_amount += $value->cod_amount;
              $shipment_cost += $value->shipment_cost;
            }
        }
        //$resp['cod_to_deposit']= $cod_to_deposit - $riderpayment;
        //$merchantpayamount = MerchantPaymentAccount::where('merchant_id', $merchant_id)->sum('pay_amount');
       // echo $cod_amount."///".$merchantpayamount."".$shipment_cost);
       // return ((int)$cod_amount - (int)$merchantpayamount - (int)$shipment_cost);
        return (int)($cod_amount - $shipment_cost);

    }

    public function getRiderRemAmt($rider_id)
    {
        $getdata = Shipments::select('shipments.*')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->where('shipment_assign_status.rider_id',$rider_id)->groupBy('shipment_assign_status.shipment_id')->groupBy('shipment_assign_status.status')->groupBy('shipment_assign_status.status')->whereIn('shipment_assign_status.status', ['6','7'])->get();

        $cod_to_deposit = $shipment_cost = 0;
        if(!empty($getdata))
        {
            foreach ($getdata as $key => $value) {
              $cod_to_deposit += $value->cod_amount;
              $shipment_cost += $value->shipment_cost;
            }
        }
        $riderpayamount = RiderPaymentAccount::where('rider_id', $rider_id)->sum('pay_amount');
   
        //return $cod_to_deposit - $riderpayamount;
        return ((int)$cod_to_deposit - (int)$riderpayamount - (int)$shipment_cost);

    }

     public function merchant_payment($merchant_id="")
    {
        $merchants = Merchants::orderBy('created_at','desc')->get();  
        $riders = DeliveryRiders::orderBy('created_at','desc')->get(); 
        $sellers = Seller::orderBy('created_at','desc')->get(); 
       /* $shipments = Shipments::with(['merchant','rider','rider.rider'])->orderBy('created_at','desc')->where('status', 7)->get();*/
        //$shipments = Shipments::with(['merchant','rider','rider.rider'])->orderBy('created_at','desc')->get();
       $paid_cod = 0;
       $remaining_shipments = $paid_shipments = [];
       $shipment_ids = MerchantPaymentAccount::where('merchant_id', $merchant_id)->where('status', "1")->pluck('shipment_id')->toArray();
       if($merchant_id != '')
       {
           $paid_shipments = Shipments::where('merchant_id',$merchant_id)->whereIn('id',$shipment_ids)->whereIn('status',['6','7'])->orderBy('created_at','desc')->get();
           $remaining_shipments = Shipments::where('merchant_id',$merchant_id)->whereNotIn('id',$shipment_ids)->whereIn('status',['6','7'])->orderBy('created_at','desc')->get();
           //$paid_cod = MerchantPaymentAccount::where('merchant_id', $merchant_id)->sum('pay_amount');
           //$cod_amount = Shipments::where('merchant_id',$merchant_id)->whereIn('id',$shipment_ids)->whereIn('status',['6','7'])->orderBy('created_at','desc')->sum('cod_amount');
           //$shipment_cost = Shipments::where('merchant_id',$merchant_id)->whereIn('id',$shipment_ids)->whereIn('status',['6','7'])->orderBy('created_at','desc')->sum('shipment_cost');

           if(!empty($paid_shipments))
           {
            foreach ($paid_shipments as $key => $value) {
              $payment_date = MerchantPaymentAccount::where('shipment_id', $value->id)->first();
              $paid_shipments[$key]->payment_date = date('d M,Y',strtotime($payment_date->created_at));
            }
           }

           $getdata = Shipments::where('merchant_id',$merchant_id)->whereIn('id',$shipment_ids)->whereIn('status',['6','7'])->orderBy('created_at','desc')->get();
         
         $cod_amount = $shipment_cost = 0;
        if(!empty($getdata))
        {
            foreach ($getdata as $key => $value) {
              $cod_amount += $value->cod_amount;
              if($value->cod_amount != 0)
              {
                 $shipment_cost += $value->shipment_cost;
              } 
            }
        }
           $paid_cod = $cod_amount - $shipment_cost;
       }
       /*else
       {
           $shipments = Shipments::whereIn('status',['6','7'])->orderBy('created_at','desc')->get();
       }*/
        
            return view('admin.earnings.merchant-payment',compact('merchants','sellers','paid_shipments','remaining_shipments','riders','paid_cod','shipment_ids'));
    }

     public function merchant_transaction(Request $request,$type,$merchant_id='')
    {
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
                          $merchantpaymentlist = MerchantPaymentAccount::selectRaw("*,max(created_at) as max_date,DATE_FORMAT(created_at, '%Y-%m-%d') AS created_date")->where('status','1')->where('merchant_id',$merchant_id)->whereDate('created_at',"=", $today)->groupBy('txn_id','merchant_id','created_date')->orderBy('max_date','desc')->get();
                        }
                        else
                        {
                         /* $merchantpaymentlist = MerchantPaymentAccount::where('status','1')->whereDate('created_at',"=", $today)->groupBy('txn_id','merchant_id')->latest()->get();*/
                          $merchantpaymentlist = MerchantPaymentAccount::selectRaw("*,max(created_at) as max_date,DATE_FORMAT(created_at, '%Y-%m-%d') AS created_date")->where('status','1')->whereDate('created_at',"=", $today)->groupBy('txn_id','merchant_id','created_date')->orderBy('max_date','desc')->get();
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
                          $merchantpaymentlist = MerchantPaymentAccount::selectRaw("*,max(created_at) as max_date,DATE_FORMAT(created_at, '%Y-%m-%d') AS created_date")->where('status','1')->where('merchant_id',$merchant_id)->whereDate('created_at',">=", $date_from)->whereDate('created_at',"<=", $date_to)->groupBy('txn_id','merchant_id','created_date')->orderBy('max_date','desc')->get();
                        }
                        else
                        {
                          $merchantpaymentlist = MerchantPaymentAccount::selectRaw("*,max(created_at) as max_date,,DATE_FORMAT(created_at, '%Y-%m-%d') AS created_date")->where('status','1')->whereDate('created_at',">=", $date_from)->whereDate('created_at',"<=", $date_to)->groupBy('txn_id','merchant_id','created_date')->orderBy('max_date','desc')->get();
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
                          $merchantpaymentlist = MerchantPaymentAccount::selectRaw("*,max(created_at) as max_date,DATE_FORMAT(created_at, '%Y-%m-%d') AS created_date")->where('status','1')->where('merchant_id',$merchant_id)->whereDate('created_at',">=", $date_from)->whereDate('created_at',"<=", $date_to)->groupBy('txn_id','merchant_id','created_date')->orderBy('max_date','desc')->get();
                        }
                        else
                        {
                          $merchantpaymentlist = MerchantPaymentAccount::selectRaw("*,max(created_at) as max_date,DATE_FORMAT(created_at, '%Y-%m-%d') AS created_date")->where('status','1')->whereDate('created_at',">=", $date_from)->whereDate('created_at',"<=", $date_to)->groupBy('txn_id','merchant_id','created_date')->orderBy('max_date','desc')->get();
                        }
                        break;
                }      

            }
        $total_pay = 0;
        if(!empty($merchantpaymentlist))
        {
            foreach ($merchantpaymentlist as $key => $value) {
                $merchant = Merchants::find($value->merchant_id);
                $merchantpaymentlist[$key]->created_at = $value->max_date;
                $merchantpaymentlist[$key]->merchant_name = $merchant->name;
                $merchantpaymentlist[$key]->buss_name = $merchant->buss_name;
                $getAllShipment = MerchantPaymentAccount::where('txn_id',$value->txn_id)->whereDate('created_at',$value->created_at)->where('merchant_id',$value->merchant_id)->pluck('shipment_id');
                $merchantpaymentlist[$key]->shipment = Shipments::whereIn('id',$getAllShipment)->get();
                $cod_amount = Shipments::whereIn('id',$getAllShipment)->sum('cod_amount');
                $shipment_cost = Shipments::whereIn('id',$getAllShipment)->sum('shipment_cost');
                $amount = $cod_amount - $shipment_cost;
                $merchantpaymentlist[$key]->amount = $amount;
                $total_pay = $total_pay + $amount;
                //$merchantpaymentlist[$key]->shipment = Shipments::find($value->shipment_id);
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
        //$total_pay = $merchantpaymentlist->sum('pay_amount');
        $filter = @$request->filter;
        $type = @$type;
        $merchants=Merchants::where('status','Active')->orderBy('name','asc')->get();
        $merchant_id = @$merchant_id;

        return view('admin.earnings.merchant-transaction',compact('merchantpaymentlist','total_pay','riderpaymentlist','filter','type','merchants','merchant_id'));
    }

     public function rider_transaction()
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
        return view('admin.earnings.rider-transaction',compact('merchantpaymentlist','merchant_total_pay','total_pay','riderpaymentlist','rider_total_pay'));
    }

      public function rider_payment()
    {
        $merchants = Merchants::orderBy('created_at','desc')->get();  
        $riders = DeliveryRiders::orderBy('created_at','desc')->get(); 
        $sellers = Seller::orderBy('created_at','desc')->get(); 
       /* $shipments = Shipments::with(['merchant','rider','rider.rider'])->orderBy('created_at','desc')->where('status', 7)->get();*/
        $shipments = Shipments::with(['merchant','rider','rider.rider'])->orderBy('created_at','desc')->get();
            return view('admin.earnings.rider-payment',compact('merchants','sellers','shipments','riders'));
    }

    /*public function rider_deposit(Request $request, $type)
    {
        $riderDeposit = RiderDepositAmount::orderBy('created_at','desc');  
       
        $deposit_amount = $riderDeposit->sum('amount');

        $deposit_amount = 0;

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
                        $riderDeposit = $riderDeposit->whereDate('created_at',"=", $today);
                        $deposit_amount = RiderDepositAmount::whereDate('created_at',"=", $today)->sum('amount');
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
                        $riderDeposit = $riderDeposit->whereDate('created_at',">=", $date_from)->whereDate('created_at',"<=", $date_to);
                        $deposit_amount = RiderDepositAmount::whereDate('created_at',">=", $date_from)->whereDate('created_at',"<=", $date_to)->sum('amount');
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
                        
                        $riderDeposit = $riderDeposit->whereDate('created_at',">=", $date_from)->whereDate('created_at',"<=", $date_to);
                        $deposit_amount = RiderDepositAmount::whereDate('created_at',">=", $date_from)->whereDate('created_at',"<=", $date_to)->sum('amount');
                        break;
                }      

            }
            else
            {
              abort(404,'Page not found');
            }
        $riderDepositList = $riderDeposit->get();

         if(!empty($riderDepositList))
        {
            foreach ($riderDepositList as $key => $value) {
                $rider = DeliveryRiders::find($value->rider_id);
                $riderDepositList[$key]->rider_name = $rider->name;
            }
        }
     
      $resp['filter'] = @$request->filter;
      $resp['deposit_amount'] = $deposit_amount;

       return view('admin.earnings.rider-deposit',compact('deposit_amount','riderDepositList','resp'));
    }*/

     public function rider_shipment_report(Request $request,$type,$rider_id='')
        {
            try{

             // DB::enableQueryLog();

            /*$sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipment_assign_status.rider_id','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->groupBy('shipment_assign_status.shipment_id');*/

            $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->groupBy('shipment_id')->pluck('max_id');

            $sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipment_assign_status.rider_id','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids);

            /*$sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipment_assign_status.rider_id','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->groupBy('shipments.id');*/

            /*$sql = Shipments::join(DB::raw('(select hub_id,rider_id,shipment_id, Max(created_at) as date from dri_shipment_assign_status GROUP BY shipment_id) max_user'),'shipment_id','shipments.id')->select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','date as created_at','date as max_date','shipments.merchant_id','rider_id');*/

            if($rider_id != '')
            {
                //$sql = $sql->where('updated_by_id',$rider_id);
                $sql = $sql->where('rider_id',$rider_id);
                //$sql = $sql->where(DB::raw('max_user.rider_id'),$rider_id);
            }
            else
            {
               $rider_ids= DeliveryRiders::pluck('id'); 
               $sql = $sql->whereIn('rider_id',$rider_ids);
            }
             //$getdata = $sql->whereNotIn('shipments.status',[0,11])->get();
           // dd(DB::getQueryLog());
        
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
           // dd(DB::getQueryLog());

            if(!empty($getdata))
            {
                foreach ($getdata as $key => $value) {
                  $cod_collected += $value->cod_amount;
                  $rider = DeliveryRiders::find($value->rider_id);
                  $getdata[$key]->rider_name = @$rider->name;
                   $merchant = Merchants::find($value->merchant_id);
                  $getdata[$key]->merchant_name = $merchant->name;
                  $getdata[$key]->buss_name = @$merchant->buss_name;
                }
            }

            $resp['total_cod_collected']= $cod_collected;
            $resp['statement']= $getdata;
            $resp['filter']= @$request->filter;
            $resp['rider_id']= @$rider_id;
            $riders = DeliveryRiders::orderBy('created_at','desc')->get(); 
            $resp['riders']= $riders;
        
           return view('admin.delivery-riders.shipment-report',compact('resp'));
            }
            catch (Exception $e) {
                return back()->with('flash_error', $e->getMessage());
            }
        }

     public function rider_earning_statement(Request $request,$type,$rider_id='')
        {
            try{
            /*$sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipment_assign_status.rider_id','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->groupBy('shipments.id');*/

            /*$sql = Shipments::join(DB::raw('(select hub_id,rider_id,shipment_id, Max(created_at) as date from dri_shipment_assign_status where status in (6,7) GROUP BY shipment_id) max_user'),'shipment_id','shipments.id')->select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','date as created_at','date as max_date','shipments.merchant_id','rider_id');*/

            $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->groupBy('shipment_id')->pluck('max_id');

            $sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipment_assign_status.rider_id','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids);

            if($rider_id != '')
            {
                //$sql = $sql->where('updated_by_id',$rider_id);
                //$sql = $sql->where(DB::raw('max_user.rider_id'),$rider_id);
                $sql = $sql->where('rider_id',$rider_id);
            }
            else
            {
               $rider_ids= DeliveryRiders::pluck('id'); 
               //$sql = $sql->whereIn(DB::raw('max_user.rider_id'),$rider_ids);
                $sql = $sql->whereIn('rider_id',$rider_ids);
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
            //$sql = $sql->orderBy(DB::raw('max_user.date'),'desc');
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
                  $getdata[$key]->rider_name = @$rider->name;
                  $merchant = Merchants::find($value->merchant_id);
                  $getdata[$key]->merchant_name = @$merchant->name;
                  $getdata[$key]->buss_name = @$merchant->buss_name;
                }
            }

            $resp['total_cod_collected']= $cod_collected;
            $resp['statement']= $getdata;
            $resp['filter']= @$request->filter;
            $resp['rider_id']= @$rider_id;
            $riders = DeliveryRiders::orderBy('created_at','desc')->get(); 
            $resp['riders']= $riders;
           return view('admin.delivery-riders.earning-statement',compact('resp'));
            }
            catch (Exception $e) {
                return back()->with('flash_error', $e->getMessage());
            }
        }

        /* public function changeRiderDepositStatus(Request $request)
        {
            try{
                        
                $rider_deposit = RiderDepositAmount::find($request->id);
                $rider_deposit->status = $request->status;  
                $rider_deposit->save();         
                        
                return $rider_deposit;
                }
            catch (Exception $e) {
                return back()->with('flash_error', $e->getMessage());
            }
        }*/

          public function merchant_earning_statement(Request $request,$type,$merchant_id='')
        {
            try{
           /* $sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipments.shipment_cost','shipment_assign_status.created_at','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->groupBy('shipment_assign_status.shipment_id');*/

            $sql = Shipments::join(DB::raw('(select shipment_id, Max(created_at) as date from dri_shipment_assign_status GROUP BY shipment_id) max_user'),'shipment_id','shipments.id')->select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','date as created_at','date as max_date','shipments.merchant_id');

            if($merchant_id != '')
            {
                $sql = $sql->where('merchant_id',$merchant_id);
                $paid_cod = MerchantPaymentAccount::where('merchant_id', $merchant_id)->sum('pay_amount');
            }
            else
            {
                //$paid_cod = MerchantPaymentAccount::sum('pay_amount');
              $paid_cod = 0;
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

            $cod_collected = $shipment_cost = 0;
            $getdata = $sql1->get();
            /* if($merchant_id != '')
            {*/
            if(!empty($getdata))
            {
                foreach ($getdata as $key => $value) {
                  $cod_collected += $value->cod_amount;
                  /*if($value->cod_amount > 0)
                  {*/
                    $shipment_cost += $value->shipment_cost;
                  //}
                  $merchant = Merchants::find($value->merchant_id);
                  $getdata[$key]->merchant_name = @$merchant->name;
                  $getdata[$key]->buss_name = @$merchant->buss_name;
                }
            }
          //}

            $resp['total_cod_collected']= $cod_collected;
            $resp['total_earning']= $cod_collected - $shipment_cost;
            $resp['pending_cod']= ($cod_collected>0)?($cod_collected - $paid_cod - $shipment_cost):$cod_collected;
            $resp['statement']= $getdata;
            $resp['filter']= @$request->filter;
            $resp['merchant_id']= @$merchant_id;
            $merchants=Merchants::where('status','Active')->orderBy('name','asc')->get();
            $resp['merchants']= $merchants;
        
           return view('admin.merchants.earning-statement',compact('resp'));
            }
            catch (Exception $e) {
                return back()->with('flash_error', $e->getMessage());
            }
        }


        public function merchant_shipment_report(Request $request,$type,$merchant_id='')
        {
            try{
           /* $sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipments.merchant_id')
              ->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->groupBy('shipment_assign_status.shipment_id');*/

         /*$sql = DB::select(DB::raw('select dri_shipments.status,dri_shipments.shipment_no,dri_shipments.product_detail,dri_shipments.cod_amount,dri_shipments.merchant_id,max_user.created_at from dri_shipments,(select shipment_id,max(created_at) as created_at from dri_shipment_assign_status group by shipment_id) max_user where dri_shipments.id = max_user.shipment_id'));*/
          // DB::enableQueryLog();

         $sql = Shipments::join(DB::raw('(select shipment_id, Max(created_at) as date from dri_shipment_assign_status GROUP BY shipment_id) max_user'),'shipment_id','shipments.id')->select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','date as created_at','date as max_date','shipments.merchant_id');

         //dd(DB::getQueryLog());


            if($merchant_id != '')
            {
                $sql = $sql->where('merchant_id',$merchant_id);
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
                        $sql = $sql->where(DB::raw('max_user.date'),'>=',$date_from)->where(DB::raw('max_user.date'),'<=',$date_to);
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
                  $getdata[$key]->buss_name = @$merchant->buss_name;
                }
            }

            $resp['total_cod_collected']= $cod_collected;
            $resp['statement']= $getdata;
            $resp['filter']= @$request->filter;
            $resp['merchant_id']= @$merchant_id;
            $merchants=Merchants::where('status','Active')->orderBy('name','asc')->get();
            $resp['merchants']= $merchants;
        
           return view('admin.merchants.shipment-report',compact('resp'));
            }
            catch (Exception $e) {
                return back()->with('flash_error', $e->getMessage());
            }
        }

         public function withdraw_request()
        {
            $max_id = MerchantWithdrawRequest::selectRaw('max(id) as max_id')->groupBy('merchant_id')->latest()->pluck('max_id');

            $merchantwithdrawlist = MerchantWithdrawRequest::select('merchant_withdraw_requests.*','merchants.name')->join('merchants','merchants.id','merchant_withdraw_requests.merchant_id')->whereIn('merchant_withdraw_requests.id',$max_id)->groupBy('merchant_id')->latest()->get();

            if(!empty($merchantwithdrawlist))
            {
              foreach ($merchantwithdrawlist as $key => $value) {
                $merchantwithdrawlist[$key]->pay_amount = $this->getMerchantRemAmt($value->merchant_id);
              }
            }
            //echo '<pre>'; print_r($merchantwithdrawlist);die;
            return view('admin.earnings.withdraw-request',compact('merchantwithdrawlist'));
        }

       public function hub_earning_statement(Request $request,$type,$hub_id='')
        {
            try{

           /* $sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipment_assign_status.rider_id','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->groupBy('shipments.id');*/

           $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->groupBy('shipment_id')->pluck('max_id');

            $sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipment_assign_status.rider_id','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids);

           /* $sql = Shipments::join(DB::raw('(select hub_id,rider_id,shipment_id, Max(created_at) as date from dri_shipment_assign_status GROUP BY shipment_id) max_user'),'shipment_id','shipments.id')->select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','date as created_at','date as max_date','shipments.merchant_id','rider_id');*/

            if($hub_id != '')
            {
                /*$riders_ids = DeliveryRiders::select('id')->where('hub_id',$hub_id)->get()->toArray();
                $rider_id = array_column($riders_ids, 'id');*/
                //$sql = $sql->whereIn('updated_by_id',$rider_id);
                $riders_ids = DeliveryRiders::select('id')->where('hub_id',$hub_id)->pluck('id');
                $sql = $sql->whereIn('rider_id',$riders_ids);
                //$sql = $sql->where('hub_id',$hub_id);
                //$sql = $sql->where(DB::raw('max_user.hub_id'),$hub_id);
            }
            else
            {
             /*  $hub_ids= Hubs::pluck('id');
               $riders_ids = DeliveryRiders::select('id')->whereIn('hub_id',$hub_ids)->get()->toArray();
               $rider_id = array_column($riders_ids, 'id');*/ 
               $rider_id = DeliveryRiders::pluck('id'); 
               $sql = $sql->whereIn('rider_id',$rider_id);
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
                  $getdata[$key]->rider_name = @$rider->name;
                  $merchant = Merchants::find($value->merchant_id);
                  $getdata[$key]->merchant_name = @$merchant->name;
                  $getdata[$key]->buss_name = @$merchant->buss_name;
                  $hub = Hubs::find(@$rider->hub_id);
                  $getdata[$key]->hub_name = @$hub->name;
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
         public function hub_shipment_report(Request $request,$type,$hub_id='')
        {
            try{
            /*$sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipment_assign_status.rider_id','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->groupBy('shipments.id');*/

            $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->groupBy('shipment_id')->pluck('max_id');

            $sql = Shipments::select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','shipment_assign_status.created_at','shipment_assign_status.rider_id','shipments.merchant_id')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids);

            /*$sql = Shipments::join(DB::raw('(select hub_id,rider_id,shipment_id, Max(created_at) as date from dri_shipment_assign_status GROUP BY shipment_id) max_user'),'shipment_id','shipments.id')->select('shipments.status','shipments.shipment_no','shipments.product_detail','shipments.cod_amount','date as created_at','date as max_date','shipments.merchant_id','rider_id');*/

            if($hub_id != '')
            {
                /*$riders_ids = DeliveryRiders::select('id')->where('hub_id',$hub_id)->get()->toArray();
                $rider_id = array_column($riders_ids, 'id');
                //$sql = $sql->whereIn('updated_by_id',$rider_id);
                $sql = $sql->whereIn('rider_id',$rider_id);
                //$sql = $sql->where('hub_id',$hub_id);
                //$sql = $sql->where(DB::raw('max_user.hub_id'),$hub_id);*/
                $riders_ids = DeliveryRiders::select('id')->where('hub_id',$hub_id)->pluck('id');
                $sql = $sql->whereIn('rider_id',$riders_ids);
            }
            else
            {
               /*$hub_ids= Hubs::pluck('id');
               $riders_ids = DeliveryRiders::select('id')->whereIn('hub_id',$hub_ids)->get()->toArray();
               $rider_id = array_column($riders_ids, 'id'); 
               $sql = $sql->whereIn('rider_id',$rider_id);*/
               $rider_id = DeliveryRiders::pluck('id'); 
               $sql = $sql->whereIn('rider_id',$rider_id);
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
                  $getdata[$key]->rider_name = @$rider->name;
                   $merchant = Merchants::find($value->merchant_id);
                  $getdata[$key]->merchant_name = $merchant->name;
                  $getdata[$key]->buss_name = @$merchant->buss_name;
                  $hub = Hubs::find(@$rider->hub_id);
                  $getdata[$key]->hub_name = @$hub->name;
                }
            }

            $resp['total_cod_collected']= $cod_collected;
            $resp['statement']= $getdata;
            $resp['filter']= @$request->filter;
            $resp['hub_id']= @$hub_id;
        
           return view('admin.hubs.shipment-report',compact('resp'));
            }
            catch (Exception $e) {
                return back()->with('flash_error', $e->getMessage());
            }
        }

         public function hub_payment()
        {
            $hubs = Hubs::orderBy('created_at','desc')->get();  
            $riders = DeliveryRiders::orderBy('created_at','desc')->get(); 
            $sellers = Seller::orderBy('created_at','desc')->get(); 
            $shipments = Shipments::with(['merchant','rider','rider.rider'])->orderBy('created_at','desc')->get();
            return view('admin.earnings.hub-payment',compact('hubs','sellers','shipments','riders'));
        }
        public function getHubRemAmt($hub_id)
        {
            $riders_ids = DeliveryRiders::select('id')->where('hub_id',$hub_id)->get()->toArray();
            $rider_id = array_column($riders_ids, 'id');

            $getdata = Shipments::select('shipments.*')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.rider_id',$rider_id)->groupBy('shipment_assign_status.shipment_id')->groupBy('shipment_assign_status.status')->groupBy('shipment_assign_status.status')->whereIn('shipment_assign_status.status', ['6','7'])->get();

            $cod_to_deposit = $shipment_cost = 0;
            if(!empty($getdata))
            {
                foreach ($getdata as $key => $value) {
                  $cod_to_deposit += $value->cod_amount;
                  $shipment_cost += $value->shipment_cost;
                }
            }
            //$riderpayamount = RiderPaymentAccount::where('rider_id', $rider_id)->sum('pay_amount');
       
            //return ((int)$cod_to_deposit - (int)$riderpayamount - (int)$shipment_cost);
            return ((int)$cod_to_deposit - (int)$shipment_cost);

        }

/*public function hub_deposit(Request $request, $type)
    {
        $hubDeposit = HubDepositAmount::orderBy('created_at','desc');  
       
        $deposit_amount = $hubDeposit->sum('amount');

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
                        $hubDeposit = $hubDeposit->whereDate('created_at',"=", $today);
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
                        $hubDeposit = $hubDeposit->whereDate('created_at',">=", $date_from)->whereDate('created_at',"<=", $date_to);
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
                        
                        $hubDeposit = $hubDeposit->whereDate('created_at',">=", $date_from)->whereDate('created_at',"<=", $date_to);
                        break;
                }      

            }
            else
            {
              abort(404,'Page not found');
            }
        $hubDepositList = $hubDeposit->get();

         if(!empty($hubDepositList))
        {
            foreach ($hubDepositList as $key => $value) {
                $hub = Hubs::find($value->hub_id);
                $hubDepositList[$key]->hub_name = $hub->name;
            }
        }
     
      $resp['filter'] = @$request->filter;
      $resp['deposit_amount'] = $deposit_amount;

       return view('admin.earnings.hub-deposit',compact('deposit_amount','hubDepositList','resp'));
    }*/

    /*public function changeHubDepositStatus(Request $request)
        {
            try{
                        
                $hub_deposit = HubDepositAmount::find($request->id);
                $hub_deposit->status = $request->status;  
                $hub_deposit->save();         
                        
                return $hub_deposit;
                }
            catch (Exception $e) {
                return back()->with('flash_error', $e->getMessage());
            }
        }*/

  public function changeHubDepositStatus(Request $request)
        {
            try{
                        
                $hub_deposit = New HubDepositAmount;
                $hub_deposit->shipment_id = $request->shipment_id;  
                $hub_deposit->hub_id = $request->hub_id;  
                $hub_deposit->amount = $request->amount;  
                $hub_deposit->status = "1";  
                $hub_deposit->save();         
                        
                return $hub_deposit;
                }
            catch (Exception $e) {
                return back()->with('flash_error', $e->getMessage());
            }
        }

  public function hub_deposit(Request $request,$hub_id='')
    {   
      //DB::enableQueryLog();
      $total_earnings = $shipment_cost =  $amount_deposite = $hubdeposite = 0;
      if($hub_id != '')
      { 
        $earnings = Shipments::select('id','shipment_no','cod_amount','shipment_cost')->whereHas('rider',function($query) use($hub_id)
        {
           $riders_ids = DeliveryRiders::select('id')->where('hub_id',$hub_id)->pluck('id')->toArray();
           $query->whereIn('rider_id',$riders_ids);
        })->whereIn('status',['6','7'])->get();
       // dd(DB::getQueryLog());

       /* echo "<pre>";
        print_r($earnings);die;*/

        $amount_deposite = HubDepositAmount::where('hub_id', $hub_id)->where('status', "1")->pluck('shipment_id')->toArray();
        $hubdeposite = HubDepositAmount::where('hub_id', $hub_id)->where('status', "1")->sum('amount');

        $res = [];
        if(count($earnings) > 0)
        {
            foreach($earnings as $key => $value) {
              $res[$key]['shipment_no'] = $value->shipment_no;
              $res[$key]['shipment_id'] = $value->id;
              $res[$key]['total_earnings'] = $value->cod_amount;
              $res[$key]['shipment_cost'] = $value->shipment_cost;
              $total_earnings += $value->cod_amount;
            }
        }
            $total_earnings= $total_earnings - $hubdeposite;
       }


        $hubDepositList = @$res;
        $hub_id = @$hub_id;
        $amount_deposite = $amount_deposite?$amount_deposite:[];
       return view('admin.earnings.hub-deposit',compact('hubDepositList','hub_id','total_earnings','amount_deposite'));
    }

    public function rider_deposit(Request $request,$rider_id='')
    {   
      //DB::enableQueryLog();
      $total_earnings = $shipment_cost =  $amount_deposite = $hubdeposite = 0;
      if($rider_id != '')
      { 
        /*$earnings = Shipments::select('id','shipment_no','cod_amount','shipment_cost')->whereHas('rider',function($query) use($rider_id)
        {
           $query->where('rider_id',$rider_id)->whereIn('status',['6','7'])->orderBy('created_at','desc');
        })->whereIn('status',['6','7'])->get();*/

       $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->groupBy('shipment_id')->pluck('max_id');

        $earnings = Shipments::select('shipments.id','shipments.shipment_no','shipments.cod_amount','shipments.shipment_cost','shipments.pickup_date')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids)->whereIn('shipments.status',['6','7'])->where('rider_id',$rider_id)->orderBy('shipment_assign_status.created_at','desc')->get();

        /*$earnings = Shipments::join(DB::raw('(select hub_id,rider_id,shipment_id, Max(created_at) as date from dri_shipment_assign_status GROUP BY shipment_id) max_user'),'shipment_id','shipments.id')->select('shipments.status','shipments.shipment_no','shipments.id','shipments.cod_amount','shipments.shipment_cost')->where(DB::raw('max_user.rider_id'),$rider_id)->whereIn('status',['6','7'])->orderBy(DB::raw('max_user.date'),'desc')->get();*/

       // dd(DB::getQueryLog());

       /* echo "<pre>";
        print_r($earnings);die;*/

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
           // $total_earnings= $total_earnings - $hubdeposite;
           // $total_earnings= $total_earnings - $hubdeposite;
       }

        
        $riderDepositList = @$res;
        $rider_id = @$rider_id;
        $amount_deposite = $amount_deposite?$amount_deposite:[];
        $riders = DeliveryRiders::orderBy('created_at','desc')->get(); 
       return view('admin.earnings.rider-deposit',compact('riderDepositList','rider_id','total_earnings','amount_deposite','riders','hubdeposite'));
    }

     public function changeRiderDepositStatus(Request $request)
        {
            try{
                
                $rider_deposite = RiderDepositAmount::where('shipment_id',$request->shipment_id)->where('rider_id',$request->rider_id)->first();
                if(empty($rider_deposite))
                {
                  $rider_deposit = New RiderDepositAmount;
                  $rider_deposit->shipment_id = $request->shipment_id;  
                  $rider_deposit->rider_id = $request->rider_id;  
                  $rider_deposit->amount = $request->amount;  
                  $rider_deposit->status = "1";  
                  $rider_deposit->save();          
                  return $rider_deposit;
                }
                
                }
            catch (Exception $e) {
                return back()->with('flash_error', $e->getMessage());
            }
        }

  public function payMerchantPayment(Request $request)
    {
        try{
            /*$cod_amount = Shipments::select('shipments.*')->where('merchant_id',$request->merchant)->whereIn('status', ['6','7'])->sum('cod_amount');

            $shipment_cost = Shipments::select('shipments.*')->where('merchant_id',$request->merchant)->whereIn('status', ['6','7'])->sum('shipment_cost');
           
            $merchantpayamount = MerchantPaymentAccount::where('merchant_id', $request->merchant)->sum('pay_amount');
            $remaining_amount = ((int)$cod_amount - (int)$merchantpayamount - (int)$shipment_cost);

            if($remaining_amount <= 0)
            {
              return redirect()->back()->with('flash_error','There is no amount to pay it should be greater than 0');
            }
            else if($request->pay_amount > $remaining_amount)
            {
              return redirect()->back()->with('flash_error',"Pay Amount shuold be less then or equal to current amount");
            }*/

            /*$shipment = Shipments::find($request->shipment_id);
                    
            $payment_acc = New MerchantPaymentAccount;           
            $payment_acc->payment_mode = '0';           
            //$payment_acc->shipment_id = $request->shipment;        
            $payment_acc->txn_id = uniqid('#',true);           
            $payment_acc->shipment_id = $request->shipment_id;           
            $payment_acc->merchant_id = $request->merchant;           
            $payment_acc->pay_amount = $shipment->cod_amount;           
            //$payment_acc->status = $request->status;  
            $payment_acc->status = "1";  
            $payment_acc->paid_by = Auth::guard('admin')->user()->id;  
            $payment_acc->save();  */  
            //return $request->payment_mode;
            //return $request->shipment;
            if($request->has('shipment'))
            { 
               foreach ($request->shipment as $key => $value) {
                  $shipment = Shipments::find($value);
                  $payment_acc = New MerchantPaymentAccount;           
                  $payment_acc->payment_mode = $request->payment_mode;           
                  //$payment_acc->shipment_id = $request->shipment;        
                  $payment_acc->txn_id = $request->txn_id;           
                  $payment_acc->shipment_id = $value;           
                  $payment_acc->merchant_id = $request->merchant;           
                  $payment_acc->pay_amount = is_null($shipment->cod_amount)?0:$shipment->cod_amount;           
                  //$payment_acc->status = $request->status;  
                  $payment_acc->status = "1";  
                  $payment_acc->paid_by = Auth::guard('admin')->user()->id;  
                  $payment_acc->save();    
                  //return $payment_acc;   
               }
            }
               $objetoRequest = new \Illuminate\Http\Request();
               $objetoRequest->merchant_id = $request->merchant;;
               $objetoRequest->txnid = $request->txn_id;;
               $this->sendInvoice($objetoRequest);
               return response()->json(['status'=> true,'msg' => "Payment Successfully"]);     
            }
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]); 
        }
    }


    public function sendInvoice(Request $request)
    {
        try{
            $merchant = Merchants::find($request->merchant_id);
            $merchant_payment = MerchantPaymentAccount::where('txn_id',$request->txnid)->latest()->first();
            $response['txn_id'] = $request->txnid;
            $response['merchant_name'] = $merchant->name;
            $response['created_at'] = date('d M,Y',strtotime($merchant_payment->created_at));
            $response['payment_mode'] = payment_mode($merchant_payment->payment_mode);
            $getAllShipment = MerchantPaymentAccount::where('txn_id',$request->txnid)->pluck('shipment_id');
            $response['shipment'] = Shipments::whereIn('id',$getAllShipment)->get();
            $cod_amount = Shipments::whereIn('id',$getAllShipment)->sum('cod_amount');
            $shipment_cost = Shipments::whereIn('id',$getAllShipment)->sum('shipment_cost');
            $amount = $cod_amount - $shipment_cost;
            $response['amount'] = '<img src="'.asset("/public/backend/images/drivill/BD_currency_icon.png").'" style="width: 15px;"> '. $amount;

            $to = $merchant->email;
            if($to == '')
            {
              return response()->json(['status'=> false,'msg' => "Merchant didn't save any email id so can't sent to mail"]);
            }
            //$to = 'user@mailinator.com';
            $subject = "Invoice";

            $htmlContent = '<div style="max-width: 890px;
        margin: auto;
        padding:10px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 14px;
        line-height: 24px;
        font-family: Helvetica, Arial, sans-serif;
        color: #555;">
        <table style="width: 100%;
        line-height: inherit;
        text-align: left;
    border-bottom: solid 1px #ccc;" cellpadding="0" cellspacing="0">
    <tr style="padding:10px;">
       <td colspan="2">
          <h2 style="margin-bottom: 0px;">Hello, '.$response['merchant_name'].'</h2>
       </td>
        <td  style="width:30%; margin-right: 10px;text-align: right;">
            <img src="'.asset("/public/backend/images/drivill/new_logo.jpeg").'" style="width: 150px;margin: 15px;">
       </td>
    </tr>
            <tr class="information">
                  <td colspan="3">
                    <table style="width: 100%;
        line-height: inherit;
        text-align: left;
    border-bottom: solid 1px #ccc;">
                        <tr>
                            <td style="vertical-align: text-bottom;padding-bottom: 25px;">
                               You have a new invoice for the amount of '.$response['amount'].'.If you have any questions Please let us know within 48 hours. 
                            </td>
                             </tr>
                            <tr>
                            <td style="padding-bottom: 40px;"> <b>Transaction Id: '.$response['txn_id'].'</b><br>
                              Date: '.$response['created_at'].' <br>
                                Amount: '.$response['amount'].'<br>
                                Payment Mode: '.$response['payment_mode'].'
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
                            <td colspan="3">
            <table cellspacing="0px" cellpadding="2px" style="width: 100%;
        line-height: inherit;
        text-align: left;
    border-bottom: solid 1px #ccc;">
            <tr style="background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    font-size:12px;">
                <td style="width:25%;">
                    Shipment ID
                </td>
        <td style="width:10%; text-align:center;">
                    COD Amount
                </td>
                <td style="width:10%; text-align:right;">
                    Shipment Cost 
                </td>
         <td style="width:15%; text-align:right;">
                   Available Balance
                </td>
            </tr>';
            $remaining_amount = 0;
          foreach ($response['shipment'] as $key => $value) {
        $remaining_amount += ($value->cod_amount - $value->shipment_cost);
       $htmlContent .= '<tr class="item">
               <td style="width:25%;border-bottom: 1px solid #eee;">'.$value->shipment_no.'
                </td>
        <td style="width:10%; text-align:center;border-bottom: 1px solid #eee;">
                   '.$value->cod_amount.'
                </td>
                <td style="width:10%; text-align:right;border-bottom: 1px solid #eee;">
                   '.$value->shipment_cost.'
                </td>
         <td style="width:15%; text-align:right;border-bottom: 1px solid #eee;">
                    '.($value->cod_amount - $value->shipment_cost).'
                </td>
            </tr>';
            }
             $htmlContent .= '
      </table>
      <table style="width:100%">
            <tr class="total">
                  <td colspan="3" align="right" style="border-top: 2px solid #eee;
        font-weight: bold;">  Total Amount:  <img src="'.asset("/public/backend/images/drivill/BD_currency_icon.png").'" style="width: 15px;"> <b>'.$remaining_amount.'</b> </td>
            </tr>
      <tr>
        <td colspan="3" align="center" style="font-size:12px;">You can Return this email to us for any concern or complain regarding this invoice.</td>
      </tr>
      <tr>
        <td align="center" colspan="3" style="font-size:12px;">2022-2027© drivill.</td>
      </tr>
        </table>
    </div>
';
          //return $htmlContent;

            // Set content-type header for sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // Additional headers
            $headers .= 'From: Drivill<payments@drivill.com>' . "\r\n";
            /*$headers .= 'Cc: admin@drivill.com' . "\r\n";
            $headers .= 'Bcc: admin@drivill.com' . "\r\n";*/

            // Send email
            //mail($to,$subject,$htmlContent,$headers);

            \Mail::send([], [], function ($message) use ($to,$subject,$htmlContent) {
                        $message->to($to)
                    ->subject($subject)
                    ->from('payments@drivill.com')
                    ->setBody($htmlContent, 'text/html');
            });
        
            return response()->json(['status'=> true,'msg' => "Invoice Sent Successfully"]);
            }
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]); 
        }
    }
}
