<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reviewer_id',
        'message',
        'status'
    ];

    /**
     * Add reviewer values to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithReviewer($query)
    {
        return $query->join('users', 'users.id', '=', 'reviews.reviewer_id')
                    ->addSelect('users.first_name as reviewer_first_name');
    }
}
