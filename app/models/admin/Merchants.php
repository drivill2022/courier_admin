<?php

namespace App\models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\MerchantResetPassword;
use Laravel\Passport\HasApiTokens;

class Merchants extends Authenticatable
{
    protected $guard = 'merchant';
    use Notifiable, HasApiTokens;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['mrid', 'name', 'mobile', 'email', 'password', 'picture', 'business_logo', 'nid_number', 'otp', 'buss_name', 'buss_address', 'buss_phone', 'trade_lic_no', 'payment_method', 'product_type', 'fb_page', 'address', 'thana', 'district', 'division', 'status','latitude','longitude'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];


     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MerchantResetPassword($token));
    }

    /**
    * Function for getting rider payment type.
    *
    * @param  string  $token
    * @return void
    */
    public function pmethod()
    {
        return $this->belongsTo(PaymentMethod::class,'payment_method','id');
    }

    /**
    * Function for getting rider payment type.
    *
    * @param  string  $token
    * @return void
    */
    public function getProductTypeNamesAttribute()
    {
        $product_types=[];
        $pt= ProductType::select([\DB::raw("group_concat(DISTINCT name ORDER BY name asc SEPARATOR ', ') as name")])->where(\DB::raw("FIND_IN_SET(id,'{$this->product_type}')"),"<>",\DB::raw("'0'"))->groupBy('name')->get();
        if($pt->count()>0){
            foreach($pt as $p){
                $product_types[]=$p->name;
            }
        }
        return $product_types?implode(', ', $product_types):'NA';
    }



     public function findForPassport($mobile) {
        return $this->where('mobile', $mobile)->first();
    }


}
