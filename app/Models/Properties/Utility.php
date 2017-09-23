<?php

namespace App\Models\Properties;

use Illuminate\Database\Eloquent\Model;

class Utility extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
