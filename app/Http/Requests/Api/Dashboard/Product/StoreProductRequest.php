<?php

namespace App\Http\Requests\Api\Dashboard\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name'=>'required|string|max:255|unique:products,name',
            'description'=>'nullable',
            'slug'=>'required|unique:products,slug',
            'is_active'=>'required|boolean',
            'image'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price'=> 'required|array',
            'price.normal'=> [
                'required',
                'numeric',
                'gt:0'
            ],
            'price.silver'=> [
                'required',
                'numeric',
                'lte:price.normal',
            ],
            'price.gold'=>  [
                'required',
                'numeric',
                'lte:price.silver',
            ],
        ];
    }
}
