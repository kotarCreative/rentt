<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Feedback extends FormRequest
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
            'name' => 'required',
            'issue' => 'required|in:Unsure,Bug,Improvement,Addition,Report User/Listing',
            'respond' => 'required',
            'comments' => 'required',
            'email' => 'required_if:respond,yes|email'
        ];
    }
}
