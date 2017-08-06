<?php

use Illuminate\Database\Seeder;

/* Models */
use App\Models\Cities\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create([
            'name' => 'Canada',
            'abbreviation' => 'Cnd'
        ]);

        Country::create([
            'name' => 'United States of America',
            'abbreviation' => 'USA'
        ]);
    }
}
