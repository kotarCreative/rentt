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
            'icon' => 'pool'
        ]);

        Amenity::create([
            'name' => 'Garage',
            'slug' => 'garage',
            'icon' => 'garage'
        ]);

        Amenity::create([
            'name' => 'Exercise Area',
            'slug' => 'exercise',
            'icon' => 'exercise'
        ]);

        Amenity::create([
            'name' => 'Onsite Parking',
            'slug' => 'parking',
            'icon' => 'parking-included'
        ]);

        Amenity::create([
            'name' => 'Dishwasher',
            'slug' => 'dishwasher',
            'icon' => 'dishwasher'
        ]);

        Amenity::create([
            'name' => 'Furnished',
            'slug' => 'furnished',
            'icon' => 'furnished'
        ]);

        Amenity::create([
            'name' => 'Pets Okay',
            'slug' => 'pets',
            'icon' => 'pets'
        ]);

        Amenity::create([
            'name' => 'Kid Friendly',
            'slug' => 'kids',
            'icon' => 'kids'
        ]);

        Amenity::create([
            'name' => 'Smoking Okay',
            'slug' => 'smoking',
            'icon' => 'smoking'
        ]);

        Amenity::create([
            'name' => 'Internet Included',
            'slug' => 'internet',
            'icon' => 'internet'
        ]);

        Amenity::create([
            'name' => 'In-Suite Laundry',
            'slug' => 'laundry',
            'icon' => 'laundry'
        ]);

        Amenity::create([
            'name' => 'Accessible',
            'slug' => 'accessible',
            'icon' => 'accessible'
        ]);
    }
}
