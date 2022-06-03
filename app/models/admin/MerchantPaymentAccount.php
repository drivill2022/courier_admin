<?php

namespace App\models\admin;

use Illuminate\Database\Eloquent\Model;

class MerchantPaymentAccount extends Model
{
    //
     protected $fillable=['merchant_id','txn_id','payment_mode','pay_amount','status','paid_by'];
}
