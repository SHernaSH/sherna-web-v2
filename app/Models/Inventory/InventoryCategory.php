<?php

namespace App\Models\Inventory;

use App\Http\Traits\CompositePrimaryKeyTrait;
use App\Models\Extensions\LanguageModel;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Inventory\InventoryCategory
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $language_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inventory\InventoryItem[] $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extensions\LanguageModel ofLang(\App\Models\Language\Language $lang)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inventory\InventoryCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryCategory whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inventory\InventoryCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inventory\InventoryCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inventory\InventoryCategory withoutTrashed()
 * @mixin \Eloquent
 */
class InventoryCategory extends LanguageModel
{
    use CompositePrimaryKeyTrait, SoftDeletes, CascadeSoftDeletes;

    protected $primaryKey = ['id', 'language_id'];

    protected $cascadeDeletes = ['items'];


    /**
     * All items of this category
     *
     * @return HasMany All items of this category
     */
    public function items()
    {
        return $this->hasMany(InventoryItem::class, 'category_id', 'id');
    }
}
