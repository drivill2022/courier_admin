<?php

namespace App\models\admin;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shipment_id', 'merchant_id','complain','created_by','updated_by','status'
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
}
