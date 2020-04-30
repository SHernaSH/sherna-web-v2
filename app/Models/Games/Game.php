<?php

namespace App\Models\Games;

use App\Models\Consoles\Console;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Games\Game
 *
 * @property int $id
 * @property int $console_id
 * @property string $name
 * @property string|null $note
 * @property int $possible_players
 * @property string $serial_id
 * @property string $inventory_id
 * @property int $vr
 * @property int $move
 * @property int $kinect
 * @property int $game_pad
 * @property int $guitar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Consoles\Console $console
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game whereConsoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game whereGamePad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game whereGuitar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game whereInventoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game whereKinect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game whereMove($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game wherePossiblePlayers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game whereSerialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Games\Game whereVr($value)
 * @mixin \Eloquent
 */
class Game extends Model
{
    protected $fillable = [
        'name', 'note', 'console_id', 'possible_players', 'serial_id',
        'inventory_id', 'vr', 'move', 'kinect', 'game_pad', 'guitar'
    ];

    /**
     * Console for which this game is available
     *
     * @return BelongsTo Console for which this game is available
     */
    public function console()
    {
        return $this->belongsTo(Console::class);
    }
}
