<?php

namespace App\Models\Locations;

use App\Http\Scopes\LanguageScope;
use App\Http\Traits\CompositePrimaryKeyTrait;
use App\Models\Consoles\Console;
use App\Models\Events\Event;
use App\Models\Extensions\LanguageModel;
use App\Models\Reservations\Reservation;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Locations\Location
 *
 * @property int $id
 * @property string $name
 * @property int $status_id
 * @property string|null $reader_uid
 * @property string|null $location_uid
 * @property int $language_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Locations\LocationStatus $allStatuses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Consoles\Console[] $consoles
 * @property-read int|null $consoles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reservations\Reservation[] $reservations
 * @property-read int|null $reservations_count
 * @property-read \App\Models\Locations\LocationStatus $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extensions\LanguageModel ofLang(\App\Models\Language\Language $lang)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Locations\Location onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\Location opened()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\Location query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\Location whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\Location whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\Location whereLocationUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\Location whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\Location whereReaderUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\Location whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Locations\Location whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Locations\Location withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Locations\Location withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\Language\Language $language
 */
class Location extends LanguageModel
{
    //

    use SoftDeletes, CascadeSoftDeletes, CompositePrimaryKeyTrait;

    public $incrementing = false;
    protected $primaryKey = ['id', 'language_id'];
    protected $cascadeDeletes = ['reservations'];


    /**
     * Has One relation using global LanguageScope
     * Every article has only one text of current language
     *
     * @return BelongsTo status of the location in current language
     */
    public function status()
    {
        return $this->belongsTo(LocationStatus::class, 'status_id', 'id');
    }

    /**
     * Has Many relation
     * Query without global LanguageScope
     * Every article has text for every language
     *
     * @return BelongsTo status of the location in all languages
     */
    public function allStatuses()
    {
        return $this->belongsTo(LocationStatus::class, 'status_id', 'id')
            ->withoutGlobalScope(LanguageScope::class);
    }

    /**
     * All the reservations that are situated in this location
     *
     * @return HasMany all the reservations that are situated in this location
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'location_id', 'id')
            ->withoutGlobalScope(LanguageScope::class);
    }

    /**
     * All the events that are situated in this location
     *
     * @return HasMany all the reservations that are situated in this location
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'location_id', 'id')
            ->withoutGlobalScope(LanguageScope::class);
    }

    /**
     * Scope to return only openend locations
     *
     * @param $query
     * @return mixed
     */
    public function scopeOpened($query)
    {
        return $query->whereHas('status', function ($q) {
            $q->where('opened', true);
        });
    }

    public function consoles()
    {
        return $this->hasMany(Console::class, 'location_id', 'id');
    }
}
