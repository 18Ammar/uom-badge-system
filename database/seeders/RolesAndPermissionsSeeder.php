<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $superAdmin = Role::create(['name' => 'super admin']);
        $authorize = Role::create(['name' => 'authorize']);
        $client = Role::create(['name' => 'client']);
        
    }
}
