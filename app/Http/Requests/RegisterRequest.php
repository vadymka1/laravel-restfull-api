<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string|min:3',
             'last_name' => 'required|string|min:3',
                 'email' => 'required|email|unique:users,email',
              'password' => 'required|min:6',
//                 'avatar'=> ['sometimes', 'image', 'mimes:png,jpeg,jpg,bmp', 'max:5000']
        ];
    }
}