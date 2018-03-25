<?php

namespace App\Http\Requests\Properties;

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
            'status'    => 'required',
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
            'status.required'   => 'Please let us know how you saw the property.',
            'message.required'  => 'Share a few words about the property.'
        ];
    }
}
