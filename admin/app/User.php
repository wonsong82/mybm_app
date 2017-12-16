<?php

namespace App;

use Backpack\CRUD\CrudTrait;
use Carbon\Carbon;
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


    public function parseProfile()
    {
        $email = $this->email;
        $name = $this->profile->name;
        $birthday = $this->profile->birthday ?
            date('Y년 n월 j일', strtotime($this->profile->birthday))
            : '정보없음';
        $age = new Carbon($this->profile->birthday);
        $age = $this->profile->birthday ?
            $age->diffInYears() : '정보없음';
        $gender = $this->profile->gender == 'male' ? '남' : '여';
        $gender = $this->profile->gender ? $gender : '정보없음';
        $phone = $this->profile->phone ?
            sprintf('(%s) %s-%s',
                $this->profile->phone->area_code,
                $this->profile->phone->exchange,
                $this->profile->phone->line_number
            ) : '정보없음';
        $address = $this->profile->address ?
            sprintf('%s %s,<br>%s %s, %s',
                $this->profile->address->line1,
                $this->profile->address->line2,
                $this->profile->address->city,
                $this->profile->address->state,
                $this->profile->address->zip
            ) : '정보없음';

        return [
            'email' => $email,
            'name' => $name,
            'birthday' => $birthday,
            'age' => $age,
            'gender' => $gender,
            'phone' => $phone,
            'address' => $address
        ];        
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
