<?php

namespace App\Http\Requests;

//use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiFormRequest as FormRequest;

class CategoryRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        $rules =  [
            'name' => 'required|string|unique:categories,name',
            'image' => 'image|mimes:png,jpeg,bmp'
        ];

        if($this->method() == 'PUT') {
            $rules['name'] = 'required|string|unique:categories,name,'.$this->category->_id. ',_id';
        }

        return $rules;
    }
}
