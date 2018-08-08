<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    /**
     * The attributes that should be handled as dates.
     *
     * @var array
     */
    protected $dates = [
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
