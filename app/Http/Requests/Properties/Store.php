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
            'is_active'         => 'required',
            'title'             => 'required_if:is_active,true',
            'type_id'           => 'required_if:is_active,true',
            'city_id'           => 'required_if:is_active,true',
            'address_line_1'    => 'required_if:is_active,true',
            'coordinates'       => 'required_if:is_active,true',
            'postal'            => 'required_if:is_active,true',
            'bedrooms'          => 'required_if:is_active,true',
            'bathrooms'         => 'required_if:is_active,true',
            'size'              => 'required_if:is_active,true|max:999999.99',
            'price'             => 'required_if:is_active,true|max:99999999.99',
            'damage_deposit'    => 'required_if:is_active,true|max:99999999.99',
            'available_at'      => 'required_if:is_active,true',
            'images'            => 'required',
            'images.*'          => 'image|mimes:jpeg,png'
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
            'type_id.required'             => 'Let us know what type of property you own.',
            'city_id.required'          => 'What city is your property in?',
            'address_line_1.required'   => 'What is the address of your property?',
            'coordinates.required'      => '',
            'postal.required'           => 'Let us know what your properties postal code is.',
            'bedrooms.required'         => 'How many bedrooms does your property have?',
            'bathrooms.required'        => 'How many bathrooms does your property have?',
            'size.required'             => 'How big is your property?',
            'price.required'            => 'How much do you expect to make each month?',
            'damage_deposit.required'   => 'How much of a damage deposit is required?',
            'images.required'           => 'Let people know what your property looks like.',
            'available_at.required'     => 'When can the tenant move in?'
        ];
    }
}
