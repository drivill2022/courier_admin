<?php

namespace App\models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class DeliveryRiders extends Authenticatable
{
    use Notifiable,HasApiTokens;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'hub_id', 'mobile', 'email', 'password', 'otp', 'picture', 'nid_number', 'nid_picture', 'father_nid_pic', 'father_nid', 'address', 'thana', 'district', 'division', 'vehicle_type_id', 'status','gender','latitude','longitude'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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
     * Function for getting vehicle type.
     *
     * @param  string  $token
     * @return void
    */
    public function vtype()
    {
        return $this->belongsTo(VehicleTypes::class,'vehicle_type_id','id');
    }
     /**
     * Function for getting hub details.
     *
     * @param  string  $token
     * @return void
    */
    public function hub()
    {
        return $this->belongsTo(Hubs::class,'hub_id','id');
    }

     /**
     * Function for getting rider vehicle details.
     *
     * @param  string  $token
     * @return void
    */
    public function vehicle()
    {
        return $this->hasOne(RiderVehicleDetails::class,'delivery_rider_id');
    }


    public function findForPassport($mobile) {
        return $this->where('mobile', $mobile)->first();
    }
}
