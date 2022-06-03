<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\models\admin\Merchants;
use App\models\admin\PaymentMethod;
use App\models\admin\ProductType;
use App\models\admin\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helper\ControllerHelper as Helper;
use App\Notifications\ResetPasswordOTP;
use App\models\admin\MerchantPaymentAccount;
use Notification;
use Auth;
use Storage;
use Validator;
use App\models\Shipments;
use App\models\MerchantBanner;

class MerchantApiController extends Controller
{

    public function profile()
    {
        $rider = Merchants::find(Auth::user()->id);

        $rider->delivered = count(Shipments::select('shipments.*')->join('shipment_status_logs','shipments.id','=','shipment_status_logs.shipment_id')->where('shipments.merchant_id',Auth::user()->id)->groupBy('shipment_status_logs.shipment_id')->groupBy('shipment_status_logs.status')->whereIn('shipment_status_logs.status', ['6','7'])->get());

        $getAllShipment = MerchantPaymentAccount::where('merchant_id',Auth::user()->id)->pluck('shipment_id');
        $cod_amount = Shipments::whereIn('id',$getAllShipment)->sum('cod_amount');
        $shipment_cost = Shipments::whereIn('id',$getAllShipment)->sum('shipment_cost');
        $amount = $cod_amount - $shipment_cost;

        //$rider->earned = MerchantPaymentAccount::where('merchant_id', Auth::user()->id)->sum('pay_amount');
        $rider->earned = $amount;

         /*$rider->years = \Carbon\Carbon::parse($rider->created_at)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days');*/

         if($rider->status == "Blocked")
         {
            $rider->status = "Your account is Blocked. Please contact with DRiViLL Administrator";
         }
         if($rider->status == "Onboarding")
         {
            $rider->status = "Your account is not Active. Please contact with DRiViLL Administrator";
         }

        $rider->awards = 0;

        return response()->json($rider, 200);
    }

    public function signup_data()
    {
        $data['product_type']=ProductType::select('id','name')->where('status','Active')->orderBy('id','asc')->get();
        $data['payment_method']=PaymentMethod::select('id','name')->where('status','Active')->orderBy('id','asc')->get();
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
            'mobile' => 'required|max:255',
            'password' => 'required',
            'device_token' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()],400);
        }

        if(auth()->guard('merchant')->attempt(['mobile' => request('mobile'), 'password' => request('password')])){
            config(['auth.guards.api.provider' => 'merchants']);
            config(['auth.providers.users.model'=>'App\models\admin\Merchants']);
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
            $rider = Merchants::find(auth()->guard('merchant')->user()->id);
            $rider->device_token = $request->device_token;
            $rider->save();
            $success['access_token'] =  $rider->createToken('MyApp',['merchant'])->accessToken;
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
            'address' => 'required|max:255',            
            'email' => 'nullable|unique:merchants,email|email|max:255',
            'mobile' => 'digits_between:8,12|unique:merchants,mobile',
            'picture' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'password' => 'required|min:8|confirmed',
            'business_logo' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'fb_page' => 'nullable',
            'thana' => 'nullable',
            'district' => 'nullable',
            'division' => 'nullable',
            'nid_number' => 'required',
            'buss_name' => 'required|max:255',            
            'buss_phone' => 'digits_between:8,14|unique:merchants,buss_phone',
            'buss_address' => 'required|max:255',            
            'payment_method' => 'required',
            'product_type' => 'required',
            /*'latitude' => 'required',
            'longitude' => 'required',*/
            'trade_lic_no' => 'nullable|mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()],400);
        }

        try{            
            $user = $request->all();            
            $user['password'] = bcrypt($request->password);
            $user['product_type'] = trim(implode(',',$request->product_type));
            $user['status'] = "Onboarding";
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
            config(['auth.guards.api.provider' => 'merchants']);
            config(['auth.providers.users.model'=>'App\models\admin\Merchants']);
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
            $success['access_token'] =  $user->createToken('MyApp',['merchant'])->accessToken;
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
            'mobile' => 'required|max:255|unique:merchants',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()],400);
        }

        try{
            return response()->json(['message' =>'Mobile number available'],200);
        } catch (Exception $e) {
           return response()->json(['error' => 'something went wrong'], 400);
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
           $User = Merchants::where('mobile', $request->mobile)->first(); 
           if($User){
             return response()->json(['error' => '1','message'=>'Mobile Number alredy Register with us'], 401);
            }
            //$otp= Helper::gererate_otp(6); 
            $otp= Helper::gererate_otp(4);
            $message="Your DRiViLL verification code is ".$otp.". Please do not share this code with anyone.";
            $res = sendSms($request->mobile,$message);
            //$User->update(['otp' => $otp]);  
            return response()->json(['error' => '0','message'=>'OTP sent successfully','otp' => $otp], 200);
        }
        try{
          $User = Merchants::where('mobile', $request->mobile)
                  ->first(); 
          if(empty($User)){
           return response()->json(['error' => '1','message'=>'Mobile Number not Register with us'], 201);
         }
         //$otp= Helper::gererate_otp(6);
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
            'mobile' => 'required|exists:merchants,mobile',
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()],400);                       
        }

        try{
            $rider = Merchants::where('mobile' , $request->mobile)->first();
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
                'id' => 'required|numeric|exists:merchants,id',
                'otp' => 'required|numeric|exists:merchants,otp'
            ]);
        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()],400);                       
        }

        try{
            $rider = Merchants::findOrFail($request->id);
            $rider->password = Hash::make($request->password);
            $rider->save();
            return response()->json(['message' => 'Password Updated'],200);
        }catch (Exception $e) {
            return response()->json(['error' =>'Something went wrong'], 400); 
        }
    }

    /*public function update(Request $request)
    {
        $id=Auth::user()->id;
        $validator = Validator::make($request->all(), [                      
            'name' => 'required|max:255',            
            'address' => 'required|max:255',            
            'email' => 'nullable|unique:merchants,email,'.$id.',id|email|max:255',
            'mobile' => 'required|digits_between:8,12|unique:merchants,mobile,'.$id.',id',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'business_logo' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'fb_page' => 'nullable',
            'thana' => 'nullable',
            'district' => 'nullable',
            'division' => 'nullable',
             'nid_number' => 'required',
            'buss_name' => 'required|max:255',            
            'buss_phone' => 'digits_between:8,14|unique:merchants,buss_phone,'.$id.',id',
            'buss_address' => 'required|max:255',            
            'payment_method' => 'required',
            'product_type' => 'required',
            'trade_lic_no' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()],400); 
        }
        try{
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
            $user->save();
            return response()->json(['message' => 'Rider Updated Successfully'],200);
            }
        catch (Exception $e) {
            return response()->json(['error'=> $e->getMessage()],400);
        }
    }*/

    public function update(Request $request)
    {
        //return Auth::user();
        $id=Auth::user()->id;
        $validator = Validator::make($request->all(), [                      
            'buss_name' => 'required|max:255',            
            'name' => 'required|max:255',            
            'address' => 'required|max:255',            
            'email' => 'nullable|email|max:255|unique:merchants,email,'.$id.',id',
            'mobile' => 'required|digits_between:8,12|unique:merchants,mobile,'.$id.',id',
            //'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'payment_method' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()],400); 
        }
        try{
            $user = Merchants::findOrFail($id);
            if($request->hasFile('picture')) {
                Storage::delete($user->picture);
                $user->picture = $request->picture->store('merchant/profile');
            }
            $user->buss_name = $request->buss_name;
            $user->name = $request->name;
            $user->email = $request->email;            
            $user->mobile = $request->mobile;            
            $user->address = $request->address;            
            $user->payment_method=$request->payment_method;
            $user->emergency_no=@$request->emergency_no;
            $user->save();
            return response()->json(['message' => 'Merchant Updated Successfully'],200);
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
            config(['auth.providers.users.model'=>'App\models\admin\Merchants']);
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

    public function bannerList()
    {
        $success = MerchantBanner::latest()->get();
        if(!empty($success))
        {
            foreach ($success as $key => $value) {
                $success[$key]->image = img($value->image);
            }
        }
        return response()->json($success, 200);
    }

}
