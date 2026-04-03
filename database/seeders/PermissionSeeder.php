<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Generic CRUD actions — used by PostPolicy (slug + pivot table_name)
        Permission::create(['name' => 'Read',   'slug' => 'read']);
        Permission::create(['name' => 'Create', 'slug' => 'create']);
        Permission::create(['name' => 'Update', 'slug' => 'update']);
        Permission::create(['name' => 'Delete', 'slug' => 'delete']);
    }
}
