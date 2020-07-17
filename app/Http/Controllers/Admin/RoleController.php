<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreRequest;
use App\Http\Requests\Roles\UpdateRequest;
use App\Models\Permissions\Permission;
use App\Models\Roles\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 * Class handling CRUD operations on Role Model
 *
 * Class RoleController
 * @package App\Http\Controllers\Admin
 */
class RoleController extends Controller
{
    /**
     * Display a listing of the Roles.
     *
     * @return View return view with listing of all roles paginated
     */
    public function index()
    {
        $roles = Role::latest()->paginate();
        return view('admin.roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new Role.
     *
     * @return View return view with the creation form
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created Role in database.
     *
     * @param StoreRequest $request  request containing all data from creation form
     * @return RedirectResponse redirect to index page
     */
    public function store(StoreRequest $request)
    {
        $role = new Role();
        $role->name = $request->get('name');
        $role->description = $request->get('description');
        $role->save();

        $role->permissions()->attach($request->get('permissions'));

        flash('Role successfully added')->success();

        return redirect()->route('role.index');
    }


    /**
     * Show the form for editing the specified Role.
     *
     * @param Role $role specified Role to be editted
     * @return View      return view with edition form
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit', ['role' => $role]);

    }

    /**
     * Update the specified Role in storage.
     *
     * @param UpdateRequest $request  request with all the data from edition form
     * @param Role $role        specified Role to be updated
     * @return RedirectResponse redirect to index page
     */
    public function update(UpdateRequest $request, Role $role)
    {
        $role->name = $request->get('name');
        $role->description = $request->get('description');

        $ids = $request->get('permissions', []);
        $newPermissions = Permission::whereIn('id', $ids)->pluck('id')->toArray();
        $rolePermissions = $role->permissions()->pluck('id')->toArray();
        $role->permissions()->detach(array_diff($rolePermissions, $newPermissions));
        $role->permissions()->attach(array_diff($newPermissions, $rolePermissions));
        $role->update();

        flash('Role successfully updated')->success();

        return redirect()->route('role.index');
    }

    /**
     * Remove the specified Role from database.
     *
     * @param Role $role    specified Role to be deleted
     * @return RedirectResponse redirect to index page
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();
        } catch (\Exception $ex) {
            flash('Deletion of role was unsuccessful')->error();
        }

        return redirect()->route('role.index');
    }
}
