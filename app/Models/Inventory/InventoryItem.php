<?php

namespace App\Models\Inventory;


use App\Http\Traits\CompositePrimaryKeyTrait;
use App\Models\Extensions\LanguageModel;
use App\Models\Locations\Location;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Inventory\InventoryItem
 *
 * @property int $id
 * @property int $category_id
 * @property int $location_id
 * @property string $name
 * @property string|null $serial_id
 * @property string|null $inventory_id
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $language_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Inventory\InventoryCategory $category
 * @property-read \App\Models\Locations\Location $location
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extensions\LanguageModel ofLang(\App\Models\Language\Language $lang)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inventory\InventoryItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryItem whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryItem whereInventoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryItem whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryItem whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryItem whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryItem whereSerialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inventory\InventoryItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inventory\InventoryItem withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\Language\Language $language
 */
class InventoryItem extends LanguageModel
{
    use CompositePrimaryKeyTrait, SoftDeletes;

    protected $primaryKey = ['id', 'language_id'];


    /**
     * Category to which this item belongs
     *
     * @return BelongsTo Category to which this item belongs
     */
    public function category()
    {
        return $this->belongsTo(InventoryCategory::class, 'category_id', 'id');
    }

    /**
     * Location where this item is situated
     *
     * @return BelongsTo Location where this item is situated
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}
