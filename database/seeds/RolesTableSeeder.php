<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Vygeneruj základní uživatelské role.
     *
     * @return void
     */
    public function run()
    {
        \App\Role::updateOrInsert([
            'id' => 1,
            'name' => 'guest',
            'description' => 'Role for not logged in users',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \App\Role::updateOrInsert([
            'id' => 2,
            'name' => 'user',
            'description' => 'Role for logged in users',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \App\Role::updateOrInsert([
            'id' => 3,
            'name' => 'user_vr',
            'description' => 'Role for not logged in users that can use VR',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \App\Role::updateOrInsert([
            'id' => 4,
            'name' => 'admin',
            'description' => 'Role for admins',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \App\Role::updateOrInsert([
            'id' => 5,
            'name' => 'super_admin',
            'description' => 'Role for super admins',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
//        DB::table('roles')->updateOrInsert([
//            'name' => 'Administrátor',
//            'slug' => 'admin',
//        ], [
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//        ]);
//        DB::table('roles')->updateOrInsert([
//            'name' => 'Člen',
//            'slug' => 'member',
//        ], [
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//        ]);
    }
}
