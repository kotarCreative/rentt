<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
            'email'         => 'required|email|unique:users,email',
            'first_name'    => 'required',
            'password'      => 'required|confirmed',
            'user_type'     => 'required|in:tenant,landlord'
        ];
    }

    /* Get the validation messages that apply to the request.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'email.required'    => 'Let us know your email.',
            'email.email'       => 'This is not a valid email.',
            'email.unique'      => 'This email is already taken.'
        ];
    }
}
