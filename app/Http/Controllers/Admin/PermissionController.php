<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permissions\UpdateRequest;
use App\Models\Permissions\Permission;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class PermissionController extends Controller
{
    /**
     * Display a listing of all the Permissions.
     *
     * @return View
     */
    public function index()
    {
        $permissions = Permission::latest()->paginate();
        return view('admin.permissions.index', ['permissions' => $permissions]);
    }


    /**
     * Show the form for editing the specified Permission.
     *
     * @param Permission $permission    permission to be edited
     * @return View                     return view with edition form
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', ['permission' => $permission]);
    }

    /**
     * Update the specified Permission in storage.
     *
     * @param UpdateRequest $request       request with all the data from edition form
     * @param Permission $permission permission to be edited
     * @return Response
     */
    public function update(UpdateRequest $request, Permission $permission)
    {
        $permission->name = $request->get('name');
        $permission->description = $request->get('description');
        $permission->update();

        flash('Permission successfully updated')->success();

        return redirect()->route('permission.index');

    }

    /**
     * Remove the specified Permission from database
     *
     * @param Permission $permission specified Permission to be deletod
     * @return RedirectResponse      redirect to index page
     */
    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();
        } catch (Exception $exception) {
            flash("Deletion of permission was not successful.")->error();
            return redirect()->back();
        }

        flash('Permission was successfully deleted.')->success();
        return redirect()->route('permission.index');
    }


    /**
     * Generate all the permission by calling Permission Table seeder
     * It will add all newly added routes to DB and associate the permissions with super_admin role
     * Entries already in db will be ignored
     *
     * @return RedirectResponse redirect to index page
     */
    public function generate()
    {
        Artisan::call('db:seed', ['--class' => 'PermissionTableSeeder']);

        flash('Permissions successfully generated')->success();

        return redirect()->route('permission.index');
    }

}
