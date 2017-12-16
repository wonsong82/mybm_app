<?php

namespace App\Http\Controllers;

use App\Http\Requests\RetreatApplicationRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RetreatApplicationController extends Controller
{
    public function create($term)
    {
        $user = auth()->user();
        $apps = $user->retreat_applications()->filterByTerm($term)->get();

        $price = $this->getPrice($term);
        $sizes = $this->getSizes($term);

        return $apps->count()?
            view('retreat-application.already-registered', ['application' => $apps[0]]) :
            view('retreat-application.register', compact('term', 'price', 'sizes'));

    }

    public function store(RetreatApplicationRequest $request)
    {
        auth()->user()->retreat_applications()->create($request->all());

        return view('retreat-application.registered', $request->all());
    }

    private function getPrice($term)
    {
        $today = Carbon::now();

        switch($term){
            case '17_W':
                $cut = Carbon::createFromFormat('Ymd H:i:s', '20180108 0:00:00');
                $msg = '1/7일까지 Early Bird($100), 그 후 Regular($120) 입니다.';
                return $today < $cut ?
                    ['msg' => $msg, 'price'=>100]:
                    ['msg' => $msg, 'price'=>120];
        }
    }

    private function getSizes($term)
    {
        switch($term){
            case '17_W':
                return ['XS','S','M','L','XL','XXL'];
        }
    }
}
