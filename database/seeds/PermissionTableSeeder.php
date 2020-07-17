<?php

use App\Models\Permissions\Permission;
use App\Models\Roles\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_ids_for_guest = [2, 3, 6, 33, 34, 36, 37, 44, 45, 46, 47];
        $permission_ids_for_user = [2, 3, 6, 33, 34, 36, 37, 44, 45, 46, 47];
        $permission_ids = []; // an empty array of stored permission IDs
        // iterate though all routes
        foreach (Route::getRoutes()->getRoutes() as $key => $route) {
            // get route action
            $action = $route->getActionname();
            // separating controller and method
            $_action = explode('@', $action);

            $controller = $_action[0];
            $method = end($_action);

            // check if this permission is already exists
            $permission_check = Permission::where(
                ['controller' => $controller, 'method' => $method]
            )->first();
            if (!$permission_check) {
                $permission = new Permission();
                $permission->controller = $controller;
                $permission->method = $method;
                $permission->save();
                // add stored permission id in array
                $permission_ids[] = $permission->id;
            } else if(in_array($permission_check->id, $permission_ids_for_guest)) {
                $key = array_search($permission_check->id, $permission_ids_for_guest);
                unset($permission_ids_for_guest[$key]);
            }
        }
        if(!Permission::where(['name' => 'vr'])->first()) {
            $vr = new Permission();
            $vr->controller = 'vr';
            $vr->method = 'vr';
            $vr->description = 'Can use vr';
            $vr->name = 'vr';
            $vr->save();
            $permission_ids[] = $vr->id;
        }

        if(!Permission::where(['name' => 'Reservation Manager'])->first()) {
            $reservationManager = new Permission();
            $reservationManager->controller = 'Reservation';
            $reservationManager->method = 'Manager';
            $reservationManager->description = 'Can use edit reservations';
            $reservationManager->name = 'Reservation Manager';
            $reservationManager->save();
            $permission_ids[] = $reservationManager->id;
        }
        // find admin role.
        $admin_role = Role::where('name', 'super_admin')->first();
        // atache all permissions to admin role
        $admin_role->permissions()->attach($permission_ids);
        $guest_role = Role::where('name', 'guest')->first();
//        $guest_role ->permissions()->attach($permission_ids_for_guest);
    }
}
