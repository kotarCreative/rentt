<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Models */
use App\Models\Cities\City;
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
     *
     * @return \Illuminate\Http\Response
     */
    public function countrySubdivisions(Country $country)
    {
        return response()->json([
            'subdivisions' => $country->subdivisions
        ]);
    }

    /**
     * Search for a city based on text.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if ($request->has('search')) {
            $searches = explode(',', $request->search);

            if (count($searches) == 2) {
                list($city_search, $subdivision_search) = $searches;
            } else {
                $city_search = $searches[0];
            }

            $cities_query = City::where('name', 'LIKE', $city_search . '%');

            if (isset($subdivision_search)) {
                $subdivision_ids = Subdivision::select('id')
                    ->where('abbreviation', 'LIKE', $subdivision_search . '%')
                    ->orWhere('name', 'LIKE', $subdivision_search . '%')
                    ->get()
                    ->pluck('id');

                if (count($subdivision_ids) > 0) {
                    $cities_query->whereIn('subdivision_id', $subdivision_ids);
                }
            }

            $cities = $cities_query->limit(10)->with('subdivision')->get();
        } else {
            $cities = City::all();
        }
        return response()->json([
            'cities' => $cities
        ]);
    }
}
