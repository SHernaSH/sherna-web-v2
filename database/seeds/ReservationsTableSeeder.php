<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Reservations\Reservation::updateOrInsert([
            'id' => 1,
            'user_id' => 30542,
            'location_id' => 1,
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now()->addHour(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}
