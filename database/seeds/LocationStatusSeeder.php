<?php

use App\Models\Locations\LocationStatus;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class LocationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LocationStatus::updateOrInsert([
            'id' => 1,
            'name' => 'Otvorene',
            'opened' => true,
            'language_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        LocationStatus::updateOrInsert([
            'id' => 1,
            'name' => 'Open',
            'opened' => true,
            'language_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        LocationStatus::updateOrInsert([
            'id' => 2,
            'name' => 'Zatvorene',
            'language_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        LocationStatus::updateOrInsert([
            'id' => 2,
            'name' => 'Closed',
            'language_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        LocationStatus::updateOrInsert([
            'id' => 3,
            'name' => 'Na kluc',
            'language_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        LocationStatus::updateOrInsert([
            'id' => 3,
            'name' => 'Key',
            'language_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
