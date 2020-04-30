<?php

namespace App\Models\Locations;

use App\Http\Scopes\LanguageScope;
use App\Http\Traits\CompositePrimaryKeyTrait;
use App\Models\Extensions\LanguageModel;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Locations\LocationStatus
 *
 * @property int $id
 * @property string $name
 * @property int $opened
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $language_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Locations\Location[] $locations
 * @property-read int|null $locations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\LocationStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\LocationStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extensions\LanguageModel ofLang(\App\Models\Language\Language $lang)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Locations\LocationStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\LocationStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\LocationStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\LocationStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\LocationStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\LocationStatus whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\LocationStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\LocationStatus whereOpened($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\LocationStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Locations\LocationStatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Locations\LocationStatus withoutTrashed()
 * @mixin \Eloquent
 */
class LocationStatus extends LanguageModel
{

    use SoftDeletes, CascadeSoftDeletes, CompositePrimaryKeyTrait;

    protected $primaryKey = ['id', 'language_id'];

    protected $cascadeDeletes = ['allLocations'];


    /**
     * Locations in the current language that are associated with this status
     *
     * @return HasMany Locations in the current language that are associated with this status
     */
    public function locations()
    {
        return $this->hasMany(Location::class, 'status_id', 'id');
    }

    /**
     * Locations in the all languages that are associated with this status
     *
     * @return HasMany Locations in the all languages that are associated with this status
     */
    public function allLocations()
    {
        return $this->hasMany(Location::class, 'status_id', 'id')
            ->withoutGlobalScope(LanguageScope::class);
    }
}
