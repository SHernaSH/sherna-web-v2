<?php

namespace App\Models\Permissions;

use App\Models\Roles\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Permissions\Permission
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string $controller
 * @property string $method
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Roles\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\Permission whereController($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\Permission whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Permission extends Model
{
    /**
     * Roles to which this permission belongs
     *
     * @return BelongsToMany Roles to which this permission belongs
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
