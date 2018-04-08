<?php

use Illuminate\Database\Seeder;

/* Models */
use App\Models\Cities\City;
use App\Models\Cities\Subdivision;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // British Columbia
        $bc = Subdivision::where('abbreviation', 'BC')->first()->id;

        $bc_cities = [
            '100 Mile House',
            'Quesnel',
            'Williams Lake',
            'Comox',
            'Courtenay',
            'Cumberland',
            'Campbell River',
            'Cowichan Valley',
            'Duncan',
            'Cranbrook',
            'Abbotsford',
            'Chilliwack',
            'Hope',
            'Kent',
            'Mission',
            'Burnaby',
            'New Westminster',
            'Delta',
            'Surrey',
            'Langley',
            'North Shore',
            'Richmond',
            'Tricities',
            'Pitt',
            'Maple',
            'UBC',
            'Vancouver',
            'Kamloops',
            'Kelowna',
            'Penticton',
            'Nanaimo',
            'Nelson',
            'Dawson Creek',
            'Fort St. John',
            'Parksville',
            'Qualicum Beach',
            'Port Alberni',
            'Port Hardy',
            'Port McNeill',
            'Power River District',
            'Prince George',
            'Revelstoke',
            'Burns Lake',
            'Houston',
            'Kitimat',
            'Prince Rupert',
            'Smithers',
            'Terrace',
            'Vanderhoof',
            'Sunshine Coast',
            'Vernon',
            'Victoria',
            'Whistler'
        ];

        foreach ($bc_cities as $city) {
            City::create([
                'subdivision_id' => $bc,
                'name' => $city
            ]);
        }

        // Alberta
        $ab = Subdivision::where('abbreviation', 'AB')->first()->id;

        $ab_cities = [
            'Banff',
            'Canmore',
            'Calgary',
            'Edmonton',
            'St. Albert',
            'Strathcona County',
            'Fort McMurray',
            'Grande Prairie',
            'Lethrbridge',
            'Lloydminster',
            'Medicine Hat',
            'Red Deer',
            'Sherwood Park',
            'High River',
            'Jasper'
        ];

        foreach ($ab_cities as $city) {
            City::create([
                'subdivision_id' => $ab,
                'name' => $city
            ]);
        }

        // Sasktchewan
        $sk = Subdivision::where('abbreviation', 'SK')->first()->id;

        $sk_cities = [
            'La Ronge',
            'Meadow Lake',
            'Nipawin',
            'Prince Albert',
            'Moose Jaw',
            'Regina',
            'Saskatoon',
            'Swift Current',
            'Yorkton'
        ];

        foreach ($sk_cities as $city) {
            City::create([
                'subdivision_id' => $sk,
                'name' => $city
            ]);
        }

        // Manitoba
        $mb = Subdivision::where('abbreviation', 'MB')->first()->id;

        $mb_cities = [
            'Brandon',
            'Portage la Prairie',
            'Flin Flon',
            'Thompson',
            'Winnipeg'
        ];

        foreach ($mb_cities as $city) {
            City::create([
                'subdivision_id' => $mb,
                'name' => $city
            ]);
        }

        // Ontario
        $on = Subdivision::where('abbreviation', 'ON')->first()->id;

        $on_cities = [
            'Barrie',
            'Belleville',
            'Trenton',
            'Brantford',
            'Brockville',
            'Chatham-Kent',
            'Cornwall',
            'Guelph',
            'Hamilton',
            'Kapuskasing',
            'Kenora',
            'Kingston',
            'Napanee',
            'Cambridge',
            'Kitchener',
            'Waterloo',
            'Stratford',
            'Leamington',
            'London',
            'Muskoka',
            'Norfolk County',
            'North Bay',
            'Gatineau',
            'Ottawa',
            'Owen Sound',
            'Kawartha Lakes',
            'Peterborough',
            'Pembroke',
            'Petawawa',
            'Renfrew',
            'Grand Bend',
            'Sarnia',
            'Sault Ste. Marie',
            'St.Catherines',
            'Sudbury',
            'Thunder Bay',
            'Timmins',
            'Toronto',
            'Markham',
            'Mississauga',
            'Oakville',
            'Oshawa',
            'Woodstock'
        ];

        foreach ($on_cities as $city) {
            City::create([
                'subdivision_id' => $on,
                'name' => $city
            ]);
        }

        // Quebec
        $qc = Subdivision::where('abbreviation', 'QC')->first()->id;

        $qc_cities = [
            'Abitibi-Temiscamingue',
            'Rouyn-Noranda',
            'Val D’Or',
            'Baie-Comeau',
            'Drummondville',
            'Victoriaville',
            'Levis',
            'St-Georges-de-Beauce',
            'Thetford Mines',
            'Chibougamau',
            'Gaspe',
            'Granby',
            'Montreal',
            'Laval',
            'Longueuil',
            'West Island',
            'Lanaudiere',
            'Laurentides',
            'Shawnigan',
            'Trois-Rivieres',
            'Quebec City',
            'Rimouski',
            'Lac-Saint-Jean',
            'Saguenay',
            'Saint-Hyacinthe',
            'Saint-Jean-sur-Richelieu',
            'Sept-Iles',
            'Sherbrooke'
        ];

        foreach ($qc_cities as $city) {
            City::create([
                'subdivision_id' => $qc,
                'name' => $city
            ]);
        }

        // Newfoundland and Labrador
        $nl = Subdivision::where('abbreviation', 'NL')->first()->id;

        $nl_cities = [
            'Corner Brook',
            'Gander',
            'Goose Bay',
            'Labrador City',
            'St.Johns'
        ];

        foreach ($nl_cities as $city) {
            City::create([
                'subdivision_id' => $nl,
                'name' => $city
            ]);
        }

        // New Brunswick
        $nb = Subdivision::where('abbreviation', 'NB')->first()->id;

        $nb_cities = [
            'Bathurst',
            'Edmundston',
            'Fredericton',
            'Miramichi',
            'Moncton',
            'Saint John'
        ];

        foreach ($nb_cities as $city) {
            City::create([
                'subdivision_id' => $nb,
                'name' => $city
            ]);
        }

        // Nova Scotia
        $ns = Subdivision::where('abbreviation', 'NS')->first()->id;

        $ns_cities = [
            'Annapolis Valley',
            'Bridgewater',
            'Cape Breton',
            'Bedford',
            'Halifax',
            'Cole Harbour',
            'Dartmouth',
            'New Glasgow',
            'Truro',
            'Yarmouth'
        ];

        foreach ($ns_cities as $city) {
            City::create([
                'subdivision_id' => $ns,
                'name' => $city
            ]);
        }

        // Prince Edward Island
        $pe = Subdivision::where('abbreviation', 'PE')->first()->id;

        $pe_cities = [
            'Charlottetown',
            'Summerside'
        ];

        foreach ($pe_cities as $city) {
            City::create([
                'subdivision_id' => $pe,
                'name' => $city
            ]);
        }

        // Yukon
        $yt = Subdivision::where('abbreviation', 'YT')->first()->id;

        City::create([
            'subdivision_id' => $yt,
            'name' => 'Whitehorse'
        ]);

        // Northwest Territories
        $nt = Subdivision::where('abbreviation', 'NT')->first()->id;

        City::create([
            'subdivision_id' => $nt,
            'name' => 'Yellowknife'
        ]);

        // Nunavut
        $nu = Subdivision::where('abbreviation', 'NU')->first()->id;

        City::create([
            'subdivision_id' => $nu,
            'name' => 'Iqaluit'
        ]);
    }
}
