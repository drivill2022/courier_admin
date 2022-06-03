<?php
namespace App\models;
use App\models\admin\Merchants;
use Illuminate\Database\Eloquent\Model;

class MerchantAccount extends Model
{

protected $fillable = [
       'merchant_id',
       'bank_name',
       'branch_name',
       'account_number',
       'routing_name'
    ];
   
    public function merchant()
    {
        return $this->belongsTo(Merchants::class)->select('id','name','mobile','buss_name');
    }
}
