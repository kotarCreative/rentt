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
            'name' => 'Alberta',
            'abbreviation' => 'AB'
        ]);
    }
}
