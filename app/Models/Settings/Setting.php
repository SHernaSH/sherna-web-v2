<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Settings\Setting
 *
 * @property int $id
 * @property string $name
 * @property float $value
 * @property string $unit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings\Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings\Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings\Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings\Setting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings\Setting whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings\Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings\Setting whereValue($value)
 * @mixin \Eloquent
 */
class Setting extends Model
{
    //
}
