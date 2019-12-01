<?php

namespace App\Http\Requests;

//use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiFormRequest as FormRequest;

class UserRequest extends FormRequest
{
   /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'first_name' => 'required|min:2|max:20',
             'last_name' => 'required|min:2|max:20',
                 'email' => 'required|email|unique:users,email',
              'password' => 'required|min:6',
        ];

        if($this->method() == 'PUT') {
            $rules['email'] = 'required|email|unique:users,email,' . $this->user->_id . ',_id';
        }

        return $rules;
    }
}
