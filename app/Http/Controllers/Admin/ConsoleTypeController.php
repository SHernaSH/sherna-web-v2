<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Consoles\Type\StoreRequest;
use App\Http\Requests\Consoles\Type\UpdateRequest;
use App\Models\Consoles\ConsoleType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ConsoleTypeController extends Controller
{

    /**
     * Show the form for creating a new Console Type.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.consoles.types.create');
    }

    /**
     * Store a newly created Console Type in database.
     *
     * @param StoreRequest $request  request containing data from creation form
     * @return RedirectResponse return index view of console and console types
     */
    public function store(StoreRequest $request)
    {
        try {
            ConsoleType::create($request->all());
            flash()->success('Console type successfully created');
        }  catch (\Exception $ex) {
            flash()->error('Console type creation unsuccessful');
        }

        return redirect()->route('console.index');
    }


    /**
     * Show the form for editing the specified Console Type.
     *
     * @param ConsoleType $type  console type to be edited
     * @return View              return view with edition form
     */
    public function edit(ConsoleType $type)
    {
        return view('admin.consoles.types.edit', ['consoleType' => $type]);

    }

    /**
     * Update the specified Console Type in database.
     *
     * @param UpdateRequest $request  request containing all the data from edition form
     * @param ConsoleType $type Console type to be updated
     * @return RedirectResponse return index view with consoles and console types
     */
    public function update(UpdateRequest $request, ConsoleType $type)
    {
        try {
            $type->update($request->all());
            flash()->success('Console type successfully updated');
        }  catch (\Exception $ex) {
            flash()->error('Console type update unsuccessful');
        }

        return redirect()->route('console.index');
    }

    /**
     * Remove the specified Console Type from storage.
     *
     * @param ConsoleType $type console type to be removed
     * @return RedirectResponse return index view with consoles and console types
     */
    public function destroy(ConsoleType $type)
    {
        try {
            $type->delete();
            flash()->success('Console type successfully deleted');
        } catch (\Exception $ex) {
            flash()->error('Console type was not deleted');
        }
        return redirect()->route('console.index');
    }
}
