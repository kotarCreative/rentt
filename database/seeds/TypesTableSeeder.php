<?php

use Illuminate\Database\Seeder;

use App\Models\Properties\Type;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'name' => 'Apartment',
            'slug' => 'apartment',
            'icon' => 'apartment'
        ]);

        Type::create([
            'name' => 'Basement Suite',
            'slug' => 'basement',
            'icon' => 'basement'
        ]);

        Type::create([
            'name' => 'Entire House',
            'slug' => 'full-house',
            'icon' => 'full-house'
        ]);

        Type::create([
            'name' => 'Main Floor',
            'slug' => 'main-floor',
            'icon' => 'main-floor'
        ]);

        Type::create([
            'name' => 'Other',
            'slug' => 'other',
            'icon' => 'other'
        ]);
    }
}
