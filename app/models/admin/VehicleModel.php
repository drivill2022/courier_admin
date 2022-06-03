<?php

namespace App\models\admin;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
       protected $fillable = ['name', 'status'];

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
