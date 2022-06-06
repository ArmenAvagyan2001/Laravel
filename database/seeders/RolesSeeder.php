<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);

        $role_client = Role::create(['name' => 'client', 'guard_name' => 'web']);

        $role_manager = Role::create(['name' => 'manager', 'guard_name' => 'web']);

//        $role_client->givePermissionTo('create post');
//        $role_client->givePermissionTo('update post');
//        $role_client->givePermissionTo('delete post');
    }
}
