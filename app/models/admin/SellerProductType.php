<?php

namespace App\models\admin;

use Illuminate\Database\Eloquent\Model;

class SellerProductType extends Model
{
    public $primary_id='seller_id';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['seller_id', 'product_type_id'];

  

    /**
     * Function for getting product type.
     *
     * @param  string  $token
     * @return void
    */
    public function product_type()
    {
        return $this->belongsToMany(SellerProductType::class,'product_types');
    }
}
