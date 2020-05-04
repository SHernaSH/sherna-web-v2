<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Consoles\StoreRequest;
use App\Http\Requests\Consoles\UpdateRequest;
use App\Models\Consoles\Console;
use App\Models\Consoles\ConsoleType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class handling CRUD operations on Console Model
 *
 * Class ConsoleController
 * @package App\Http\Controllers\Admin
 */
class ConsoleController extends Controller
{
    /**
     * Display a listing of the Consoles and Console Types.
     *
     * @return View    index page listing all the consoles and consoles types paginated
     */
    public function index()
    {
        $consoles = Console::paginate(15);
        $consoleTypes = ConsoleType::paginate(15);

        return view('admin.consoles.index', ['consoles' => $consoles, 'consoleTypes' => $consoleTypes]);
    }

    /**
     * Show the form for creating a new Console
     *
     * @return View view with the create form for Console
     */
    public function create()
    {
        return view('admin.consoles.create');
    }

    /**
     * Show the form for editing the Article
     *
     * @param Console $console   Console that will be edited
     * @return View              view with edition form
     */
    public function edit(Console $console)
    {

        return view('admin.consoles.edit', ['console' => $console]);
    }

    /**
     * Store a newly created Console in database.
     *
     * @param StoreRequest $request          request with data from creation form
     * @return RedirectResponse         redirect to index page
     */
    public function store(StoreRequest $request)
    {
        Console::create($request->all());
        flash()->success('Console successfully created');

        return redirect()->route('console.index');
    }

    /**
     * Update the Console in database.
     *
     * @param UpdateRequest $request
     * @param Console $console
     * @return RedirectResponse  return index view of consoles
     */
    public function update(Console $console, UpdateRequest $request)
    {
        $console->update($request->all());
        flash()->success('Console successfully updated');

        return redirect()->route('console.index');
    }

    /**
     * Deleting the Console from db
     *
     * @param Console $console  console to be deleted
     * @return RedirectResponse return undex view of consoles
     */
    public function delete(Console $console)
    {
        try {
            $console->delete();
            flash()->success('Console successfully deleted');
        } catch (\Exception $ex) {
            flash('Deletion of console was unsuccessful')->error();
        }

        return redirect()->route('console.index');
    }
}
