<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\models\admin\DeliveryRiders;
use App\models\admin\RiderVehicleDetails;
use App\models\admin\Hubs;
use App\models\admin\VehicleBrand;
use App\models\admin\VehicleModel;
use App\models\admin\VehicleRegion;
use App\models\admin\VehicleCategories;
use App\models\admin\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helper\ControllerHelper as Helper;
use App\Notifications\ResetPasswordOTP;
use Notification;
use Auth;
use Storage;
use Validator;
use App\models\Shipments;
use App\models\admin\RiderPaymentAccount;
use App\models\admin\Settings;
use Setting;
use App\models\ShipmentAssignStatus;

class RiderApiController extends Controller
{

    public function profile()
    {
        $rider = DeliveryRiders::with('hub','vtype','vehicle')->find(Auth::user()->id);

        /*$rider->delivered = count(Shipments::select('shipments.*')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->where('shipment_status_logs.updated_by_id',Auth::user()->id)->groupBy('shipment_status_logs.shipment_id')->groupBy('shipment_status_logs.status')->whereIn('shipment_status_logs.status', ['6','7'])->get());*/


        $max_ids = ShipmentAssignStatus::selectRaw('shipment_id,Max(id) as max_id')->groupBy('shipment_id')->pluck('max_id');

        $rider->delivered = Shipments::select('shipments.*')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids)->where('rider_id',Auth::user()->id)->whereIn('shipments.status', ['6','7'])->count('shipments.id');

        $rider->earned = Shipments::select('shipments.*')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->whereIn('shipment_assign_status.id',$max_ids)->where('rider_id',Auth::user()->id)->whereIn('shipments.status', ['6','7'])->sum('cod_amount');

        //$rider->earned = RiderPaymentAccount::where('rider_id', Auth::user()->id)->sum('pay_amount');

         /*$rider->years = \Carbon\Carbon::parse($rider->created_at)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days');*/

         if($rider->status == "Blocked")
         {
            $rider->status = "Your account is Blocked. Please contact with DRiViLL Administrator";
         }
         if($rider->status == "Onboarding")
         {
            $rider->status = "Your account is not Active. Please contact with DRiViLL Administrator";
         }

        $rider->years = \Carbon\Carbon::parse($rider->created_at)->diff(\Carbon\Carbon::now())->format('%y');

        return response()->json($rider, 200);
    }

    public function vehicle_data()
    {
        $data['brands']=VehicleBrand::where('status','Active')->orderBy('name','asc')->get();
        $data['models']=VehicleModel::where('status','Active')->orderBy('name','asc')->get();
        $data['regions']=VehicleRegion::where('status','Active')->orderBy('name','asc')->get();
        $data['categories']=VehicleCategories::where('status','Active')->orderBy('name','asc')->get();
        return response()->json($data, 200);
    }

    public function hubs()
    {
        $data['hubs']=Hubs::where('status','Active')->orderBy('name','asc')->get();
        return response()->json($data, 200);
    }
    public function get_page_content(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:pages,id'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()],400);
        }
        $data['page']=Pages::find($request->id);
        return response()->json($data, 200);
    }


    /**
     * Display a login of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|max:14',
            'password' => 'required',
            'device_token' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()],400);
        }

        if(auth()->guard('rider')->attempt(['mobile' => request('mobile'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'riders']);
            
          /*  $rider = DeliveryRiders::find(auth()->guard('rider')->user()->id);
            $success =  $rider;
            $success['token'] =  $rider->createToken('MyApp',['rider'])->accessToken;*/
            config(['auth.providers.users.model'=>'App\models\admin\DeliveryRiders']);
            $client = \DB::table('oauth_clients')->where('password_client', 1)->first();
            $request->request->add([
                'grant_type'    => 'password',
                'client_id'     => $client->id,
                'client_secret' => $client->secret,
                'username'      => request('mobile'),
                'password'      => request('password'),
                'scope'         => null,
            ]);
            $token = Request::create('oauth/token', 'POST');
            $accessToken= \Route::dispatch($token);
            $success=json_decode($accessToken->getContent(),true);
            $rider = DeliveryRiders::find(auth()->guard('rider')->user()->id);
            $rider->device_token = $request->device_token;
            $rider->save();
            $success['access_token'] =  $rider->createToken('MyApp',['rider'])->accessToken;
            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => ['Mobile or Password are Wrong.']], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
       $validator = Validator::make($request->all(), [            
            'name' => 'required|max:255',            
            'gender' => 'required|in:Male,Female,Other',            
            'hub_id' => 'required|max:255',            
            'address' => 'required|max:255',            
            'email' => 'nullable|unique:delivery_riders,email|email|max:255',
            'referral_by' => 'nullable|exists:delivery_riders,referral_code|max:255',
            'mobile' => 'required|digits_between:8,12|unique:delivery_riders,mobile',
            'picture' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'password'    => 'required|min:8|confirmed',
            'nid_number'  => 'required',
            'nid_picture' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'father_nid_pic'  => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'father_nid'  => 'required',
            'thana'       => 'nullable',
            'district'    => 'nullable',
            'division' => 'nullable',
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
            /*'latitude' => 'required',
            'longitude' => 'required',*/
        ],[
            'hub_id.required'=>'The hub is required.',
            'vehicle_type_id.required'=>'The vehicle type field is required.',
            'dl_photo.required_if'=>'The dl photo field is required when vehicle type is motorcycle.',
            'dl_number.required_if'=>'The DL Number field is required when vehicle type is motorcycle.',
            'brand.required_if'=>'The brand field is required when vehicle type is motorcycle.',
            'model.required_if'=>'The model field is required when vehicle type is motorcycle.',
            'region.required_if'=>'The region field is required when vehicle type is motorcycle.',
            'category.required_if'=>'The category field is required when vehicle type is motorcycle.',
            'plat_number.required_if'=>'The plat number field is required when vehicle type is motorcycle.',
            'token_number.required_if'=>'The token number field is required when vehicle type is motorcycle.',
            'rc_photo.required_if'=>'The rc photo field is required when vehicle type is motorcycle.'
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()],400);
        }

        try{
            $user = $request->all();            
            $user['password'] = Hash::make($request->password);
            $user['status'] = 'Onboarding';
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
           config(['auth.guards.api.provider' => 'riders']);
           //$success['token'] =  $user->createToken('MyApp',['rider'])->accessToken;
           config(['auth.providers.users.model'=>'App\models\admin\DeliveryRiders']);
            $client = \DB::table('oauth_clients')->where('password_client', 1)->first();
            $request->request->add([
                'grant_type'    => 'password',
                'client_id'     => $client->id,
                'client_secret' => $client->secret,
                'username'      => request('mobile'),
                'password'      => request('password'),
                'scope'         => null,
            ]);
            $token = Request::create('oauth/token', 'POST');
            $accessToken= \Route::dispatch($token);
            $success=json_decode($accessToken->getContent(),true);
            $success['access_token'] =  $user->createToken('MyApp',['rider'])->accessToken;
            $success['message'] =  'Registered successfully';
            return response()->json($success, 200);
        }catch (Exception $e) {
            return response()->json(['error'=>$e->getMessage()], 400);
        }
    }


    /**
     * Show the email availability.
     *
     * @return \Illuminate\Http\Response
     */

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|max:255|unique:delivery_riders',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()],400);
        }

        try{
            return response()->json(['message' =>'Mobile number available'],200);
        } catch (Exception $e) {
           return response()->json(['error' => 'something went wrong'], 500);
       }
   }

   public function send_otp(Request $request)
    {
       $validator = Validator::make($request->all(), [
         'mobile' => 'required|max:15|min:10',
         'otp_for' => 'required|in:1,2'        
        ]);
        if($validator->fails()) {
          return response()->json(['error' => $validator->errors()->all()],400);                       
        }
        $mobile=trim($request->mobile);
        if($request->otp_for=='2'){
           $User = DeliveryRiders::where('mobile', $request->mobile)->first(); 
           if($User){
             return response()->json(['error' => '1','message'=>'Mobile Number alredy Register with us'], 401);
            }
            $otp= Helper::gererate_otp(4);
            $message="Your DRiViLL verification code is ".$otp.". Please do not share this code with anyone."; 
            //$otp= Helper::gererate_otp(6);
            //$message=$otp." is the OTP for register your account.Do not disclose it to anyone.";
            $res = sendSms($request->mobile,$message);
            //$User->update(['otp' => $otp]);  
            return response()->json(['error' => '0','message'=>'OTP sent successfully','otp' => $otp], 200);
        }
        try{
          $User = DeliveryRiders::where('mobile', $request->mobile)
                  ->first(); 
          if(empty($User)){
           return response()->json(['error' => '1','message'=>'Mobile Number not Register with us'], 201);
         }
         /*$otp= Helper::gererate_otp(6);
         $message=$otp." is the OTP to login into your account.Do not disclose it to anyone.";*/
         $otp= Helper::gererate_otp(4);
         $message="Your DRiViLL verification code is ".$otp.". Please do not share this code with anyone."; 
         $res = sendSms($request->mobile,$message);
         $User->update(['otp' => $otp]);   
       
        if($User){
          return response()->json(['error' => '0','message'=>'OTP sent successfully','otp' => $otp], 200);
        }else{
          return response()->json(['error' => '1','message'=>'OTP not sent. Try again'], 201);
        }
       }catch (Exception $e) {
           return response()->json(['error' => '1','message'=>$e->message], 201);
        }
        
    }


    /**
     * Forgot Password.
     *
     * @return \Illuminate\Http\Response
     */
    public function forgot_password(Request $request){

        $validator = Validator::make($request->all(), [
            'mobile' => 'required|exists:delivery_riders,mobile',
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()],400);                       
        }

        try{
            $rider = DeliveryRiders::where('mobile' , $request->mobile)->first();
            $otp = Helper::gererate_otp(4);
            $rider->otp = $otp;
            $rider->save();
            $message="Your DRiViLL verification code is ".$otp.". Please do not share this code with anyone.";
            sendSms($request->mobile,$message);
            //Notification::send($rider, new ResetPasswordOTP($otp));
            return response()->json([
                'message' => 'OTP sent successfully',
                'id' => $rider->id,
                'otp' => $otp
            ],200);

        }catch(Exception $e){
                return response()->json(['error' =>'Something went wrong'], 400);
        }
    }


    /**
     * Reset Password.
     *
     * @return \Illuminate\Http\Response
     */

    public function reset_password(Request $request){

        $validator = Validator::make($request->all(), [
                'password' => 'required|confirmed|min:6',
                'id' => 'required|numeric|exists:delivery_riders,id',
                'otp' => 'required|numeric|exists:delivery_riders,otp'
            ]);
        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()],400);                       
        }

        try{
            $rider = DeliveryRiders::findOrFail($request->id);
            $rider->password = Hash::make($request->password);
            $rider->save();
            return response()->json(['message' => 'Password Updated'],200);
        }catch (Exception $e) {
            return response()->json(['error' =>'Something went wrong'], 400); 
        }
    }

    /*
    public function update(Request $request)
    {
        $id=Auth::user()->id;
        $validator = Validator::make($request->all(), [            
            'name' => 'required|max:255',
            // 'gender' => 'required|in:Male,Female,Other',            
            'hub_id' => 'required|max:255',            
            'address' => 'required|max:255',            
            'email' => 'nullable|email|max:255|unique:delivery_riders,email,'.$id.',id',
            'mobile' => 'required|digits_between:8,12|unique:delivery_riders,mobile,'.$id.',id',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            // 'nid_number'  => 'required',
            'nid_picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'father_nid_pic'  => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            // 'father_nid'  => 'required',
            'thana'       => 'nullable',
            'district'    => 'nullable',
            'division' => 'nullable',
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

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()],400);                       
        }

        try{
            $rider=DeliveryRiders::findOrFail($id);
            $rider->hub_id=$request->hub_id;
            // $rider->gender=$request->gender;
            $rider->address=$request->address;
            $rider->email=$request->email;
            $rider->mobile=$request->mobile;
            // $rider->nid_number=$request->nid_number;
            // $rider->father_nid=$request->father_nid;
            $rider->thana=$request->thana;
            $rider->district=$request->district;
            $rider->division=$request->division;
            $rider->vehicle_type_id=$request->vehicle_type_id;
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
            return response()->json(['message' => 'Rider Updated Successfully'],200);
            }
        catch (Exception $e) {
            return response()->json(['error'=> $e->getMessage()],400);
        }
    }*/

    public function update(Request $request)
    {
        $id=Auth::user()->id;
        $validator = Validator::make($request->all(), [            
            'name' => 'required|max:255',
            'address' => 'required|max:255',            
            'email' => 'nullable|email|max:255|unique:delivery_riders,email,'.$id.',id',
            'mobile' => 'required|digits_between:8,12|unique:delivery_riders,mobile,'.$id.',id',
            //'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()],400);                       
        }

        try{
            $rider=DeliveryRiders::findOrFail($id);
            $rider->name=$request->name;
            $rider->address=$request->address;
            $rider->email=$request->email;
            $rider->mobile=$request->mobile;
            $rider->emergency_no=@$request->emergency_no;

            if($request->hasFile('picture')) {
                Storage::delete($rider->picture);
                $rider->picture = $request->picture->store('delivery-riders');
            }
            
            $rider->save();            
            return response()->json(['message' => 'Rider Updated Successfully'],200);
            }
        catch (Exception $e) {
            return response()->json(['error'=> $e->getMessage()],400);
        }
    }


    /**
     * Update password of the rider.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function password_change(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'password' => 'required|confirmed',
                'password_old' => 'required',
            ]);
        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()],400);                       
        }
        $rider = Auth::user();
        if(password_verify($request->password_old, $rider->password))
        {
            $rider->password = Hash::make($request->password);
            $rider->save();
            return response()->json(['message' => 'Password changed successfully!']);
        } else {
            return response()->json(['error' => 'Current password not valid'], 422);
        }
    }


    public function logout(Request $request)
    {
        try {

            $rider = Auth::user()->id;
            return response()->json(['error' =>0 ,'message' => 'Logout successfully']);
        } catch (Exception $e) {
            return response()->json(['error' =>'Something went wrong'], 400);
        }
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function refresh_token(Request $request)
    {
         $validator = Validator::make($request->all(), [
                'refresh_token' => 'required'
            ]);
        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()],400);                       
        }
        try{
            config(['auth.providers.users.model'=>'App\models\admin\DeliveryRiders']);
            $client = \DB::table('oauth_clients')->where('password_client', 1)->first();
            $request->request->add([
                'grant_type' => 'refresh_token',
                'refresh_token' => $request->refresh_token,
                'client_id'     => $client->id,
                'client_secret' => $client->secret,
                'scope'         => null,
            ]);
            $token = Request::create('oauth/token', 'POST');
            $accessToken= \Route::dispatch($token);
            $success=json_decode($accessToken->getContent(),true);
            return response()->json($success, 200);
        }catch(Exception $e){
            return response()->json(['error' =>'Something went wrong'], 400);
        }
    }

    function sms_send(Request $request)
    {
         $otp= Helper::gererate_otp(4);
         $message=$otp." is the OTP to login to your account.Do not disclose it to anyone.";
         $res = sendSms($request->mobile,$message);
         print_r($res );die;
    } 
    function supports()
    {
        $success['contact_number'] = Setting::get('contact_number');
        $success['contact_number_2'] = Setting::get('contact_number_2');
        $success['contact_email'] = Setting::get('contact_email');
        $success['terms_of_use'] = Pages::find(4);
        $success['privacy_policy'] = Pages::find(5);
        return response()->json($success, 200);
    }

}
