<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;

/* Requests */
use Illuminate\Http\Request;
use App\Http\Requests\Properties\Search;
use App\Http\Requests\Properties\Store;

/* Models */
use App\Models\Properties\Property;
use App\Models\Properties\Utility;
use App\Models\Properties\Amenity;
use App\Models\Properties\Type;
use App\Models\Properties\Image;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Search $request)
    {
        $data = [
            'where' => null,
            'bedrooms' => null
        ];

        $request->has('bedrooms') ?: $data['where'] = $request->bedrooms;
        $request->has('bedrooms') ?: $data['bedrooms'] = $request->bedrooms;

        return view('properties.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('properties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Properties\Store $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        return DB::transaction(function () use ($request) {
            $property = Property::make($request->all());
            $property->user_id = Auth::user()->id;
            $property->available_at = new Carbon($request->available_at);
            $property->is_active = $request->is_active ? $request->is_active : false;
            $property->save();

            $property->utilities()->sync($request->utilities);
            $property->amenities()->sync($request->amenities);

            // Save images to property.
            if ($request->hasFile('images') && count($request->file('images')) > 0) {
                foreach ($request->file('images') as $raw_image) {
                    $image = new Image();
                    $image->property_id = $property->id;
                    $image->saveWithFile($raw_image);
                }
            }

            return response()->json([
                'session' => 'Property Created.'
            ]);
        });

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Retrieve details for property creation.
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $utilities = Utility::all();
        $amenities = Amenity::all();
        $types = Type::all();

        return response()->json([
            'utilities' => $utilities,
            'amenities' => $amenities,
            'types'     => $types
        ]);
    }
}
