<?php

use Illuminate\Database\Seeder;

/* Models */
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $landlord = Role::create([ 'name' => 'landlord' ]);
        $tenant = Role::create([ 'name' => 'tenant' ]);
    }
}
