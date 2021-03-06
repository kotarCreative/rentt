<?php

namespace App\Models\Cities;

use Illuminate\Database\Eloquent\Model;

class Subdivision extends Model
{
    /**
     * One to many relationship on the cities table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany('App\Models\Cities\City');
    }

    /**
     * One to many relationship on the countries table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Cities\Country');
    }
}
