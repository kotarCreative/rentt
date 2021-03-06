<?php

namespace App\Models\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/* Jobs */
use App\Jobs\Emails\SendPasswordResetEmail;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasSlug;
    use SoftDeletes;

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
        'gender',
        'linked_in_url',
        'airbnb_url',
        'password',
        'email_token',
        'is_a_smoker',
        'is_searching_for_roommate',
        'is_a_student'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'email_token', 'remember_token'
    ];

    /**
     * The attributes that should be handled as dates.
     *
     * @var array
     */
    protected $dates = [
        'birthday',
        'created_at',
        'updated_at'
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
        if ($pic) {
            $this->profile_picture = '/' . env('PROFILE_IMAGE_DISK') . '/' . $pic->filepath;
        }
    }

    /**
     * Attach all necessary data to show profile.
     *
     * @param Boolean $is_self
     *
     * @return void
     */
    public function prepareShow($is_self = false)
    {
        $this->languages;
        if ($is_self) {
            $this->properties;
            $this->references;
            $this->rentalHistory;
        } else {
            $this->properties = $this->properties()->where('is_active', true)->where('is_occupied', false)->get();
            $this->references = $this->references()->where('verified', true)->get();
            $this->rental_history = $this->rentalHistory()->where('verified', true)->get();;
        }
        $this->pets;
        $this->reviews = $this->reviews()->select('reviews.*')->withReviewer()->get();
        $this->reviewCount();

        if ($this->city) {
            $this->location();
            $this->subdivision_id = $this->city->subdivision->id;
        }
        $this->profilePicture();

        $this->role = $this->hasRole('landlord') ? 'landlord' : 'tenant';

        foreach ($this->properties as $property) {
            $images = [];
            $property->imageRoutes();
            $property->utilityIds();
        }
    }

    /**
     * Reviews that belong to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Has Many
     */
    public function reviews()
    {
        return $this->HasMany('App\Models\Review');
    }

    /**
     * Attach a total count of reviews that belong to the property.
     *
     * @return void
     */
    public function reviewCount()
    {
        $this->attributes['review_count'] = $this->reviews()->selectRaw('count(*) as count')->pluck('count')[0];
    }

    /**
     * Properties that belong to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties()
    {
        return $this->hasMany('App\Models\Properties\Property');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        dispatch(new SendPasswordResetEmail($this->email, $token));
    }

    /**
     * Remove protocol from airbnb url when set.
     *
     * @param string $url
     */
    public function setAirbnbUrlAttribute($url)
    {
        $url = preg_replace('/https?\:\/\//', '', $url);
        $this->attributes['airbnb_url'] = $url;
    }

    /**
     * Remove protocol from linkedin url when set.
     *
     * @param string $url
     */
    public function setLinkedInUrlAttribute($url)
    {
        $url = preg_replace('/https?\:\/\//', '', $url);
        $this->attributes['linked_in_url'] = $url;
    }

    /**
     * Get the options for generating the slug.
     *
     * @return array
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['first_name', 'last_name'])
            ->saveSlugsTo('slug');
    }

    /**
     * Pets that belong to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pets()
    {
        return $this->hasMany('App\Models\Users\Pet');
    }
}
