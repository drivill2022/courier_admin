<?php

namespace App\models\admin;

use Illuminate\Database\Eloquent\Model;

class RiderPaymentAccount extends Model
{
    //
     protected $fillable=['rider_id','txn_id','payment_mode','pay_amount','status','paid_by'];
}
