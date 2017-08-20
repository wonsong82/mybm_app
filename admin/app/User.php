<?php

namespace App;

use Backpack\CRUD\CrudTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Backpack\Base\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, CrudTrait, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }


    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function getNameAttribute()
    {
        return $this->profile? $this->profile->name : null;
    }


    public function profileButton()
    {
        if(!$this->profile){
            $href = url("profile/create?user_id={$this->id}");
            $text = 'Create Profile';
        }
        else {
            $href = url("profile/{$this->profile->id}/edit?user_id={$this->id}");
            $text = 'View/Edit Profile';
        }

        return '<a href="'.$href.'" class="btn btn-xs btn-default"><i class="fa fa-eye"></i> <span>'.$text.'</span></a>';
    }

}
