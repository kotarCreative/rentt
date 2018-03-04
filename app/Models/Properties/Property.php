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
        return $this->belongsToMany('App\Models\Properties\Type');
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
}
