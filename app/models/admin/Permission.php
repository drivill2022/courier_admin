<?php

namespace App\models\admin;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
     protected $fillable = [
        'name',
        'slug'         
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
