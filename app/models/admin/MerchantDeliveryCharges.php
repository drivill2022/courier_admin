<?php

namespace App\models\admin;

use Illuminate\Database\Eloquent\Model;

class MerchantDeliveryCharges extends Model
{
    protected $fillable=['merchant_id','product_type','from','to','gm_500','kg_1','kg_2','kg_3','kg_4','kg_5','kg_6','kg_7','kg_upto_seven'];

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
     * Function for getting merchant.
     *
     * @param  string  $token
     * @return void
    */
    public function merchant()
    {
        return $this->belongsTo(Merchants::class)->select('id','name','mobile');
    }

    /**
    * Function for getting rider payment type.
    *
    * @param  string  $token
    * @return void
    */
    public function ptype()
    {
        return $this->belongsTo(ProductType::class,'product_type')->select('id','name');
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
}
