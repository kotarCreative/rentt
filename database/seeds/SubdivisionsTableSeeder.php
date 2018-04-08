<?php

use Illuminate\Database\Seeder;

/* Models */
use App\Models\Cities\Subdivision;

class SubdivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subdivision::create([
            'country_id' => 1,
            'name' => 'British Columbia',
            'abbreviation' => 'BC'
        ]);

        Subdivision::create([
            'country_id' => 1,
            'name' => 'Alberta',
            'abbreviation' => 'AB'
        ]);

        Subdivision::create([
            'country_id' => 1,
            'name' => 'Saskatchewan',
            'abbreviation' => 'SK'
        ]);

        Subdivision::create([
            'country_id' => 1,
            'name' => 'Manitoba',
            'abbreviation' => 'MB'
        ]);

        Subdivision::create([
            'country_id' => 1,
            'name' => 'Ontario',
            'abbreviation' => 'ON'
        ]);

        Subdivision::create([
            'country_id' => 1,
            'name' => 'Quebec',
            'abbreviation' => 'QC'
        ]);

        Subdivision::create([
            'country_id' => 1,
            'name' => 'Newfoundland and Labrador',
            'abbreviation' => 'NL'
        ]);

        Subdivision::create([
            'country_id' => 1,
            'name' => 'New Brunswick',
            'abbreviation' => 'NB'
        ]);

        Subdivision::create([
            'country_id' => 1,
            'name' => 'Nova Scotia',
            'abbreviation' => 'NS'
        ]);

        Subdivision::create([
            'country_id' => 1,
            'name' => 'Prince Edward Island',
            'abbreviation' => 'PE'
        ]);

        Subdivision::create([
            'country_id' => 1,
            'name' => 'Yukon',
            'abbreviation' => 'YT'
        ]);

        Subdivision::create([
            'country_id' => 1,
            'name' => 'Northwest Territories',
            'abbreviation' => 'NT'
        ]);

        Subdivision::create([
            'country_id' => 1,
            'name' => 'Nunavut',
            'abbreviation' => 'NU'
        ]);
    }
}
