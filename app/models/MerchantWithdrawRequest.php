<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\admin\Merchants;

class MerchantWithdrawRequest extends Model
{
    //

    function merchant()
    {
    	return $this->hasOne(Merchants::class, 'id', 'merchant_id');
    }
}
