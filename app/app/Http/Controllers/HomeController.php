<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Date;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    public function home()
    {
        //dd(Auth::user()->hasAnyRole(['순원']));


        return view('dashboard');
    }

    public function birthday()
    {
        // 지금이 포함된 한주 일요일이시작
        // 이번주, 그 다음주

        $thisWeek = User::getEntireWeekByDate(date('Y-m-d', time()));
        $nextWeek = User::getEntireWeekByDate(date('Y-m-d', time()+7*86400));

        $birthdays = [
            [
                'title' => '이번주 생일',
                'from' => $thisWeek[0]['time'],
                'to' => $thisWeek[7]['time'],
                'users' => User::hasBirthdayInWeek()->get()->sort(function($a, $b){
                    $atime = strtotime($a->profile->birthday);
                    $btime = strtotime($b->profile->birthday);
                    $antime = strtotime('2000-' . date('m', $atime) . '-' . date('d', $atime));
                    $bntime = strtotime('2000-' . date('m', $btime) . '-' . date('d', $btime));
                    return $antime > $bntime;
                })->map(function($user) use ($thisWeek){
                    $time = strtotime($user->profile->birthday);
                    $m = date('m', $time);
                    $d = date('d', $time);
                    $date = array_filter($thisWeek, function($dt) use($m, $d){
                        return $dt['m'] == $m && $dt['d'] == $d;
                    });

                    $user->birthdayThisYear = date('Y-m-d', array_values($date)[0]['time']);
                    return $user;
                }),
            ],
            [
                'title' => '다음주 생일',
                'from' => $nextWeek[0]['time'],
                'to' => $nextWeek[7]['time'],
                'users' => User::hasBirthdayInWeek(date('Y-m-d', time()+7*86400))->get()->sort(function($a, $b){
                    $atime = strtotime($a->profile->birthday);
                    $btime = strtotime($b->profile->birthday);
                    $antime = strtotime('2000-' . date('m', $atime) . '-' . date('d', $atime));
                    $bntime = strtotime('2000-' . date('m', $btime) . '-' . date('d', $btime));
                    return $antime > $bntime;
                })->map(function($user) use ($nextWeek){
                    $time = strtotime($user->profile->birthday);
                    $m = date('m', $time);
                    $d = date('d', $time);
                    $date = array_filter($nextWeek, function($dt) use($m, $d){
                        return $dt['m'] == $m && $dt['d'] == $d;
                    });

                    $user->birthdayThisYear = date('Y-m-d', array_values($date)[0]['time']);
                    return $user;
                }),
            ]
        ];


        return view('birthday', compact('birthdays'));
    }




}
