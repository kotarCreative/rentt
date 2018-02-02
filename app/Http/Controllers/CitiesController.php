<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Models */
use App\Models\Cities\Country;
use App\Models\Cities\Subdivision;

class CitiesController extends Controller
{
    /**
     * Get all the cities for a selected subdivision.
     *
     * @param App\Models\Cities\Subdivision $subdivision
     *
     * @return \Illuminate\Http\Response
     */
    public function subdivisionCities(Subdivision $subdivision)
    {
        return response()->json([
            'cities' => $subdivision->cities
        ]);
    }

    /**
     * Get all the subdivisions for a selected country.
     *
     * @param App\Models\Cities\Country $country
     */
    public function countrySubdivisions(Country $country)
    {
        return response()->json([
            'subdivisions' => $country->subdivisions
        ]);
    }
}
