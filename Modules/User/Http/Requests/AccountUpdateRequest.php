<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // \Log::debug(auth()->id());
        return [
          'firstname' => 'required|string',
          'lastname' => 'required|string',
          'username' => 'sometimes|nullable|string|unique:users,username,' . auth()->id() . ',id',
          'email' => 'required|email|unique:users,email,' . auth()->id() . ',id',
          // 'phone' => 'required|unique:users,phone,' . auth()->id() . ',id|phone:auto,NG,mobile',
          'phone' => 'required||unique:users,phone,' . auth()->id() . ',id|regex:/^(?:[+0])?[0-9]{10,13}$/',
          'gender_id' => 'sometimes|nullable|integer',
          'birthday' => 'sometimes|nullable|date|date_format:Y-m-d|before:' . now()->format('Y-m-d'),
          'address' => 'sometimes|nullable|string',
          'city_id' => 'sometimes|nullable|integer',
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
            'phone.regex' => 'Invalid phone number, please try again',
        ];
    }
}
