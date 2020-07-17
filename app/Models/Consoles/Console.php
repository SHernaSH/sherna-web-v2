<?php

namespace App\Models\Consoles;

use App\Models\Games\Game;
use App\Models\Locations\Location;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Consoles\Console
 *
 * @property int $id
 * @property int $location_id
 * @property int $console_type_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Games\Game[] $games
 * @property-read int|null $games_count
 * @property-read \App\Models\Locations\Location $location
 * @property-read \App\Models\Consoles\ConsoleType $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\Console newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\Console newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Consoles\Console onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\Console query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\Console whereConsoleTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\Console whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\Console whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\Console whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\Console whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\Console whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\Console whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Consoles\Console withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Consoles\Console withoutTrashed()
 * @mixin \Eloquent
 */
class Console extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'name',
        'console_type_id',
        'location_id'
    ];

    protected $cascadeDeletes = ['games'];


    /**
     * Type of the console
     *
     * @return BelongsTo type of the console
     */
    public function type()
    {
        return $this->belongsTo(ConsoleType::class, 'console_type_id');
    }

    /**
     * Location in which this console is situated
     *
     * @return BelongsTo Location in which this console is situated
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');

    }

    /**
     * All games that are available for this console
     *
     * @return HasMany All games that are available for this console
     */
    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
