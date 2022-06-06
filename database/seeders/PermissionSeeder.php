<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'create post', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete post', 'guard_name' => 'web']);
        Permission::create(['name' => 'update post', 'guard_name' => 'web']);
    }
}
