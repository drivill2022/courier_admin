<?php

namespace App\Http\Controllers\Admin\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\admin\Merchants;
use App\models\Shipments;
use Auth;
use Storage;
use App\models\admin\MerchantDeliveryCharges as MDC;
use App\models\admin\MerchantPaymentAccount;
use App\models\ShipmentAssignStatus;
use App\models\ShipmentStatusLog;

class MerchantController extends Controller
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
        $merchants = Merchants::orderBy('created_at','desc')->get(); 
        $block_merchants = $merchants->where('status','Blocked'); 
        $active_merchants = $merchants->where('status','Active'); 
        $pending_merchants = $merchants->where('status','Onboarding'); 
        return view('admin.merchants.index',compact('block_merchants','active_merchants','pending_merchants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.merchants.create');
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
            'name' => 'required|max:255',            
            'address' => 'required|max:255',            
            'email' => 'nullable|unique:merchants,email|email|max:255',
            'mobile' => 'digits_between:8,12|unique:merchants,mobile',
            'picture' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'password' => 'required|min:8|confirmed',
            'business_logo' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'fb_page' => 'required',
            'thana' => 'required',
            'district' => 'required',
            'division' => 'required',
            'nid_number' => 'required',
            'buss_name' => 'required|max:255',            
            'buss_phone' => 'digits_between:8,14|unique:merchants,buss_phone',
            'buss_address' => 'required|max:255',            
            'payment_method' => 'required',
            'product_type' => 'required',
            'trade_lic_no' => 'nullable|mimes:jpeg,jpg,bmp,png|max:5242880',
            'status' => 'required'
        ]);

        try{
            $user = $request->all();            
            $user = $request->all();            
            $user['password'] = bcrypt($request->password);
            $user['product_type'] = trim(implode(',',$request->product_type));
            if($request->hasFile('picture')) {
                $user['picture'] = $request->picture->store('merchant/profile');
            }
            if($request->hasFile('business_logo')) {
                $user['business_logo'] = $request->business_logo->store('merchant/business-logo');
            }if($request->hasFile('trade_lic_no')) {
                $user['trade_lic_no'] = $request->trade_lic_no->store('merchant/trade-lic-pic');
            }
            $user = Merchants::create($user);  
            $user->mrid = '#MN'.sprintf('%03d', $user->id);
            $user->save();
            return redirect()->route('admin.merchants.index')->with('flash_success','Merchant Created Successfully');
            }
        catch (Exception $e) {
            dd($e->getMessage());
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
            $merchant = Merchants::findOrFail($id);
            $merchant->delivered = Shipments::where('merchant_id',$id)->whereIn('status',['6','7'])->count('id');
            $merchant->ongoingd = Shipments::where('merchant_id',$id)->where('status',5)->count('id');
            $merchant->cancelled = Shipments::where('merchant_id',$id)->where('status',8)->count('id');
            $merchant->rejected = Shipments::where('merchant_id',$id)->whereIn('status',[8,9])->count('id');
            $merchant->total = Shipments::where('merchant_id',$id)->whereIn('status',[5,6,7,8,9])->count('id');

            return view('admin.merchants.details',compact('merchant'));
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
            $merchant = Merchants::findOrFail($id);
            return view('admin.merchants.edit',compact('merchant'));
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
        $request->validate([                     
            'name' => 'required|max:255',            
            'address' => 'required|max:255',            
            'email' => 'nullable|unique:merchants,email,'.$id.',id|email|max:255',
            'mobile' => 'required|digits_between:8,12|unique:merchants,mobile,'.$id.',id',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'business_logo' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'fb_page' => 'required',
            'thana' => 'required',
            'district' => 'required',
            'division' => 'required',
             'nid_number' => 'required',
            'buss_name' => 'required|max:255',            
            'buss_phone' => 'digits_between:8,14|unique:merchants,buss_phone,'.$id.',id',
            'buss_address' => 'required|max:255',            
            'payment_method' => 'required',
            'product_type' => 'required',
            'trade_lic_no' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'status' => 'required'
        ]);

        try {
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
            $user->status=$request->status;          
            $user->save();
            return redirect()->route('admin.merchants.index')->with('flash_success', 'Merchant Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Merchant Not Found');
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
            $user = Merchants::findOrFail($id);
            $shipments = Shipments::where('merchant_id',$id)->pluck('id');
            ShipmentAssignStatus::whereIn('shipment_id',$shipments)->delete();
            ShipmentStatusLog::whereIn('shipment_id',$shipments)->delete();
            Shipments::where('merchant_id',$id)->delete();
            MDC::where('merchant_id',$id)->delete();
            
           $user->delete();
            return back()->with('flash_success', 'Merchant deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Merchant Not Found');
        }
    }

    public function detail($id)
    {
        try {
            $merchant = Merchants::findOrFail($id);
            return $merchant;
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
    public function availableBalance()
    {
        try {
            $merchants = Merchants::orderBy('created_at','desc')->where('status','Active')->get();
            $positive_merchants = $negative_merchants = [];
            if(!empty($merchants))
            {
                foreach ($merchants as $key => $value) {

                   $merchant_id = $value->id;
                   $shipment_ids = MerchantPaymentAccount::where('merchant_id', $merchant_id)->where('status', "1")->pluck('shipment_id')->toArray();

                    $cod_amount = Shipments::select('shipments.*')->where('merchant_id',$merchant_id)->whereNotIn('id',$shipment_ids)->whereIn('status', ['6','7'])->sum('cod_amount');

                    $shipment_cost = Shipments::select('shipments.*')->where('merchant_id',$merchant_id)->whereNotIn('id',$shipment_ids)->whereIn('status', ['6','7'])->sum('shipment_cost');

                    $merchants[$key]->available_balance = ((int)$cod_amount - (int)$shipment_cost);
                    
                    if($merchants[$key]->available_balance > 0)
                    {
                         $positive_merchants[] = $merchants[$key];
                    }
                    else if($merchants[$key]->available_balance < 0)
                    {
                         $negative_merchants[] = $merchants[$key];
                    }
                    
                }
            }
            return view('admin.merchants.available-balance',compact('positive_merchants','negative_merchants'));

        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
}
