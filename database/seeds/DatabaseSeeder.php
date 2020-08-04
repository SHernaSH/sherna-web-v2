<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguagesSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
        $this->call(NavPagesSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(LocationStatusSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(ReservationsTableSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(ConsolesSeeder::class);
        $this->call(GamesSeeder::class);
        $this->call(InventorySeeder::class);
        $this->call(EventsSeeder::class);
    }
}
