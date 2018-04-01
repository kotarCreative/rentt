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
        'city_id',
        'first_name',
        'last_name',
        'email',
        'description',
        'linked_in_url',
        'airbnb_url',
        'password',
        'email_token'
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

    /**
     * Pictures for a users account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profilePictures()
    {
        return $this->hasMany('App\Models\Users\ProfilePicture');
    }

    /**
     * Attach route to users active profile picture.
     *
     * @return void
     */
    public function profilePicture()
    {
        $pic = $this->profilePictures()->where('is_active', true)->first();
        $this->profile_picture_route = '/profile-pictures/' . $pic->filepath;
    }

    /**
     * Attach all necessary data to show profile.
     *
     * @return void
     */
    public function prepareShow()
    {
        $this->references;
        $this->rentalHistory;
        $this->languages;
        if ($this->city) {
            $this->subdivision_id = $this->city->subdivision->id;
        }
        $this->profilePicture();
    }
}
