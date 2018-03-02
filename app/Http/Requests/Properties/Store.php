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
            'postal'            => 'required',
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
            'title.required'            => 'Give your listing a title to attract new tenants.',
            'type.required'             => 'Let us know what type of property you own.',
            'city_id.required'          => 'What city is your property in?',
            'address_line_1.required'   => 'What is the address of your property?',
            'coordinates.required'      => '',
            'postal.required'           => 'Let us know what your properties postal code is.',
            'bedrooms.required'         => 'How many bedrooms does your property have?',
            'bathrooms.required'        => 'How many bathrooms does your property have?',
            'size.required'             => 'How big is your property?',
            'price.required'            => 'How much do you expect to make each month?',
            'damage_deposit.required'   => 'How much of a damage deposit is required?',
            'available_at.required'     => 'When can the tenant move in?'
        ];
    }
}
