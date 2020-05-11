<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Locations\StoreRequest;
use App\Http\Requests\Locations\UpdateRequest;
use App\Models\Language\Language;
use App\Models\Locations\Location;
use App\Models\Locations\LocationStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 * Class handling the CRUD operations on Location Model
 *
 * Class LocationController
 * @package App\Http\Controllers\Admin
 */
class LocationController extends Controller
{
    /**
     * Display a listing of the Location and Locations Statuses.
     *
     * @return View view with paginated locations and location statuses
     */
    public function index()
    {
        $locations = Location::latest()->paginate();
        $statuses = LocationStatus::latest()->paginate();
        return view('admin.locations.index', ['locations' => $locations,
            'statuses' => $statuses]);
    }

    /**
     * Show the form for creating a new Location.
     *
     * @return View view with the create form for Location
     */
    public function create()
    {
        return view('admin.locations.create');

    }

    /**
     * Store a newly created Location in database.
     *
     * @param StoreRequest $request  request with all the data from creation form
     * @return RedirectResponse redirect to index page
     */
    public function store(StoreRequest $request)
    {
        $next_id = DB::table('locations')->max('id') + 1;
        $status = LocationStatus::where('id', $request->input('status'))->firstOrFail();
        $uid = $request->input('location_id');
        $reader = $request->input('reader_uid');
        foreach (Language::all() as $lang) {
            $loc = new Location();
            $loc->id = $next_id;
            $loc->location_uid = $uid;
            $loc->reader_uid = $reader;
            $loc->name = $request->input('name-' . $lang->id);
            $loc->status()->associate($status);
            $loc->language()->associate($lang);
            $loc->save();
        }

        flash('Location was successfully created')->success();
        return redirect()->route('location.index');
    }

    /**
     * Show the form for editing the specified Location.
     *
     * @param int $id   id of the specified Location to be edited
     * @return View     view with the edition form
     */
    public function edit(int $id)
    {
        $location = Location::where('id', $id)->firstOrFail();

        return view('admin.locations.edit', ['location' => $location]);
    }

    /**
     * Update the specified Location in storage.
     *
     * @param UpdateRequest $request  request with all the data from edition form
     * @param int $id           id of the specified Location to be updated
     * @return RedirectResponse redirect to index page
     */
    public function update(UpdateRequest $request, int $id)
    {
        $status = LocationStatus::where('id', $request->input('status'))->firstOrFail();
        $uid = $request->input('location_uid');
        $reader = $request->input('reader_uid');
        foreach (Language::all() as $lang) {
            $location = Location::where('id', $id)->ofLang($lang)->firstOrFail();
            $location->name = $request->input('name-' . $lang->id);
            $location->location_uid = $uid;
            $location->reader_uid = $reader;
            $location->status()->associate($status);
            $location->save();
        }

        flash("Successfully updated.")->success();
        return redirect()->route('location.index');
    }

    /**
     * Remove the specified Location from database
     *
     * @param int $id           id of the specified Location to be deleted
     * @return RedirectResponse redirect to index page
     */
    public function destroy(int $id)
    {
        foreach (Language::all() as $lang) {
            try {
                $location = Location::where('id', $id)->ofLang($lang)->firstOrFail();
                $location->delete();
            } catch (Exception $exception) {
                flash("Deletion was unsuccessful.")->error();
                return redirect()->back();
            }
        }
        flash("Deletion was successful.")->success();

        return redirect()->route('location.index');
    }
}
