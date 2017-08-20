<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Backpack\CRUD\app\Http\Requests\CrudRequest;

class PhonebookRequest extends CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'country_code' => 'required|digits_between:1,4',
            'area_code' => 'required|digits_between:1,10',
            'exchange' => 'required|digits_between:1,10',
            'line_number' => 'required|digits_between:1,10',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
