<?php

namespace Database\Seeders;

use Backpack\PermissionManager\app\Models\Permission;
use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Database\Seeder;

class PermissionManagerTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'super', 'guard_name' => 'web'])->users()->sync([10]);
        Role::create(['name' => 'store', 'guard_name' => 'web'])->users()->sync([1,2,3]);

        // Permission::create(['name' => 'manage stores', 'guard_name' => 'web'])->roles()->sync([1]);
        // Permission::create(['name' => 'manage employees', 'guard_name' => 'web'])->roles()->sync([1,2]);
        // Permission::create(['name' => 'manage posts', 'guard_name' => 'web'])->roles()->sync([1,2]);
        // Permission::create(['name' => 'manage reviews', 'guard_name' => 'web'])->roles()->sync([1,2]);
        // Permission::create(['name' => 'manage rating_fields', 'guard_name' => 'web'])->roles()->sync([1]);
        // Permission::create(['name' => 'manage review_fields', 'guard_name' => 'web'])->roles()->sync([1]);
        // Permission::create(['name' => 'manage areas', 'guard_name' => 'web'])->roles()->sync([1]);
        // Permission::create(['name' => 'manage majors', 'guard_name' => 'web'])->roles()->sync([1]);
        // Permission::create(['name' => 'manage charges', 'guard_name' => 'web'])->roles()->sync([1]);
        // Permission::create(['name' => 'manage permissions', 'guard_name' => 'web'])->roles()->sync([1]);
        // Permission::create(['name' => 'manage rols', 'guard_name' => 'web'])->roles()->sync([1]);
    }
}
