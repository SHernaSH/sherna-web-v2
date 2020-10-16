<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Navigation\Page\StoreRequest;
use App\Http\Requests\Navigation\Page\UpdateRequest;
use App\Http\Scopes\LanguageScope;
use App\Http\Services\PageService;
use App\Models\Language\Language;
use App\Models\Navigation\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

/**
 * Class handling CRUD operations on Page Model using PageService
 *
 * Subpages are stored in Session untill the whole Page is saved, after that they are saved too
 *
 * Class NavigationController
 * @package App\Http\Controllers\Admin
 */
class NavigationController extends Controller
{


    /**
     * Constructor initializing and associating page service
     *
     * NavigationController constructor.
     * @param PageService $pageService
     */
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * Display a listing of the navigation Pages
     *
     * @return View view with paginated pages
     */
    public function index()
    {
        $pages = Page::where('url', '!=', 'home')->orderBy('order')->paginate();
        return view('admin.navigation.index', ['navigations' => $pages]);
    }

    /**
     * Show the form for creating a new Page.
     * To keep the data in Session after reloading the page, new Session flag is created and used
     *
     * @return View view with the create form for Page
     */
    public function create()
    {
        if (Session::exists('creating')) {
            Session::reflash();
        } else {
            Session::flash('creating');
        }

        return view('admin.navigation.create');

    }

    /**
     * Store a newly created Page in storage.
     * Stroing the subpages from Session.
     *
     * @param StoreRequest $request  request with all the data from creation form
     * @return RedirectResponse redirect to index page
     */
    public function store(StoreRequest $request)
    {
        if($this->pageService->storeWholePage($request)) {
            flash('Page was created successfully')->success();
        } else {
            flash('Page creation was unsuccessful')->error();
        }
        return redirect()->route('navigation.index');
    }

    /**
     * Making the specified navigation Page public/private
     *
     * @param int $id           id of the specified navigation Page
     * @return RedirectResponse redirect to index page
     */
    public function public(int $id)
    {
        if($this->pageService->setPagePublic($id)) {
            flash('Page public status changes succesfully')->success();
        } else {
            flash('Action unsuccessful')->error();
        }

        return redirect()->route('navigation.index');
    }

    /**
     * Show the form for editing the specified navigation Page.
     *
     * Subpages are stored in Sessions, reflashing to keep the data for one more redirect if the page_id is same
     *
     * @param int $id   id of the specified navigation Page to be edited
     * @return View|RedirectResponse     view with the edition form or redirect back to index page if edition forbidden
     */
    public function edit($id)
    {
        $page = Page::where('id', $id)->firstOrFail();
        if ($this->pageService->isSpecialPage($page)) {
            flash('Edition not allowed.')->error();
            return redirect()->back();
        }

        foreach (Language::all() as $lang) {
            $subpagesOfLang = $page->subpages()->ofLang($lang)->get();
            if (!Session::exists('subpages-' . $lang->id)) {
                Session::flash('subpages-' . $lang->id, $subpagesOfLang);
                Session::flash('page_id', $page->id);
            }
        }
        if (Session::get('page_id') == $page->id) {
            Session::reflash();
        }
        return view('admin.navigation.edit', ['navigation' => $page]);
    }

    /**
     * Update the specified navigation Page in database.
     *
     * @param UpdateRequest $request  request with all the data from edition form
     * @param int $id           id of the specified navigation Page to be updated
     * @return RedirectResponse redirect to index page
     */
    public function update(UpdateRequest $request, $id)
    {
        $this->pageService->storeWholePage($request, $id);

        return redirect()->route('navigation.index');
    }

    /**
     * Remove the specified Navigatio Page from storage.
     *
     * @param int $id             id of the specified navigation Page to be deleted
     * @return RedirectResponse   redirect to index page
     */
    public function destroy($id)
    {
        if ($this->pageService->deletePage($id)) {
            flash('Page was successfully deleted.')->success();
        } else {
            flash('Page deletion was unsuccessful.')->error();
        }

        Session::reflash();
        return redirect()->route('navigation.index');
    }

    /**
     * Handling the AJAX call from reordering the navpages.
     * Changing the order of all affected pages
     */
    public function reorder()
    {
        $url = $_POST['url'];
        $newIndex = $_POST['newIndex'];
        $pages = Page::withoutGlobalScope(LanguageScope::class)->where('url', $url)->get();
        if($this->reorderNavigation($pages, $newIndex + 1)) {
            flash('Navigations were successfully reordered')->success();
        } else {
            flash('Navigation reorder was unsuccessful')->error();
        }
    }

    /**
     * Changing the order of all the affected pages
     *
     * @param $pages Page[]  all the pages
     * @param $newIndex int  new value of index
     */
    private function reorderNavigation($pages, int $newIndex)
    {
        $oldIndex = $pages[0]->order;
        DB::beginTransaction();

        try {
            foreach ($pages as $page) {
                $page->order = $newIndex;
                $page->save();
            }
            foreach (Page::withoutGlobalScope(LanguageScope::class)->where('url', '!=', $pages[0]->url)->get() as $page) {
                if ($page->order < $oldIndex && $page->order >= $newIndex) {
                    $page->order += 1;
                } else if ($page->order > $oldIndex && $page->order <= $newIndex) {
                    $page->order -= 1;
                }
                $page->save();
            }

            DB::commit();
            return true;
        } catch (\Exception $ex) {
            DB::rollBack();
            return false;
        }
    }

}
