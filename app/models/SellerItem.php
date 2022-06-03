<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\admin\ProductType;
use App\models\admin\Seller;

class SellerItem extends Model
{
     
     protected $fillable = ['name', 'price', 'picture', 'size', 'color', 'weight', 'length', 'product_type', 'category_id', 'sub_category_id', 'seller_id', 'status'];

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
     * A product belongs to a category.
     *
     * @return mixed
     */
    public function category()
    {
        return $this->belongsTo(SellerItemCategories::class,'category_id','id');
    }
    /**
     * A product belongs to a sub category.
     *
     * @return mixed
     */
    public function subcategory()
    {
        return $this->belongsTo(SellerItemCategories::class,'sub_category_id','id');
    }
    /**
     * A product belongs to a product type.
     *
     * @return mixed
     */
    public function producttype()
    {
        return $this->belongsTo(ProductType::class,'product_type','id');
    }
    /**
     * A product belongs to a product type.
     *
     * @return mixed
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class,'seller_id','id');
    }
}
