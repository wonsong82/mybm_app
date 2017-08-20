<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SoonApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'need_ride' => 'required|boolean',
            'can_provide_ride' => 'required|boolean',
            'can_provide_place' => 'required|boolean',
            'age_preference' => 'required'
        ];
    }
}
