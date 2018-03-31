<?php

namespace App\Models\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'email', 'password', 'email_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

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
     * Attach full city name to user.
     *
     * @return void
     */
    public function location()
    {
        $city = $this->city;
        if ($city) {
            $subdivision = $city->subdivision;
            $country = $subdivision->country;
            $this->attributes['location'] = $city->name . ' ' . $subdivision->abbreviation . ', ' . $country->name;
        } else {
            $this->attributes['location'] = null;
        }
    }

    /**
     * References that a user owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function references()
    {
        return $this->hasMany('App\Models\Users\Reference');
    }

    /**
     * Rental histories that a user owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rentalHistory()
    {
        return $this->hasMany('App\Models\Users\RentalHistory');
    }

    /**
     * Languages that a user speaks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function languages()
    {
        return $this->BelongsToMany('App\Models\Users\Language');
    }
}
