<?php

use App\Models\Games\Game;
use Illuminate\Database\Seeder;

class GamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Game::updateOrInsert([
            'id' => 1,
            'console_id' => 1,
            'name' => 'Hra',
            'note'=> "Example hra",
            'possible_players' => 3,
            'serial_id' => 123,
            'inventory_id' => 123,
            'vr' => true
        ]);
    }
}
