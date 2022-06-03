<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\admin\MerchantDeliveryCharges as MDC;
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
    public function index()
    {
        $dcharges = MDC::with(['sdivision','ddivision','sdistrict','ddistrict','sthana','dthana','merchant'])->orderBy('created_at','desc')->get(); 
        return view('admin.merchants.delivery-charges.index',compact('dcharges'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.merchants.delivery-charges.create');
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
            'merchant_id' => 'required',            
            'product_type' => 'required',
            'from' => 'required',
            'to' => 'required',
            'gm_500' => 'required',
            'kg_1' => 'required',
            'kg_2' => 'required',
            'kg_3' => 'required',
            'kg_4' => 'required',
            'kg_5' => 'required',
            'kg_6' => 'required',
            'kg_7' => 'required',
            'kg_upto_seven' => 'required'
        ]);

        try{
            MDC::create($request->all());
            return redirect()->route('admin.delivery-charges.index')->with('flash_success','Merchant Delivery Charges Created Successfully');
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
            $dcharge = MDC::findOrFail($id);
            return view('admin.merchants.delivery-charges.details',compact('dcharge'));
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
            $dcharge = MDC::findOrFail($id);
            return view('admin.merchants.delivery-charges.edit',compact('dcharge'));
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
        $this->validate($request, [                     
            'merchant_id' => 'required',            
            'product_type' => 'required',
            'from' => 'required',
            'to' => 'required',
            'gm_500' => 'required',
            'kg_1' => 'required',
            'kg_2' => 'required',
            'kg_3' => 'required',
            'kg_4' => 'required',
            'kg_5' => 'required',
            'kg_6' => 'required',
            'kg_7' => 'required',
            'kg_upto_seven' => 'required'
        ]);
       

        try {
               $user = MDC::findOrFail($id);
               $user->update($request->all());
            return redirect()->route('admin.delivery-charges.index')->with('flash_success', 'Merchant Delivery Charges Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Not Found');
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
            $mdc = MDC::findOrFail($id);
            $mdc->delete();
            return back()->with('flash_success', 'Merchant Delivery Charges deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Merchant Delivery Charges Not Found');
        }
    }
}
