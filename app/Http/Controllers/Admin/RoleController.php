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
use Illuminate\Support\Facades\DB;
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
        if($request->get('parent_id')) {
            $role->parent_id = $request->get('parent_id');
        }
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
        DB::beginTransaction();
        try {
            $role->name = $request->get('name');
            $role->description = $request->get('description');
            if($request->get('parent_id')) {
                $role->parent_id = $request->get('parent_id');
            }

            $ids = $request->get('permissions', []);
            $newPermissions = Permission::whereIn('id', $ids)->pluck('id')->toArray();
            $rolePermissions = $role->permissions()->pluck('id')->toArray();
            $toDelete = array_diff($rolePermissions, $newPermissions);
            $toAdd = array_diff($newPermissions, $rolePermissions);
            $role->permissions()->detach($toDelete);
            $role->permissions()->attach($toAdd);
            $role->update();

            DB::commit();
            flash('Role successfully updated')->success();
        } catch (\Exception $ex) {
            DB::rollBack();
            flash('Role update was not successful')->error();

        }
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
        DB::beginTransaction();
        try {
            foreach ($role->roles as $inher) {
                $inher->parent_id = null;
                $inher->update();
            }
            $role->delete();
            DB::commit();
            flash('Deletion of role was successful')->success();
        } catch (\Exception $ex) {
            DB::rollBack();
            flash('Deletion of role was unsuccessful')->error();
        }

        return redirect()->route('role.index');
    }
}
