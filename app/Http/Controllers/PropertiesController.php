<?php

namespace App\Http\Controllers;

use DB;

/* Requests */
use Illuminate\Http\Request;
use App\Http\Requests\Properties\Search;
use App\Http\Requests\Properties\Store;

/* Models */
use App\Models\Properties\Utility;
use App\Models\Properties\Amenity;
use App\Models\Properties\Type;

class PropertiesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Search $request)
    {
        return view('properties.index');
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
        try {
            return DB::transaction(function () use ($request) {
                return response()->json([
                    'session' => 'Property Created.'
                ]);
            });
        } catch (Exception $e) {

        }
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
