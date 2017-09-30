<?php

use Illuminate\Database\Seeder;

/* Models */
use App\Models\Properties\Amenity;

class AmenitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Amenity::create([
            'name' => 'Pool',
            'slug' => 'pool',
            'icon' => 'icon-pool'
        ]);

        Amenity::create([
            'name' => 'Garage',
            'slug' => 'garage',
            'icon' => 'icon-garage'
        ]);

        Amenity::create([
            'name' => 'Exercise Area',
            'slug' => 'exercise',
            'icon' => 'icon-exercise'
        ]);

        Amenity::create([
            'name' => 'Onsite Parking',
            'slug' => 'parking',
            'icon' => 'icon-parking-included'
        ]);

        Amenity::create([
            'name' => 'Dishwasher',
            'slug' => 'dishwasher',
            'icon' => 'icon-dishwasher'
        ]);

        Amenity::create([
            'name' => 'Furnished',
            'slug' => 'furnished',
            'icon' => 'icon-furnished'
        ]);

        Amenity::create([
            'name' => 'Pets Okay',
            'slug' => 'pets',
            'icon' => 'icon-pets'
        ]);

        Amenity::create([
            'name' => 'Kid Friendly',
            'slug' => 'kids',
            'icon' => 'icon-kids'
        ]);

        Amenity::create([
            'name' => 'Smoking Okay',
            'slug' => 'smoking',
            'icon' => 'icon-smoking'
        ]);

        Amenity::create([
            'name' => 'Internet Included',
            'slug' => 'internet',
            'icon' => 'icon-internet'
        ]);

        Amenity::create([
            'name' => 'In-Suite Laundry',
            'slug' => 'laundry',
            'icon' => 'icon-laundry'
        ]);

        Amenity::create([
            'name' => 'Accessible',
            'slug' => 'accessible',
            'icon' => 'icon-accessible'
        ]);
    }
}
