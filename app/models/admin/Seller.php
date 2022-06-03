<?php

namespace App\models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\SellerResetPassword;
class Seller extends Authenticatable
{
    protected $guard = 'seller';
    use Notifiable;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slid', 'name', 'email', 'password', 'mobile', 'picture', 'nid_no', 'business_name', 'business_logo', 'fb_page', 'address', 'thana', 'district', 'division', 'status','payment_id' ,'latitude','longitude'];

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
        $this->notify(new SellerResetPassword($token));
    }


     /**
     * Function for getting pyment type.
     *
     * @param  string  $token
     * @return void
    */
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class,'payment_id','id');
    }

    /**
     * Function for getting product type.
     *
     * @param  string  $token
     * @return void
    */
    public function product_type()
    {
        return $this->belongsToMany(ProductType::class,'seller_product_types');
    }
}
