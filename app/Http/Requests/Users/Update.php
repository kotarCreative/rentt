<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
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
            'references.*.first_name'                 => 'required',
            'references.*.last_name'                  => 'required',
            'references.*.relationship'               => 'required',
            'references.*.email'                      => 'required',
            'rental_history.*.started_on'             => 'required',
            'rental_history.*.ended_on'               => 'required',
            'rental_history.*.landlord_first_name'    => 'required',
            'rental_history.*.landlord_last_name'     => 'required',
            'rental_history.*.landlord_email'         => 'required',
        ];
    }
}
