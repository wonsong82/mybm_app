<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        Validator::extend('valid_dob_day', function($attribute, $value, $parameters, $validator){
            $input = $validator->getData();
            $y = (int)$input['dob_y'];
            $m = (int)$input['dob_m'];
            $d = (int)$value;
            if($y && $m){
                return checkdate($m, $d, $y);
            }
            else {
                return true;
            }
        });


        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required',
            'name' => 'required|min:3',
            //'birthday' => 'required|date',
            'dob_y' => 'required|regex:#^[\d]{4}$#',
            'dob_m' => ['required', 'regex:#^([1-9]|1[0-2])$#'],
            'dob_d' => 'required|valid_dob_day',
            'phone' => 'required|regex:#^([\d][\s]?)?[\d]{3}([\s-]+)?[\d]{3}([\s-]+)?[\d]{4}$#',
            'line1' => 'required|min:5',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required|digits_between:5,10'
        ], [
            'dob_d.valid_dob_day' => 'invalid day'
        ]);
    }




    private function testPhoneValidation()
    {
        $phones = [
            '2017398833',
            '201 739 8833',
            '201-739-8833',
            '201 - - - 739 - - - 8833',
            '201 - 739 - 8833',
            '12017398833',
            '1 201 739 8833',
            '1 201-739-8833',
            '1 201 - 739 - 8833',
            '8201 739 8833'
        ];

        $regex = '#^([\d][\s]?)?[\d]{3}([\s-]+)?[\d]{3}([\s-]+)?[\d]{4}$#';

        foreach($phones as $phone){
            if(preg_match($regex, $phone)){
                echo $phone . ': PASS<br>';
            }else {
                echo $phone . ': INVALID<br>';
            }
        }

        dd("exit");
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $phone = preg_replace('#[^\d]#', '', trim($data['phone']));
        if(strlen($phone) == 11){
            $phone = substr($phone, 1);
        }

        $data['area_code'] = substr($phone, 0, 3);
        $data['exchange'] = substr($phone, 3, 3);
        $data['line_number'] = substr($phone, 6, 4);
        $data['birthday'] = date('Y-m-d', strtotime(sprintf('%s-%s-%s', $data['dob_y'], $data['dob_m'], $data['dob_d'])));

        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $profile = $user->profile()->create($data);

        $profile->phone()->create($data);
        $profile->address()->create($data);


        return $user;
    }
}
