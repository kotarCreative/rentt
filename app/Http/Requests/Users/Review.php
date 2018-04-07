<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class Review extends FormRequest
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
            'message'   => 'required'
        ];
    }

    /* Get the validation messages that apply to the request.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'message.required'  => 'Share a few words about the user.'
        ];
    }
}
