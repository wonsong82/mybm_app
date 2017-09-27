<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

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




    public function getNameAttribute()
    {
        return $this->profile? $this->profile->name : null;

    }


    public function soon_application()
    {
        return $this->hasOne(SoonApplication::class);
    }



    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }


    /**
     * Get users with birthday within week of given date
     * @param $query
     * @param null $date
     * @return mixed
     */
    public function scopeHasBirthdayInWeek($query, $date=null)
    {
        if(!$date) $date = date('Y-m-d', time()); // today if not passed in

        $week = self::getEntireWeekByDate($date); // get entire week sun-sun

        return $query
            ->with('profile')
            ->whereHas('profile', function($query) use ($week){
                for($i=0; $i<count($week); $i++){
                    $day = $week[$i];
                    if($i==0){
                        $query->where(function($query) use ($day){
                            $query
                                ->whereMonth('birthday', $day['m'])
                                ->whereDay('birthday', $day['d']);
                        });
                    }
                    else {
                        $query->orWhere(function($query) use ($day){
                            $query
                                ->whereMonth('birthday', $day['m'])
                                ->whereDay('birthday', $day['d']);
                        });
                    }
                }
            });
        
    }

    /**
     * Given Date Y-m-d, populate Sunday to next Sunday (8 days)
     * @param $date
     * @return array
     */
    public static function getEntireWeekByDate($date)
    {
        $dayOfWeek = (int)date('w', strtotime($date));
        $firstDay = strtotime($date) - $dayOfWeek * 86400; // sunday time
        $week = [];

        for($i=0; $i<=7; $i++){
            $time = $firstDay + ($i * 86400);

            $week[] = [
                'time' => $time,
                'y' => date('Y', $time),
                'm' => date('m', $time),
                'd' => date('d', $time)
            ];
        }

        return $week;

    }




}
