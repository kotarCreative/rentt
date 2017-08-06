<?php

use Illuminate\Database\Seeder;

/* Models */
use App\Models\Cities\ProvinceState;

class ProvincesStatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProvinceState::create([
            'country_id' => 1,
            'name' => 'Alberta',
            'abbreviation' => 'AB'
        ]);
    }
}
