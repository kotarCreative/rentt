<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;
use Mail;

/* Requests */
use Illuminate\Http\Request;
use App\Http\Requests\Properties\Search;
use App\Http\Requests\Properties\Store;
use App\Http\Requests\Properties\ContactOwner;
use App\Http\Requests\Properties\Review as ReviewRequest;

/* Models */
use App\Models\Properties\Property;
use App\Models\Properties\Utility;
use App\Models\Properties\Amenity;
use App\Models\Properties\Type;
use App\Models\Properties\Image;
use App\Models\Review;

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
     * Search database for matching properties.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = Property::select('properties.*')
            ->withType()
            ->withCity()
            ->where('is_active', true)
            ->where('is_occupied', false);

        if ($request->has('where')) {
            $query->whereRaw('cities.name LIKE "%' . $request->where . '%"');
        }

        if ($request->has('bedrooms')) {
            if ($request->bedrooms == 4) {
                $query->where('bedrooms', '>=', 4);
            } else {
                $query->where('bedrooms', (int) $request->bedrooms);
            }
        }

        if ($request->has('home-types')) {
            $query->whereIn('type_id', $request->{'home-types'});
        }

        $properties = $query->get();

        foreach ($properties as $property) {
            $images = [];
            foreach ($property->images as $image) {
                $images[] = env('IMAGE_ROOT') . $image->filepath;
            }
            $property->coordinates;
            $property->image_routes = $images;
        }

        return response()->json([
            'properties' => $properties
        ]);
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
            if ($request->available_at) {
                $property->available_at = Carbon::parse(trim('"', $request->available_at));
            }
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
     * @param  App\Models\Properties\Property $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        $property->location();
        $property->type;
        $property->amenityIds();
        $property->utilityIds();
        $property->reviewCount();
        $property->reviews = $property->reviews()->select('reviews.*')->withReviewer()->get();

        $images = [];
        foreach ($property->images as $image) {
            $images[] = env('IMAGE_ROOT') . $image->filepath;
        }
        $property->coordinates;
        $property->image_routes = $images;
        return view('properties.show')->with('property', $property);
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

    /**
     * Sends a contact email to the owner of the property.
     *
     * @param  App\Models\Properties\Property $property
     * @param App\Http\Requests\Properties\ContactOwner $request
     * @return \Illuminate\Http\Response
     */
    public function contactOwner(Property $property, ContactOwner $request)
    {
        $user = Auth::user();
        $owner = $property->user;

        $mail_data = [
            'user'      => $user,
            'property'  => $property,
            'message' => $request->message,
            'contact_form' => $request->contact_form
        ];

        if ($request->has('phone_num')) {
            $mail_data['phone_num'] = $request->phone_num;
        }

        Mail::send('emails.contact-owner', $mail_data, function($message) use ($owner) {
            $message->to($owner->email, $owner->first_name)->subject('Someone would like to view your property!');
        });

        return response()->json([
            'session' => 'Email Sent.'
        ]);
    }

    /**
     * Store a review about the property.
     *
     * @param App\Models\Properties\Property $property
     * @param App\Http\Requests\Properties\Review $request
     * @return \Illuminate\Http\Response
     */
    public function storeReview(Property $property, ReviewRequest $request)
    {
        $reviewer = Auth::user();

        $review = Review::make($request->all());
        $review->reviewer_id = $reviewer->id;
        $review->property_id = $property->id;
        $review->save();

        return response()->json([
            'session' => 'Review posted.'
        ]);
    }
}
