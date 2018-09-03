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
        $is_active = 'required_if:is_active,true';
        $is_occupied = 'required_if:is_occupied,true';
        $is_complete = $is_active . '|' . $is_occupied;
        return [
            'is_active'         => 'required|in:true,false',
            'title'             => $is_complete,
            'type_id'           => $is_complete,
            'city_id'           => $is_complete,
            'address_line_1'    => $is_complete,
            'coordinates'       => $is_complete,
            'postal'            => $is_complete,
            'bedrooms'          => $is_complete,
            'bathrooms'         => $is_complete,
            'size'              => 'max:999999.99',
            'price'             => $is_complete.'|max:99999999.99',
            'damage_deposit'    => $is_complete.'|max:99999999.99',
            'available_at'      => 'date',
            'image_routes'      => $is_complete,
            'image_routes.*'    => $is_complete,
            'is_occupied'       => 'in:true,false'
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
            'type_id.required'          => 'Let us know what type of property you own.',
            'city_id.required'          => 'What city is your property in?',
            'address_line_1.required'   => 'What is the address of your property?',
            'coordinates.required'      => '',
            'postal.required'           => 'Let us know what your properties postal code is.',
            'bedrooms.required'         => 'How many bedrooms does your property have?',
            'bathrooms.required'        => 'How many bathrooms does your property have?',
            'size.required'             => 'How big is your property?',
            'price.required'            => 'How much do you expect to make each month?',
            'damage_deposit.required'   => 'How much of a damage deposit is required?',
            'image_routes.required'     => 'Let people know what your property looks like.',
            'available_at.required'     => 'When can the tenant move in?'
        ];
    }
}
