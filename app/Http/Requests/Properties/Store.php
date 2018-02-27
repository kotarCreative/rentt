<?php

namespace App\Http\Requests\Properties;

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
        return $this->user()->hasRole('landlord');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'             => 'required',
            'type'              => 'required',
            'city_id'           => 'required',
            'address_line_1'    => 'required',
            'coordinates'       => 'required',
            'bedrooms'          => 'required|integer',
            'bathrooms'         => 'required|integer',
            'size'              => 'required|numeric|max:999999.99',
            'price'             => 'required|numeric|max:99999999.99',
            'damage_deposit'    => 'required|numeric|max:99999999.99',
            'available_at'      => 'required'
        ];
    }

    /* Get the validation messages that apply to the request.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'title.required'            => '',
            'type.required'             => '',
            'city_id.required'          => '',
            'address_line_1.required'   => '',
            'coordinates.required'      => '',
            'bedrooms.required'         => '',
            'bathrooms.required'        => '',
            'size.required'             => '',
            'price.required'            => '',
            'damage_deposit.required'   => '',
            'available_at.required'     => ''
        ];
    }
}
