<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Settings\Setting::updateOrInsert([
            'id' => 1,
            'name' => 'Reservation Area',
            'value' => 30.0,
            'unit' => 'days',

        ]);
        \App\Models\Settings\Setting::updateOrInsert([
            'id' => 2,
            'name' => 'Time for edit',
            'value' => 15.0,
            'unit' => 'minutes',

        ]);
        \App\Models\Settings\Setting::updateOrInsert([
            'id' => 3,
            'name' => 'Maximal Duration',
            'value' => 8.0,
            'unit' => 'hours',
        ]);

        \App\Models\Settings\Setting::updateOrInsert([
            'id' => 4,
            'name' => 'Points for one hour',
            'value' => 100.0,
            'unit' => 'points',

        ]);
        \App\Models\Settings\Setting::updateOrInsert([
            'id' => 5,
            'name' => 'Points for max hours',
            'value' => 700.0,
            'unit' => 'points',

        ]);
        \App\Models\Settings\Setting::updateOrInsert([
            'id' => 6,
            'name' => 'Points for extra reservation',
            'value' => 1000.0,
            'unit' => 'points',
        ]);
    }
}
