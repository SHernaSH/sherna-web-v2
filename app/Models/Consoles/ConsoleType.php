<?php

namespace App\Models\Consoles;

use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Consoles\ConsoleType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Consoles\Console[] $consoles
 * @property-read int|null $consoles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\ConsoleType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\ConsoleType newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Consoles\ConsoleType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\ConsoleType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\ConsoleType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\ConsoleType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\ConsoleType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\ConsoleType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consoles\ConsoleType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Consoles\ConsoleType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Consoles\ConsoleType withoutTrashed()
 * @mixin \Eloquent
 */
class ConsoleType extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['consoles'];
    protected $fillable = [
        'name'
    ];

    /**
     * All the consoles of this type
     *
     * @return HasMany All the consoles of this type
     */
    public function consoles()
    {
        return $this->hasMany(Console::class);
    }
}
