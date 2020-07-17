<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\Category\StoreRequest;
use App\Http\Requests\Inventory\Category\UpdateRequest;
use App\Models\Inventory\InventoryCategory;
use App\Models\Language\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class handling the CRUD operations on Inventory Category Model
 *
 * Class InventoryCategoryController
 * @package App\Http\Controllers\Admin
 */
class InventoryCategoryController extends Controller
{
    /**
     * Display a listing of the Inventory Categories
     *
     * @return View    index page listing all the inventory categories paginated
     */
    public function index()
    {
        $inventoryCategories = InventoryCategory::paginate(20);

        return view('admin.inventory.category.index', ['inventoryCategories' => $inventoryCategories]);
    }

    /**
     * Show the form for creating a new Inventory Category
     *
     * @return View view with the create form for Inventory Category
     */
    public function create()
    {

        return view('admin.inventory.category.create');
    }

    /**
     * Show the form for editing the Inventory Category
     *
     * @param int $id         id of the Inventory Category that will be edited
     * @return View           view with edition form
     */
    public function edit(int $id)
    {
        $inventoryCategory = InventoryCategory::where('id', $id)->first();

        return view('admin.inventory.category.edit', ['inventoryCategory' => $inventoryCategory]);
    }

    /**
     * Store a newly created Inventory Category in database.
     *
     * @param StoreRequest $request          request with data from creation form
     * @return RedirectResponse         redirect to index page
     */
    public function store(StoreRequest $request)
    {
        $next_id = DB::table('inventory_categories')->max('id') + 1;
        foreach (Language::all() as $language) {
            $category = new InventoryCategory();
            $category->id = $next_id;
            $category->name = $request->get('name-' . $language->id);
            $category->language()->associate($language);
            $category->save();
        }

        flash()->success('Inventory category successfully created');

        return redirect()->route('inventory.category.index');
    }

    /**
     * Updating the chosen Invnetory Category
     *
     * @param int $id           id of the Inventory Category that will be updated
     * @param UpdateRequest $request  request with all the data from edition form
     * @return RedirectResponse index view of all the Inventory Categories
     */
    public function update(int $id, UpdateRequest $request)
    {
        foreach (Language::all() as $language) {
            $category = InventoryCategory::where('id', $id)->ofLang($language)->first();
            $category->name = $request->get('name-' . $language->id);
            $category->save();
        }

        flash()->success('Inventory category successfully updated');

        return redirect()->route('inventory.category.index');

    }

    /**
     * Removing the chosen Inventory Category from the database
     *
     * @param int $id           id of the Inventory Category that will be deleted
     * @return RedirectResponse index view of all the Inventory Categories
     */
    public function destroy(int $id)
    {
        try {
            foreach (Language::all() as $language) {
                $inventoryCategory = InventoryCategory::ofLang($language)->where('id', $id)->firstOrFail();
                $inventoryCategory->delete();
            }
            flash()->success('Inventory category successfully deleted');
        } catch (\Exception $ex) {
            flash()->error('Deletion of Inventory category was unsuccessful');
        }

        return redirect()->route('inventory.category.index');
    }
}
