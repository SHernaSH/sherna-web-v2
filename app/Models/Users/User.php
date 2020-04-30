<?php

namespace App\Models\Users;

use App\Models\Reservations\Reservation;
use App\Models\Roles\Role;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * App\Models\Users\User
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property int $banned
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $role_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reservations\Reservation[] $reservations
 * @property-read int|null $reservations_count
 * @property-read \App\Models\Roles\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Users\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereBanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Users\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Users\User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'name', 'surname', 'email', 'image', 'role',
        'banned'
    ];

    /**
     * Vytvoř instanci Eloquent modelu.
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

//        self::created(function (User $user) {
//            $user->assignRoles(['member']);
//        });
    }

    /**
     * Assign role specified by name to the user
     *
     * @param string $name name of the role to be assigned
     */
    public function assignRoleName(string $name)
    {
        $role = Role::where('name', $name)->firstOrFail();
        $this->assignRole($role);
    }

    /**
     * Assign specified role to the user
     *
     * @param Role $role role to be assigned
     */
    public function assignRole(Role $role)
    {
        $this->role()->associate($role);
    }

    /**
     * Returns role this user has
     *
     * @return BelongsTo role this user has
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if user is admin
     *
     * @return bool true is user is admin or super admin, false otherwise
     */
    public function isAdmin()
    {
        return $this->isSuperAdmin() || strtolower($this->role->name) == "admin";
    }

    /**
     * Check if user is super_ admin
     *
     * @return bool true is user is super admin, false otherwise
     */
    public function isSuperAdmin()
    {
        return strtolower($this->role->name) == "super_admin";
    }

    /**
     * All the reservations associated with the user
     *
     * @return HasMany All the reservations associated with the user
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}
