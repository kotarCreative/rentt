<?php

use Illuminate\Database\Seeder;

/* Models */
use App\Models\Properties\Utility;

class UtilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Utility::create([
            'name' => 'Power',
            'slug' => 'power',
            'icon' => 'power',
            'color' => '#ffb200'
        ]);

        Utility::create([
            'name' => 'Water',
            'slug' => 'water',
            'icon' => 'water',
            'color' => '#34a0e0'
        ]);

        Utility::create([
            'name' => 'Heat',
            'slug' => 'heat',
            'icon' => 'heat',
            'color' => '#dd4545'
        ]);
    }
}
