<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\admin\Hubs;
use App\models\admin\DeliveryRiders;
use App\models\admin\RiderVehicleDetails;
use App\models\admin\VehicleTypes;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use App\Helper\ControllerHelper as Helper;

use Auth;
use Storage;

class RiderController extends Controller
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
        $riders=DeliveryRiders::where('hub_id',Auth::guard('hub')->user()->id)->latest()->get();
        return view('hub.delivery-riders.index',compact('riders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
        $vehicles=VehicleTypes::where('status','Active')->orderBy('name','asc')->get();
        return view('hub.delivery-riders.create',compact('vehicles'));
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
            'address' => 'required|max:255',            
            'email' => 'nullable|unique:delivery_riders,email|email|max:255',
            'mobile' => 'required|digits_between:8,12|unique:delivery_riders,mobile',
            'picture' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'password'    => 'required|min:8|confirmed',
            'nid_number'  => 'required',
            'nid_picture' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'father_nid_pic'  => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
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
            $user['hub_id'] = Auth::guard('hub')->user()->id;
            $user['password'] = Hash::make($request->password);
            if($request->hasFile('picture')) {
                $user['picture'] = $request->picture->store('delivery-riders');
            }
           
            if($request->hasFile('nid_picture')) {
                $user['nid_picture'] = $request->nid_picture->store('delivery-riders/nidpic');
            }
            if($request->hasFile('father_nid_pic')) {
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
           
            return redirect()->route('hub.riders.index')->with('flash_success','Rider Created Successfully');
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
            $rider=DeliveryRiders::where('hub_id',Auth::guard('hub')->user()->id)->where('id',$id)->firstOrFail();
            return view('hub.delivery-riders.details',compact('rider'));
        }catch(ModelNotFoundException $e){
            return back()->with('flash_error',$e->getMessage());
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
            $rider=DeliveryRiders::where('hub_id',Auth::guard('hub')->user()->id)->where('id',$id)->firstOrFail();
           
            $vehicles=VehicleTypes::where('status','Active')->orderBy('name','asc')->get();
            return view('hub.delivery-riders.edit',compact('rider','vehicles'));
        }catch(ModelNotFoundException $e){
            return back()->with('flash_error',$e->getMessage());
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
            'address' => 'required|max:255',            
            'email' => 'nullable|email|max:255|unique:delivery_riders,email,'.$id.',id',
            'mobile' => 'required|digits_between:8,12|unique:delivery_riders,mobile,'.$id.',id',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'nid_number'  => 'required',
            'nid_picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'father_nid_pic'  => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'father_nid'  => 'required',
            'thana'       => 'required',
            'district'    => 'required',
            'division' => 'required',
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
            'vehicle_type_id.required'=>'The vehicle type field is required.',
            'brand.required_if'=>'The brand field is required when vehicle type is motorcycle.',
            'model.required_if'=>'The model field is required when vehicle type is motorcycle.',
            'region.required_if'=>'The region field is required when vehicle type is motorcycle.',
            'category.required_if'=>'The category field is required when vehicle type is motorcycle.',
            'plat_number.required_if'=>'The plat number field is required when vehicle type is motorcycle.',
            'token_number.required_if'=>'The token number field is required when vehicle type is motorcycle.'
        ]);

        try{
            $rider=DeliveryRiders::where('hub_id',Auth::guard('hub')->user()->id)->where('id',$id)->firstOrFail();
            $rider->hub_id=Auth::guard('hub')->user()->id;
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
            $rider->vehicle_type_id=$request->vehicle_type_id;
            $rider->latitude = $request->latitude;            
            $rider->longitude = $request->longitude;
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
            
           if($rider->vehicle_type_id==2){
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
           
            return redirect()->route('hub.riders.index')->with('flash_success','Rider Updated Successfully');
            }
        catch(ModelNotFoundException $e){
            return back()->with('flash_error',$e->getMessage());
        }catch(Exception $e){
            return back()->with('flash_error',$e->getMessage());
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
    }
}
