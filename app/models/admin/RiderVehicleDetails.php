<?php

namespace App\models\admin;

use Illuminate\Database\Eloquent\Model;

class RiderVehicleDetails extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['delivery_rider_id', 'dl_photo', 'dl_number', 'brand', 'model', 'region', 'category', 'plat_number', 'token_number', 'rc_photo'];


     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
        ];
}
