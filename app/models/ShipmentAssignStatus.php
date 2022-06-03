<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\admin\Hubs;
use App\models\admin\DeliveryRiders;

class ShipmentAssignStatus extends Model
{
    protected $table="shipment_assign_status";

    protected $fillable=['shipment_id','hub_id','rider_id','status'];

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
    * Function for getting shipment.
    *
    * @param  string  $token
    * @return void
    */
    public function shipment()
    {
        return $this->belongsTo(Shipments::class,'shipment_id');
    }

    /**
    * Function for getting shipment.
    *
    * @param  string  $token
    * @return void
    */
    public function hub()
    {
        return $this->belongsTo(Hubs::class,'hub_id');
    }

     /**
    * Function for getting rider.
    *
    * @param  string  $token
    * @return void
    */
    public function rider()
    {
        return $this->belongsTo(DeliveryRiders::class,'rider_id');
    }

}
