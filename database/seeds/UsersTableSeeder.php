<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Vygeneruj testovací uživatelské účty.
     *
     * @return void
     */
    public function run()
    {
        /** @var User $admin */
        $admin = User::updateOrCreate([
            'id' => 1,
            'name' => 'admin',
            'surname' => 'Admin',
            'email' => 'admin@localhost',
            'role_id' => 5,
        ], [
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);
//        $admin->assignRole('admin');

        /** @var User $superAdmin */
        $superAdmin = User::updateOrCreate([
            'id' => 2,
            'name' => 'Super',
            'surname' => 'Admin',
            'email' => 'super_admin@localhost',
            'role_id' => 5,
        ], [
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);
//        $superAdmin->assignRoleName('super_admin');

        /** @var User $user */
        $user = User::updateOrCreate([
            'id' => 3,
            'name' => 'user',
            'surname' => 'User',
            'email' => 'user@localhost',
            'role_id' => 1,
        ], [
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);
//        $user->assignRoleName('user');


    }
}
