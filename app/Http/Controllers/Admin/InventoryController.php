<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreRequest;
use App\Http\Requests\Inventory\UpdateRequest;
use App\Models\Inventory\InventoryCategory;
use App\Models\Inventory\InventoryItem;
use App\Models\Language\Language;
use App\Models\Locations\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class handling the CRUD operations on Inventory Item Model
 * Class InventoryController
 * @package App\Http\Controllers\Admin
 */
class InventoryController extends Controller
{
    /**
     * Display a listing of the Inventory Items
     *
     * @return View    index page listing all the inventory items paginated
     */
    public function index()
    {
        $inventoryItems = InventoryItem::orderBy('name', 'asc')->paginate(20);

        return view('admin.inventory.index', ['inventoryItems' => $inventoryItems]);
    }

    /**
     * Show the form for creating a new Inventory Item
     *
     * @return View view with the create form for Inventory Item
     */
    public function create()
    {
        return view('admin.inventory.create');
    }
    /**
     * Show the form for editing the Inventory Item
     *
     * @param int $id         id of the Inventory Item that will be edited
     * @return View           view with edition form
     */
    public function edit(int $id)
    {
        $inventoryItem = InventoryItem::where('id', $id)->first();

        return view('admin.inventory.edit', ['inventoryItem' => $inventoryItem]);
    }

    /**
     * Store a newly created Inventory Item in database.
     * Validate data, assert Inventory Category and Location exist
     * Save new instances for every language
     *
     * @param StoreRequest $request     request with data from creation form
     * @return RedirectResponse         redirect to index page
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $category = InventoryCategory::where('id', $request->get('category_id'))->firstOrFail();
            $location = Location::where('id', $request->get('location_id'))->firstOrFail();
            $next_id = DB::table('inventory_items')->max('id') + 1;
            foreach (Language::all() as $language) {
                $item = new InventoryItem();
                $item->id = $next_id;
                $item->name = $request->get('name-' . $language->id);
                $item->serial_id = $request->get('serial_id');
                $item->inventory_id = $request->get('inventory_id');
                $item->note = $request->get('note');
                $item->language()->associate($language);
                $item->category()->associate($category);
                $item->location()->associate($location);
                $item->save();
            }

            DB::commit();
            flash()->success('Inventory item successfully created');
        } catch (\Exception $ex) {
            DB::rollBack();
            flash()->error('Inventory item creation was unsuccessful');
        }

        return redirect()->route('inventory.index');
    }

    /**
     * Updating the chosen Invnetory Item
     *
     * @param int $id           id of the Inventory Item that will be updated
     * @param UpdateRequest $request  request with all the data from edition form
     * @return RedirectResponse index view of all the Inventory Items
     */
    public function update(int $id, UpdateRequest $request)
    {
        DB::beginTransaction();

        try {
            $category = InventoryCategory::where('id', $request->get('category_id'))->firstOrFail();
            $location = Location::where('id', $request->get('location_id'))->firstOrFail();
            foreach (Language::all() as $language) {
                $item = InventoryItem::where('id', $id)->ofLang($language)->firstOrFail();
                $item->name = $request->get('name-' . $language->id);
                $item->serial_id = $request->get('serial_id');
                $item->inventory_id = $request->get('inventory_id');
                $item->note = $request->get('note');
                $item->category()->associate($category);
                $item->location()->associate($location);
                $item->save();
            }

            DB::commit();
            flash()->success('Inventory item successfully updated');
        } catch (\Exception $ex) {
            DB::rollBack();
            flash()->error('Inventory item update was unsuccessful');
        }

        return redirect()->route('inventory.index');
    }

    /**
     * Removing the chosen Inventory Item from the database
     *
     * @param int $id           id of the Inventory Item that will be deleted
     * @return RedirectResponse index view of all the Inventory Items
     */
    public function destroy(int $id)
    {
        try {
            foreach (Language::all() as $language) {
                $inventoryItem = InventoryItem::where('id', $id)->ofLang($language);
                $inventoryItem->delete();
                flash()->success('Inventory item successfully deleted');

            }
        } catch (\Exception $ex) {
            flash()->error('Deletion of Inventory item was unsuccessful');

        }

        return redirect()->route('inventory.index');
    }
}
