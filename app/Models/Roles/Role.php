<?php

namespace App\Models\Roles;

use App\Models\Permissions\Permission;
use \App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

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

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function hasPermission(Permission $permission)
    {
        return $this->permissions()->where('id', $permission->id)->exists();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermissionByName(string $name)
    {
        return $this->permissions()->where('name', $name)->exists();
    }
}
