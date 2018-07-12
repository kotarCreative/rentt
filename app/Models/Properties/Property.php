<?php

namespace App\Models\Properties;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasSlug, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city_id',
        'type_id',
        'title',
        'description',
        'address_line_1',
        'address_line_2',
        'postal',
        'coordinates',
        'price',
        'damage_deposit',
        'bedrooms',
        'bathrooms',
        'size'
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'user_id',
        'is_occupied',
        'is_active'
    ];

    /**
     * The attributes that should be handled as dates.
     *
     * @var array
     */
    protected $dates = [
        'available_at',
        'created_at',
        'updated_at'
    ];

    /**
     * The type cast of attributes in the model.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_occupied' => 'boolean'
    ];

    /**
     * Amenities that belong to the property.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function amenities()
    {
        return $this->belongsToMany('App\Models\Properties\Amenity');
    }

    /**
     * Utilities that belong to the property.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function utilities()
    {
        return $this->belongsToMany('App\Models\Properties\Utility');
    }

    /**
     * The type of property assigned.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\Models\Properties\Type');
    }

    /**
     * Images that belong to the property.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->HasMany('App\Models\Properties\Image');
    }

    /**
     * Always unserialize coordinates attribute on retrieval.
     *
     * @param string $coordinates
     *
     * @return array
     */
    public function getCoordinatesAttribute($coordinates)
    {
        return $coordinates != null ? unserialize($coordinates) : null;
    }

    /**
     * Always serialize coordinates attribute on storage.
     *
     * @param array $coordinates
     *
     * @return string
     */
    public function setCoordinatesAttribute($coordinates)
    {
        $this->attributes['coordinates'] = serialize($coordinates);
    }

    /**
     * Add property type value to query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithType($query)
    {
        return $query->join('types', 'types.id', '=', 'properties.type_id')
            ->addSelect('types.name as type')
            ->addSelect('types.icon as type_icon');
    }

    /**
     * Add city values to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithCity($query)
    {
        return $query->join('cities', 'cities.id', '=', 'properties.city_id')
            ->addSelect('cities.name as city');
    }

    /**
     * One to many relationship on the cities table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function city()
    {
        return $this->belongsTo('App\Models\Cities\City');
    }

    /**
     * Attach full city name to property.
     *
     * @return void
     */
    public function location()
    {
        $city = $this->city;
        if ($city) {
            $subdivision = $city->subdivision;
            $country = $subdivision->country;

            $this->attributes['location'] = $city->name . ' ' . $subdivision->abbreviation . ', ' . $country->name;
        } else {
            $this->attributes['location'] = null;
        }
    }

    /**
     * Attach ids of amenities that belong to the property.
     *
     * @return void
     */
    public function amenityIds()
    {
        $this->attributes['amenityIds'] = $this->amenities->pluck('id');
    }

    /**
     * Attach ids of utilities that belong to the property.
     *
     * @return void
     */
    public function utilityIds()
    {
        $this->attributes['utilityIds'] = $this->utilities->pluck('id');
    }

    /**
     * One to many relationship on the users table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }

    /**
     * Reviews that belong to the property.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Has Many
     */
    public function reviews()
    {
        return $this->HasMany('App\Models\Review');
    }

    /**
     * Attach a total count of reviews that belong to the property.
     *
     * @return void
     */
    public function reviewCount()
    {
        $this->attributes['review_count'] = $this->reviews()->selectRaw('count(*) as count')->pluck('count')[0];
    }

    /**
     * Attach image routes to property.
     *
     * @return void
     */
    public function ImageRoutes()
    {
        $routes = [];
        foreach ($this->images as $image) {
            $routes[] = '/' . env('PROPERTY_IMAGE_DISK') . '/' . $image->filepath;
        }

        if (count($routes) == 0) {
            $routes[] = '/imgs/default_image.png';
        }
        $this->image_routes = $routes;
    }

    /**
     * Attach all necessary data to show property.
     *
     * @return void
     */
    public function prepareShow()
    {
        $this->location();
        $this->type;
        $this->amenityIds();
        $this->utilityIds();
        $this->reviewCount();
        $this->user->location();
        $this->user->profilePicture();
        $this->user->reviewCount();
        $this->reviews = $this->reviews()->select('reviews.*')->withReviewer()->get();
        $this->coordinates;
        $this->imageRoutes();
    }

    /**
     * Get the options for generating the slug.
     *
     * @return array
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Get the subdivision that belongs to the city of the property.
     *
     * @return void
     */
    public function subdivision()
    {
        $city = $this->city;

        $this->subdivision = $city ? $city->subdivision : null;
    }
}
