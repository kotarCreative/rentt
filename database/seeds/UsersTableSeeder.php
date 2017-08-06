<?php

use Illuminate\Database\Seeder;

/* Models */
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'city_id' => 1,
            'first_name' => 'David',
            'last_name' => 'Buss',
            'email' => 'kotarcreative@gmail.com',
            'description' => 'I like to code and build my website called Rentt.',
            'password' => bcrypt(env('ADMIN_PASS', 'password'))
        ]);
    }
}
