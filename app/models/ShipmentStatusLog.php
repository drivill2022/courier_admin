<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ShipmentStatusLog extends Model
{
   protected $fillable =['shipment_id','status','reason','cash_status','note','updated_by','updated_by_id', 'updated_ip'];
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
