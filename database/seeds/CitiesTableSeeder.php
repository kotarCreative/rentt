<?php

use Illuminate\Database\Seeder;

/* Models */
use App\Models\Cities\City;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
            'province_state_id' => 1,
            'name' => 'Edmonton'
        ]);
    }
}
