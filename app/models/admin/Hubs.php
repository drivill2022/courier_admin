<?php

namespace App\models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
 use App\Notifications\HubResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hubs extends Authenticatable
{
    protected $guard = 'merchant';
    use Notifiable, SoftDeletes;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'phone', 'address', 'hbsid', 'thana', 'district', 'division', 'supervisor_name', 'sup_phone', 'sup_picture', 'sup_tin_no', 'sup_nid_no', 'sup_nid_pic', 'sup_tin_pic','tl_picture', 'status','picture','latitude','longitude','home_address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];


     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new HubResetPassword($token));
    }

}
