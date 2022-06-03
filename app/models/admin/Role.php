<?php

namespace App\models\admin;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description','status','permission_ids'
    ];

     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

   

    /**
     * Function for getting admin role.
     *
     * @param  string  $token
     * @return void
    */
    public function admins()
    {
        return $this->belongsTo(Admin::class,'role_id','id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'permission_roles');
    }
}
