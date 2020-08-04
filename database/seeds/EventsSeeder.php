<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Events\Event::updateOrInsert([
            'id' => 1,
            'name' => 'First event',
            'salt' => 'u#x34xW1@a!g',
            'location_id' => 1,
            'points' => 50,
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now()->addHour(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
