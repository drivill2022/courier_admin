<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\admin\Hubs;
use App\models\admin\DeliveryRiders;
use App\models\admin\RiderVehicleDetails;
use App\models\admin\VehicleTypes;
use App\Helper\ControllerHelper as Helper;
use App\models\Shipments;
use App\models\admin\RiderDepositAmount;
use App\models\ShipmentAssignStatus;
use Auth;
use Storage;
class DeliveryRiderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $riders=DeliveryRiders::orderBy('created_at','desc')->get();
        return view('admin.delivery-riders.index',compact('riders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicles=VehicleTypes::where('status','Active')->orderBy('name','asc')->get();
        return view('admin.delivery-riders.create',compact('vehicles'));
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
            'gender' => 'required|in:Male,Female,Other',            
            'hub_id' => 'required|max:255',            
            'address' => 'required|max:255',            
            'email' => 'nullable|unique:delivery_riders,email|email|max:255',
            'mobile' => 'required|digits_between:8,12|unique:delivery_riders,mobile',
            'picture' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'picture' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'password'    => 'required|min:8|confirmed',
            'nid_number'  => 'required',
            'nid_picture' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'father_nid_pic'  => 'required|max:255',
            'father_nid'  => 'required',
            'thana'       => 'required',
            'district'    => 'required',
            'division' => 'required',
            'status' => 'required',
            'vehicle_type_id' => 'required|in:1,2',
            'dl_photo'=>'required_if:vehicle_type_id,2|mimes:jpeg,jpg,bmp,png|max:5242880',
            'dl_number'=>'required_if:vehicle_type_id,2',
            'brand'=>'required_if:vehicle_type_id,2',
            'model'=>'required_if:vehicle_type_id,2',
            'region'=>'required_if:vehicle_type_id,2',
            'category'=>'required_if:vehicle_type_id,2',
            'plat_number'=>'required_if:vehicle_type_id,2',
            'token_number'=>'required_if:vehicle_type_id,2',
            'rc_photo'=>'required_if:vehicle_type_id,2|mimes:jpeg,jpg,bmp,png|max:5242880',
            'father_mobile'=> 'required',
        ],[
            'hub_id.required'=>'The hub is required.',
            'vehicle_type_id.required'=>'The vehicle type field is required.',
            'dl_photo.required_if'=>'The dl photo field is required when vehicle type is motorcycle.',
            'brand.required_if'=>'The brand field is required when vehicle type is motorcycle.',
            'model.required_if'=>'The model field is required when vehicle type is motorcycle.',
            'region.required_if'=>'The region field is required when vehicle type is motorcycle.',
            'category.required_if'=>'The category field is required when vehicle type is motorcycle.',
            'plat_number.required_if'=>'The plat number field is required when vehicle type is motorcycle.',
            'token_number.required_if'=>'The token number field is required when vehicle type is motorcycle.',
            'rc_photo.required_if'=>'The rc photo field is required when vehicle type is motorcycle.'
        ]);

        try{
            $user = $request->all();            
            $user['password'] = bcrypt($request->password);
            if($request->hasFile('picture')) {
                $user['picture'] = $request->picture->store('delivery-riders');
            }
           
            if($request->hasFile('nid_picture')) {
                $user['nid_picture'] = $request->nid_picture->store('delivery-riders/nidpic');
            }if($request->hasFile('father_nid_pic')) {
                $user['father_nid_pic'] = $request->father_nid_pic->store('delivery-riders/nidpic');
            }
            $user = DeliveryRiders::create($user);
            $user->referral_code=Helper::referral_code_generate($user);
            $user->save();
            if($user && $user->vehicle_type_id==2){
                $rvd = $request->all(); 
                $rvd['delivery_rider_id'] = $user->id;
            if($request->hasFile('dl_photo')) {
                $rvd['dl_photo'] = $request->dl_photo->store('delivery-riders/dlpic');
            }
            if($request->hasFile('rc_photo')) {
                $rvd['rc_photo'] = $request->rc_photo->store('delivery-riders/rcpic');
            }
            RiderVehicleDetails::create($rvd);
            }
           
            return redirect()->route('admin.riders.index')->with('flash_success','Rider Created Successfully');
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
        try{
            $rider=DeliveryRiders::findOrFail($id);
          $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->groupBy('shipment_id')->pluck('max_id');

        $getdata = Shipments::select('shipments.id','shipments.shipment_no','shipments.cod_amount','shipments.shipment_cost','shipments.pickup_date')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids)->whereIn('shipments.status',['6','7'])->where('rider_id',$id)->orderBy('shipment_assign_status.created_at','desc')->get();

        $cod_to_deposit = 0;
        if(!empty($getdata))
        {
            foreach ($getdata as $key => $value) {
              $cod_to_deposit += $value->cod_amount;
            }
        }
        //$resp['cod_to_deposit']= $cod_to_deposit - $riderpayment;
        $riderdeposite = RiderDepositAmount::where('rider_id', $id)->where('status', "1")->sum('amount');
        $cod_to_deposit= $cod_to_deposit - $riderdeposite;

            return view('admin.delivery-riders.details',compact('rider','cod_to_deposit'));
        }catch(Exception $e){
            return back()->with('flash_error',$e->getMessage());
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
        try{
            $rider=DeliveryRiders::findOrFail($id);
            $vehicles=VehicleTypes::where('status','Active')->orderBy('name','asc')->get();
            return view('admin.delivery-riders.edit',compact('rider','vehicles'));
        }catch(Exception $e){
            return back()->with('flash_error',$e->getMessage());
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
            'name' => 'required|max:255',
            'gender' => 'required|in:Male,Female,Other',            
            'hub_id' => 'required|max:255',            
            'address' => 'required|max:255',            
            'email' => 'nullable|email|max:255|unique:delivery_riders,email,'.$id.',id',
            'mobile' => 'required|digits_between:8,12|unique:delivery_riders,mobile,'.$id.',id',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'nid_number'  => 'required',
            'nid_picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'father_nid_pic'  => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'father_nid'  => 'required',
            /*'thana'       => 'required',
            'district'    => 'required',
            'division' => 'required',*/
            'status' => 'required',
            'vehicle_type_id' => 'required|in:1,2',
            'dl_photo'=>'mimes:jpeg,jpg,bmp,png|max:5242880',
            'dl_number'=>'required_if:vehicle_type_id,2',
            'brand'=>'required_if:vehicle_type_id,2',
            'model'=>'required_if:vehicle_type_id,2',
            'region'=>'required_if:vehicle_type_id,2',
            'category'=>'required_if:vehicle_type_id,2',
            'plat_number'=>'required_if:vehicle_type_id,2',
            'token_number'=>'required_if:vehicle_type_id,2',
            'rc_photo'=>'mimes:jpeg,jpg,bmp,png|max:5242880',
            'father_mobile'=> 'required',
        ],[
            'hub_id.required'=>'The hub is required.',
            'vehicle_type_id.required'=>'The vehicle type field is required.',
            'brand.required_if'=>'The brand field is required when vehicle type is motorcycle.',
            'model.required_if'=>'The model field is required when vehicle type is motorcycle.',
            'region.required_if'=>'The region field is required when vehicle type is motorcycle.',
            'category.required_if'=>'The category field is required when vehicle type is motorcycle.',
            'plat_number.required_if'=>'The plat number field is required when vehicle type is motorcycle.',
            'token_number.required_if'=>'The token number field is required when vehicle type is motorcycle.'
        ]);

        try{
            $rider=DeliveryRiders::findOrFail($id);
            $rider->name=$request->name;
            $rider->hub_id=$request->hub_id;
            $rider->address=$request->address;
            $rider->gender=$request->gender;
            $rider->email=$request->email;
            $rider->mobile=$request->mobile;
            $rider->nid_number=$request->nid_number;
            $rider->father_nid=$request->father_nid;
            $rider->thana=$request->thana;
            $rider->district=$request->district;
            $rider->division=$request->division;
            $rider->status=$request->status;
            $rider->latitude=$request->latitude;
            $rider->longitude=$request->longitude;
            $rider->vehicle_type_id=$request->vehicle_type_id;
            $rider->father_mobile=$request->father_mobile;
            if($request->hasFile('picture')) {
                Storage::delete($rider->picture);
                $rider->picture = $request->picture->store('delivery-riders');
            }
            if($request->hasFile('nid_picture')) {
                Storage::delete($rider->nid_picture);
                $rider->nid_picture = $request->nid_picture->store('delivery-riders/nidpic');
            }if($request->hasFile('father_nid_pic')) {
                Storage::delete($rider->father_nid_pic);
                $rider->father_nid_pic = $request->father_nid_pic->store('delivery-riders/nidpic');
            }
            $rider->save();
            if($rider->vehicle){

            }
            if($rider->vehicle_type_id==2) {
                $rvd = $request->all(); 
                $rvd['delivery_rider_id'] = $id;
                if($request->hasFile('dl_photo')) {
                    $rvd['dl_photo'] = $request->dl_photo->store('delivery-riders/dlpic');
                    if($rider->vehicle){
                        Storage::delete($rider->vehicle->dl_photo);
                    }
                }
                if($request->hasFile('rc_photo')) {
                    $rvd['rc_photo'] = $request->rc_photo->store('delivery-riders/rcpic');
                    if($rider->vehicle){
                        Storage::delete($rider->vehicle->rc_photo);
                    }
                }

                if($rider->vehicle){
                    $rider->vehicle->update($rvd);
                }else{
                    RiderVehicleDetails::create($rvd);
                }
            }
           
            return redirect()->route('admin.riders.index')->with('flash_success','Rider Updated Successfully');
            }
        catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage());
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
        //
         try {
            $user = DeliveryRiders::findOrFail($id);
            /*Shipments::where('merchant_id',$id)->delete();
            MDC::where('merchant_id',$id)->delete();*/
            RiderDepositAmount::where('rider_id',$id)->delete();
            /*RiderPaymentAccount::where('rider_id',$id)->delete();*/
            RiderVehicleDetails::where('delivery_rider_id',$id)->delete();
            $user->delete();
            return back()->with('flash_success', 'Rider deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Rider Not Found');
        }
    }
}
