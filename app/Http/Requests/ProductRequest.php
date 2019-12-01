<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiFormRequest as FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
                    'name' => 'required|string|unique:products,name',
              'categories' => 'required|array',
            'categories.*' => 'required|string',
             'description' => 'sometimes|min:3|max:1000',
        ];

        if($this->method() == 'PUT') {
            $rules['name'] = 'required|string|unique:products,name,'.$this->product->_id. ',_id';
        }

        return $rules;
    }
}
