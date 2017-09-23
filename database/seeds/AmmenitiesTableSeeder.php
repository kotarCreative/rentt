<?php

use Illuminate\Database\Seeder;

/* Models */
use App\Models\Properties\Ammenity;

class AmmenitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ammenity::create([
            'name' => 'Pool',
            'slug' => 'pool',
            'icon' => 'icon-pool'
        ]);

        Ammenity::create([
            'name' => 'Garage',
            'slug' => 'garage',
            'icon' => 'icon-garage'
        ]);

        Ammenity::create([
            'name' => 'Exercise Area',
            'slug' => 'exercise',
            'icon' => 'icon-exercise'
        ]);

        Ammenity::create([
            'name' => 'Onsite Parking',
            'slug' => 'parking',
            'icon' => 'icon-parking-included'
        ]);

        Ammenity::create([
            'name' => 'Dishwasher',
            'slug' => 'dishwasher',
            'icon' => 'icon-dishwasher'
        ]);

        Ammenity::create([
            'name' => 'Furnished',
            'slug' => 'furnished',
            'icon' => 'icon-furnished'
        ]);

        Ammenity::create([
            'name' => 'Pets Okay',
            'slug' => 'pets',
            'icon' => 'icon-pets'
        ]);

        Ammenity::create([
            'name' => 'Kid Friendly',
            'slug' => 'kids',
            'icon' => 'icon-kids'
        ]);

        Ammenity::create([
            'name' => 'Smoking Okay',
            'slug' => 'smoking',
            'icon' => 'icon-smoking'
        ]);

        Ammenity::create([
            'name' => 'Internet Included',
            'slug' => 'internet',
            'icon' => 'icon-internet'
        ]);

        Ammenity::create([
            'name' => 'In-Suite Laundry',
            'slug' => 'laundry',
            'icon' => 'icon-laundry'
        ]);

        Ammenity::create([
            'name' => 'Accessible',
            'slug' => 'accessible',
            'icon' => 'icon-accessible'
        ]);
    }
}
