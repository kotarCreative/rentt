<?php

namespace App\Models\Cities;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * One to many relationship on the subdivisions table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function subdivision()
    {
        return $this->belongsTo('App\Models\Cities\Subdivision');
    }
}
