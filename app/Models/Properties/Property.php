<?php

namespace App\Models\Properties;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
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
        return unserialize($coordinates);
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
        $subdivision = $city->subdivision;
        $country = $subdivision->country;

        $this->attributes['location'] = $city->name . ', ' . $subdivision->abbreviation . ', ' . $country->name;
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
}
