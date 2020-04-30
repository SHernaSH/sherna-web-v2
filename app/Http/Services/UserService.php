<?php


namespace App\Http\Services;

use App\Models\Roles\Role;
use \App\Models\Users\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Class performing getting users data and update them
 *
 * Class UserService
 * @package App\Http\Services
 */
class UserService
{

    /**
     * Get all users paginated
     *
     * @param int $perPage  number of users shown per page
     * @return Collection   collection of users paginated
     */
    public function getAllUsers(int $perPage = 20)
    {
        return User::orderBy('surname')->paginate($perPage);
    }

    /**
     * Get all users satisfying the requested filters paginated
     *
     * @param array $conditions conditions that the users must satisfy
     * @param int $perPage number of users shown per page
     * @return Collection   collection of users paginated
     */
    public function getUsersFiltered($conditions, int $perPage = 20)
    {
        return User::where(function ($q) use ($conditions) {
            foreach ($conditions as $key => $value) {
                $q->where($key, 'LIKE', '%' . $value . '%');
            }
        })->orderBy('surname')->paginate($perPage);
    }

    /**
     * (Un)ban the chosen User
     *
     * @param User $user user to be (un)banned
     * @return bool true if success, false otherwise
     */
    public function changeBanStatus(User $user)
    {
        $user->banned = !$user->banned;

        return $this->safeSave($user);
    }

    /**
     * Change the role of the chosen User
     *
     * @param User $user user to be (un)banned
     * @param Role $role role that should be associated with user
     * @return bool true if success, false otherwise
     */
    public function changeUserRole(User $user, Role $role)
    {
        if ($role->name == 'super_admin' && !Auth::user()->isSuperAdmin())
            return false;
        $user->role()->associate($role);

        return $this->safeSave($user);

    }

    private function safeSave(User $user)
    {
        try {
            $user->save();
        } catch (Exception $ex) {
            return false;
        }
        return true;
    }
}
