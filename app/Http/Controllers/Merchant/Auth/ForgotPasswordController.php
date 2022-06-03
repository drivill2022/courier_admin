<?php

namespace App\Http\Controllers\Merchant\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

use App\models\admin\Merchants;
use Illuminate\Http\Request;
use App\Helper\ControllerHelper as Helper;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('merchant.guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('merchant.auth.passwords.mobile');
    }


    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request){
        return view('merchant.auth.passwords.mobile-reset');
    }
    public function forgot_otp(Request $request)
    {
        $this->validate($request, [
            'mobile'   => 'required|exists:merchants,mobile',
        ]);
        try{
            $merchant=Merchants::where('mobile',$request->mobile)->firstOrFail();
            $otp= Helper::gererate_otp(4);
            $merchant->update(['otp' => $otp]); 
             $message="Your DRiVill verification code is ".$otp.". Please do not share this code with anyone.";
            $res = sendSms($request->mobile,$message);
            return redirect()->route('merchant.showReset')->withInput($request->only('mobile'))->with('status','OTP sent successfully!');
        }catch(ModelNotFoundException $m){
            return redirect()->back()->withInput($request->only('mobile'))->with('flash_error','Mobile number not registered with us!');
        }catch(Exception $e){
           return redirect()->back()->withInput($request->only('mobile'))->with('flash_error','Something Went Wrong. Please try later.');
       }


   }

 public function reset_password(Request $request)
 {
    $this->validate($request, [
        'mobile'   => 'required|exists:merchants,mobile',
        'password'   => 'required|min:8|confirmed',
        'otp'   => 'required|exists:merchants,otp',
    ],['otp.exists'=>'Invalid otp!']);
    try{
        $merchant=Merchants::where('mobile',$request->mobile)->where('otp',$request->otp)->firstOrFail();
        $otp= Helper::gererate_otp(6);
        $merchant->update(['otp' => 0,'password'=>Hash::make($request->password)]); 
        return redirect()->route('merchant.login')->withInput($request->only('mobile'))->with('status','Password reset successfully!');
    }catch(ModelNotFoundException $m){
        return back()->withInput($request->only('mobile'))->with('flash_error','Mobile number not registered with us!');
    }catch(Exception $e){
     return back()->withInput($request->only('mobile'))->with('flash_error','Something Went Wrong. Please try later.');
 }


}

  

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('merchants');
    }
    
}
