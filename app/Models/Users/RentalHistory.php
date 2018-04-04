<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class RentalHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rental_history';

    /**
     * The attributes that should be handled as dates.
     *
     * @var array
     */
    protected $dates = [
        'started_on',
        'ended_on',
        'denied_at',
        'created_at',
        'updated_at'
    ];
}
