<?php

namespace App\Models\Roles;

use App\Models\Permissions\Permission;
use \App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Roles\Role
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permissions\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Users\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    public $timestamps = true;
    /**
     * Pole vlastností, které nejsou chráněné před mass assignment útokem.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Users with this role
     *
     * @return HasMany Users with this role
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check whether this role has specified permission
     *
     * @param Permission $permission specified permission
     * @return bool true if the role contains the permission, false otherwise
     */
    public function hasPermission(Permission $permission)
    {
        return $this->permissions()->where('id', $permission->id)->exists();
    }

    /**
     * All the permissions this role contains
     *
     * @return BelongsToMany All the permissions this role contains
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Check whether this role has permission specified
     *
     * @param string $name name of the permission
     * @return bool true if the role contains the permission, false otherwise
     */
    public function hasPermissionByName(string $name)
    {
        return $this->permissions()->where('name', $name)->exists();
    }
}
