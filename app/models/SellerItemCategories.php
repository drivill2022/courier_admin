<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class SellerItemCategories extends Model
{
    protected $fillable = ['name', 'picture', 'parent_category_id', 'status'];

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
     * A category belongs to a category.
     *
     * @return mixed
     */
    public function parent()
    {
        return $this->belongsTo('App\models\SellerItemCategories','parent_category_id','id');
    }
}
