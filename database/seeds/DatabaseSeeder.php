<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(SubdivisionsTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UtilitiesTableSeeder::class);
        $this->call(AmenitiesTableSeeder::class);
        $this->call(TypesTableSeeder::class);
    }
}
