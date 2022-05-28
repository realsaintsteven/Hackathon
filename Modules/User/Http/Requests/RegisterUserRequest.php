<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'firstname' => 'required|string',
          'lastname' => 'required|string',
          // 'phone' => 'required|unique:users,phone|phone:auto,mobile',
          'phone' => 'required||unique:users,phone|regex:/^(?:[+0])?[0-9]{10,13}$/',
          'email' => 'required|email|unique:users,email',
          'password' => 'required|string|min:8|confirmed',
          'accept' => 'required|boolean',
          'referrer_no' => 'sometimes|nullable|exists:users,uid',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'phone.phone' => 'Invalid phone number, please try again',
            'accept.required' => 'Accept terms and condition to continue'
        ];
    }
}
