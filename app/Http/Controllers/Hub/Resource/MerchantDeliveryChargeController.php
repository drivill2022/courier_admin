<?php

namespace App\Http\Controllers\Hub\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\admin\MerchantDeliveryCharges as MDC;
use App\models\admin\Merchants;

class MerchantDeliveryChargeController extends Controller
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
    public function index(Request $request)
    {
        $dcharges=[];
        $merchant=$request->merchant?:'';
        if($merchant){
             $dcharges = MDC::with(['sdivision','ddivision','sdistrict','ddistrict','sthana','dthana','merchant'])->orderBy('created_at','desc');
            $merchant_ids = Merchants::where('name','like','%'.$request->merchant.'%')->pluck('id');
            $dcharges =$dcharges->whereIn('merchant_id',$merchant_ids);
            $dcharges =$dcharges->get(); 
        }
         
        return view('hub.merchants.delivery-charges.index',compact('dcharges','merchant'));
    }
}
