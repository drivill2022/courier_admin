<?php
namespace App\Helper;
use File;
use Illuminate\Support\Facades\Mail;
class ControllerHelper
{

    public static function upload_picture($picture,$path='')
    {
        $file_name = time();
        $file_name .= rand();
        $file_name = sha1($file_name);
        if ($picture && empty($path)) {
            $ext = $picture->getClientOriginalExtension();
            $picture->move(public_path() . "/uploads", $file_name . "." . $ext);
            $local_url = $file_name . "." . $ext;
            $s3_url = url('/').'/uploads/'.$local_url;            
            return $s3_url;
        }else{
            $ext = $picture->getClientOriginalExtension();
            $picture->move(public_path() . $path, $file_name . "." . $ext);
            $local_url = $file_name . "." . $ext;
            $s3_url = url('/').$path.'/'.$local_url;            
            return $s3_url;
        }
        return "";
    }


    public static function delete_picture($picture,$path='') {
        $path=$path?:"/uploads/";
        File::delete( public_path() . $path . basename($picture));
        return true;
    }

    public static function generate_booking_id() {
        return Setting::get('booking_prefix').mt_rand(100000, 999999);
    }

    public static function referral_code_generate($user) {
        return strtoupper(substr($user->name,0,1).substr($user->name,-3).sprintf('%03d', $user->id));
    }


    public static function sentOtp($mobile,$message)
    {
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($from),
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authorization: Basic QmlrZW1hbkdvOkVtYWlsMjAxOA==",
            "content-type: application/json"
        ),
    ));
      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
      if ($err) {
          return "cURL Error #:" . $err;
      } else {
          return $response;
      }
  }


  /**
     * Handles Generate OTP
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */ 

    public static function gererate_otp($digits='6')
    {
       //return '4343';
       return $num = rand(pow(10, $digits - 1) , pow(10, $digits) - 1);
    }


}
