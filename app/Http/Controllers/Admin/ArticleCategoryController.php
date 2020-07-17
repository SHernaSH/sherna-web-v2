<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\JSON\AutocompleteModel;
use App\Http\Requests\Article\ArticleCategory\StoreRequest;
use App\Http\Requests\Article\ArticleCategory\UpdateRequest;
use App\Models\Articles\ArticleCategory;
use App\Models\Articles\ArticleCategoryDetail;
use App\Models\Language\Language;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Class handling CRUD operations of ArticleCategory Model and autocompletion
 *
 * Class ArticleCategoryController
 * @package App\Http\Controllers\Admin*
 */
class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the ArticleCategory.
     *
     * @return View index page listing all the article categories paginated
     */
    public function index()
    {
        $categories = ArticleCategory::paginate();
        return view('admin.blog.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new ArticleCategory
     *
     * @return View view with the create form for ArticleCategory
     */
    public function create()
    {
        return view('admin.blog.categories.create');
    }

    /**
     * Store a newly created ArticleCategory in database.
     *
     * Create a new main entry ArticleCategory, then create the details for all the languages
     * and associate it with language and the category
     *
     * @param StoreRequest $request  request from the create form
     * @return RedirectResponse redirect to index page
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $category = new ArticleCategory();
            $category->save();

            foreach (Language::all() as $language) {
                $detail = new ArticleCategoryDetail();
                $detail->name = $request->get('name-' . $language->id);
                $detail->language()->associate($language);
                $detail->category()->associate($category);
                $detail->save();
            }
            DB::commit();
            flash('Category was successfully created.')->success();
        } catch (\Exception $e) {
            DB::rollBack();
            flash('Category creation was unsuccessful.')->error();
        }

        return redirect()->route('category.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ArticleCategory $category  Category which data will be shown in the edit form
     * @return View                      view with the edit form
     */
    public function edit(ArticleCategory $category)
    {
        return view('admin.blog.categories.edit', ['category' => $category]);
    }

    /**
     * Update the ArticleCategory in database.
     *
     * @param UpdateRequest $request          request with the data from edit form
     * @param ArticleCategory $category category which shoudl be updated
     * @return RedirectResponse         redirect to index page
     */
    public function update(UpdateRequest $request, ArticleCategory $category)
    {
        foreach (Language::all() as $language) {
            $detail = $category->detail()->ofLang($language)->get()->first();
            $detail->name = $request->get('name-' . $language->id);
            $detail->save();
        }

        flash('Category was successfully updated.')->success();
        return redirect()->route('category.index');
    }

    /**
     * Remove the Article Category from storage.
     *
     * @param ArticleCategory $category
     * @return Response
     */
    public function destroy(ArticleCategory $category)
    {
        try {
            $category->delete();
        } catch (Exception $exception) {
            flash("Deletion of category was not successful.")->error();
            return redirect()->back();
        }

        flash('Category was successfully deleted.')->success();
        return redirect()->route('category.index');
    }

    /**
     * Method for AJAX autocomplete of article categories
     *
     * @return string JSON object consting of ArticleCategory name
     */
    public function auto()
    {
        return $this->autocomplete($_GET['term'] ?? '');
    }

    /**
     * @param string $term  needle in search
     * @return string       SON object consting of ArticleCategory name
     */
    private function autocomplete(string $term)
    {

        $categories = ArticleCategoryDetail::where('name', 'like', "%$term%")
            ->get()->pluck('name');
        $res = '';
        foreach ($categories as $category) {
            $jsonModel = new AutocompleteModel($category, $category);
            $res .= $jsonModel->getJSON();
        }
        return "[$res]";
    }
}
