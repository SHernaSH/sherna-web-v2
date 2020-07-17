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
    }
}
