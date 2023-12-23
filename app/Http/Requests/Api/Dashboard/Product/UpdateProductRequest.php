<?php

namespace App\Http\Requests\Api\Dashboard\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id'=>'required|exists:products,id',
            'name'=>'sometimes|string|max:255|unique:products,name,'.$this->id,          
            'description'=>'sometimes',
            'slug'=>'sometimes|unique:products,slug,'.$this->id,
            'is_active'=>'sometimes|boolean',
            'image'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price'=> 'sometimes|array',
            'price.normal'=> [
                'sometimes',
                'numeric',
                'gt:0'
            ],
            'price.silver'=> [
                'sometimes',
                'numeric',
                'lte:price.normal',
            ],
            'price.gold'=>  [
                'sometimes',
                'numeric',
                'lte:price.silver',
            ],
        ];
    }
}
