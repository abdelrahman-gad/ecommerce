<?php

namespace App\Http\Requests\Api\Dashboard\User;


use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'username'=>'required|unique:users,username',
            'mobile'=>'required|unique:users,mobile',
            'password'=>'required|min:6|confirmed',
            'type_id'=>[
                'required',
                'exists:user_types,id'
            ],
        ];
    }
}
