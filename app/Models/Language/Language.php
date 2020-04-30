<?php

namespace App\Models\Language;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Language\Language
 *
 * @property int $id
 * @property string|null $name
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language\Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language\Language newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Language\Language onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language\Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language\Language whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language\Language whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language\Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language\Language whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Language\Language withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Language\Language withoutTrashed()
 * @mixin \Eloquent
 */
class Language extends Model
{
    //
    use SoftDeletes;
}
