<?php

namespace App\models\admin;

use Illuminate\Database\Eloquent\Model;

class PermissionRoles extends Model
{
    public $primary_id='role_id';
    public $timestamps = false;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'permission_id',             
    ];
}
