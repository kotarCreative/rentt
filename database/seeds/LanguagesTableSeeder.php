<?php

use Illuminate\Database\Seeder;

use App\Models\Users\Language;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::create([
            'name'          => 'English',
            'slug'          => 'english',
            'abbreviation'  => 'En'
        ]);

        Language::create([
            'name'          => 'French',
            'slug'          => 'french',
            'abbreviation'  => 'Fr'
        ]);

        Language::create([
            'name'          => 'Spanish',
            'slug'          => 'Spanish',
            'abbreviation'  => 'Es'
        ]);
    }
}
