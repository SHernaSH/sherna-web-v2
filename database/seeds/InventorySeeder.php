<?php

use App\Models\Inventory\InventoryCategory;
use App\Models\Inventory\InventoryItem;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InventoryCategory::updateOrInsert([
            'id' => 1,
            'name' => 'Ukazkova kateogria',
            'language_id' => 1
        ]);

        InventoryCategory::updateOrInsert([
            'id' => 1,
            'name' => 'Example category',
            'language_id' => 2
        ]);

        InventoryItem::updateOrInsert([
            'id' => 1,
            'name' => 'Ukazkovy item',
            'note' => 'Ukazka',
            'category_id' => 1,
            'location_id' => 1,
            'language_id' => 1
        ]);

        InventoryItem::updateOrInsert([
            'id' => 1,
            'name' => 'Example item',
            'note' => 'Example',
            'category_id' => 1,
            'location_id' => 1,
            'language_id' => 2
        ]);
    }
}
