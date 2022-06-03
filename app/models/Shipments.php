<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\admin\Merchants;
use App\models\admin\Division;
use App\models\admin\District;
use App\models\admin\Thana;
class Shipments extends Model
{
     protected $fillable = [
       'shipment_no', 'merchant_id', 'receiver_name', 'contact_no', 'product_detail', 'product_weight', 'product_type', 'note', 'd_address', 's_district', 's_thana', 's_division', 'status', 'd_district', 'd_thana', 'd_division', 's_address','s_latitude','s_longitude','d_latitude','d_longitude', 'shipment_type', 'shipment_cost','pickup_date','cod_amount'
    ];



     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];


     /**
     * Function for getting merchant.
     *
     * @param  string  $token
     * @return void
    */
    public function merchant()
    {
        return $this->belongsTo(Merchants::class)->select('id','name','mobile','buss_name');
    }
    /**
     * Function for getting division.
     *
     * @param  string  $token
     * @return void
    */
    public function sdivision()
    {
        return $this->belongsTo(Division::class,'s_division');
    }
    public function ddivision()
    {
        return $this->belongsTo(Division::class,'d_division');
    }
    /**
     * Function for getting district.
     *
     * @param  string  
     * @return void
    */
    public function sdistrict()
    {
        return $this->belongsTo(District::class,'s_district');
    }
    public function ddistrict()
    {
        return $this->belongsTo(District::class,'d_district');
    }
    /**
     * Function for getting Thana.
     *
     * @param  string  $token
     * @return void
    */
    public function sthana()
    {
        return $this->belongsTo(Thana::class,'s_thana');
    }
    public function dthana()
    {
        return $this->belongsTo(Thana::class,'d_thana');
    }

    /**
     * Function for getting rider.
     *
     * @param  string  $token
     * @return void
    */
    public function rider()
    {
        return $this->hasOne(ShipmentAssignStatus::class,'shipment_id')->latest();
    }

    public function scopeLocationData($query)
    {
        return $query->with(['sdivision','ddivision','sdistrict','ddistrict','sthana','dthana','merchant','cancelBy']);
    }



    /**
     * Function for manage status log.
     *
     * @param  string  $token
     * @return void
    */
    public function status_log()
    {
        return $this->hasMany(ShipmentStatusLog::class,'shipment_id')->latest();
    }
    public function status_database()
    {
        return $this->hasMany(ShipmentStatusLog::class,'shipment_id')->selectRaw('*,DATE(created_at) as date')->groupBy('date')->groupBy('shipment_id')->groupBy('status');
    }
    public function cancelBy()
    {
       return $this->hasMany(ShipmentStatusLog::class,'shipment_id')->where('status',8)->latest();
    }
    public function rider_status()
    {
        return $this->hasOne(ShipmentStatusLog::class,'shipment_id')->latest();
    }
}
