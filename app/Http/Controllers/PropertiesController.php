<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;

/* Jobs */
use App\Jobs\SendContactOwnerEmail;

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

        if ($request->has('price-range')) {
            if ($request->{'price-range'}[0] > 0) {
                $query->where('price', '>=', intval($request->{'price-range'}[0]));
            }
            if ($request->{'price-range'}[1] > 0) {
                $query->where('price', '<=', intval($request->{'price-range'}[1]));
            }
        }

        if ($request->has('more-filters')) {
            $filters = json_decode($request->{'more-filters'});
            if ($filters->bedrooms != null) {
                $query->where('bedrooms', $filters->bedrooms);
            }

            if ($filters->bathrooms != null) {
                $query->where('bathrooms', $filters->bathrooms);
            }

            if (count($filters->utilityIds) > 0) {
                $utilities = $filters->utilityIds;
                $query->whereHas('utilities', function($innerQuery) use ($utilities) {
                        $innerQuery->select('property_utility.property_id')
                                   ->whereIn('utility_id', $utilities)
                                   ->groupBy('property_id')
                                   ->havingRaw('COUNT( DISTINCT utility_id ) = ' . count($utilities));
                      });
            }
        }
        $properties = $query->get();

        foreach ($properties as $property) {
            $images = [];
            foreach ($property->images as $image) {
                $images[] = '/property-images/' . $image->filepath;
            }
            $property->coordinates;
            $property->image_routes = $images;
            $property->utilityIds();
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
            if ($request->has('available_at')) {
                $property->available_at = Carbon::parse($request->available_at);
            }

            // Convert coordinates to numbers
            if ($request->has('coordinates')) {
                $coords = [];
                $coords['lat'] = floatval($request->coordinates['lat']);
                $coords['lng'] = floatval($request->coordinates['lng']);
                $property->coordinates = $coords;
            }

            $property->is_active = $request->is_active == 'true';
            $property->save();

            // Give generic name if title is missing
            if (!$property->title) {
                $rand = md5(microtime());
                $new_title = 'rentt-listing-' . substr($rand, 0, 5);
                while(Property::where('title', $new_title)->first()) {
                    $rand = md5(microtime());
                    $new_title = 'rentt-listing-' . substr($rand, 0, 5);
                }
                $property->title = $new_title;
                $property->save();
            }

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

            $redirect = '/profile';
            if ($property->is_active) {
                $redirect = '/properties/' . $property->id . '?success=true';
            }

            return response()->json([
                'session' => 'Property Created.',
                'redirect' => $redirect
            ]);
        });

    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $property = Property::where('slug', $slug)->firstOrFail();
        $property->prepareShow();

        if ($request->has('success') && $request->success == 'true') {
            $request->session()->flash('success', 'Nicely done! Your listing has been posted.');
            return view('properties.show')->with('property', $property);
        } else {
            return view('properties.show')->with('property', $property);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Properties\Property $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        $property->amenityIds();
        $property->utilityIds();
        $property->imageRoutes();

        $property->subdivision();

        return view('properties.create')->with('property', $property);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Properties\Store  $request
     * @param  App\Models\Properties\Property $property
     * @return \Illuminate\Http\Response
     */
    public function update(Store $request, Property $property)
    {
        return DB::transaction(function () use ($request, $property) {
            // Update slug if a title is given
            $reslug = false;
            if (preg_match('/^rentt-listing-/', $property->title)) {
                $reslug = true;
            }

            $property->fill($request->all());
            $property->user_id = Auth::user()->id;
            if ($request->has('available_at')) {
                $property->available_at = Carbon::parse($request->available_at);
            } else {
                $request->available_at = null;
            }

            // Convert coordinates to numbers
            $coords = [];
            if ($request->has('coordinates')) {
                $coords['lat'] = floatval($request->coordinates['lat']);
                $coords['lng'] = floatval($request->coordinates['lng']);
                $property->coordinates = $coords;
            }
            $property->coordinates = $coords;

            $property->is_active = $request->is_active == 'true';
            $property->is_occupied = $request->is_occupied == 'true';
            $property->save();

            // Reslug if required
            if ($reslug) {
                $property->generateSlug();
                $property->save();
            }

            $property->utilities()->sync($request->utilities);
            $property->amenities()->sync($request->amenities);

            // Save images to property.
            if ($request->hasFile('images') &&
                count($request->file('images')) > 0 &&
               $request->is_occupied != 'true') {
                foreach ($request->file('images') as $raw_image) {
                    $image = new Image();
                    $image->property_id = $property->id;
                    $image->saveWithFile($raw_image);
                }
            }

            $redirect = '/profile';
            if ($property->is_active) {
                $redirect = '/properties/' . $property->id . '?success=true';
            }
            return response()->json([
                'session' => 'Property Updated.',
                'redirect' => $redirect
            ]);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Properties\Property $property
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property, Request $request)
    {
        $property->delete();

        $request->session()->flash('success', 'Sorry the property didn\'t work out! Your listing has been deleted.');
        $redirect = '/profile';

        return response()->json([
            'session' => 'Property Deleted.',
            'redirect' => $redirect
        ]);
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
        $types = Type::all()->sort();

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

        $content = [
            'property'  => $property,
            'message' => $request->message,
            'contact_form' => $request->contact_form
        ];

        if ($request->has('phone_num')) {
            $content['phone_num'] = $request->phone_num;
        }

        dispatch(new SendContactOwnerEmail($user, $owner, $content));

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
        return DB::transaction(function() use ($property, $request) {
            $reviewer = Auth::user();

            $review = Review::make($request->all());
            $review->reviewer_id = $reviewer->id;
            $review->property_id = $property->id;
            $review->save();

            return response()->json([
                'session' => 'Review posted.'
            ]);
        });
    }
}
