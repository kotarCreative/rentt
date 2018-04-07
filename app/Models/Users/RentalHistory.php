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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'email', 'email_token', 'denied_at'
    ];

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
