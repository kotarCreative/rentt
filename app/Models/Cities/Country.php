<?php

namespace App\Models\Cities;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * One to many relationship on the subdivisions table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subdivisions()
    {
        return $this->hasMany('App\Models\Cities\Subdivision');
    }
}
