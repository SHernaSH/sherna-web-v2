<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\PageService;
use App\Models\Navigation\Page;
use App\Models\Navigation\SubPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 * Class handling the CRUD operations on Page and SubPage Text models
 *
 * Class PageController
 * @package App\Http\Controllers\Admin
 */
class PageController extends Controller
{

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * Display a listing of the standalone pages and their texts, meaning pages that has to be considered special in navigation.
     * These pages have set special_code in db model
     * Example is Reservation, Home Page, Inventory..
     *
     * @return View
     */
    public function standalone()
    {
        $pages = Page::whereNotNull('special_code')->where('dropdown', false)->orderBy('order')->paginate();
        return view('admin.pages.index', ['pages' => $pages, 'type' => 'page']);
    }

    /**
     * Display a listing of the navigation pages and their texts, meaning pages that have no dropdowns
     *
     * @return Response
     */
    public function navigation()
    {
        $pages = Page::where('dropdown', false)->whereNull('special_code')->orderBy('order')->paginate();
        return view('admin.pages.index', ['pages' => $pages, 'type' => 'page']);
    }

    /**
     * Display a listing of the subnavigation pages and their text, meaning pages that have parent Page
     *
     * @return Response
     */
    public function subnavigation()
    {
        $pages = SubPage::orderBy('order')->paginate();
        return view('admin.pages.index', ['pages' => $pages, 'type' => 'subpage']);
    }

    /**
     * Show the form for editing the specified Page/Subpage.
     *
     * @param int $id       id of the specified Page/Subpage to be edited
     * @param string $type  type of the page, whether it is Page or Subpage
     * @return View|RedirectResponse return view of edition form, or redirect bac kto index page if edition is forbidden
     */
    public function edit($id, $type)
    {
        if ($type == 'page') {
            $page = Page::where('id', $id)->firstOrFail();
        } else if ($type == 'subpage') {
            $page = SubPage::where('id', $id)->firstOrFail();
        }
        if (!isset($page->text)) {
            flash('Editation not allowed')->error();
            return redirect()->back();
        }
        if($this->pageService->isSpecialPage($page)) {
            return redirect()->route('page.standalone');

        }
        return view('admin.pages.edit', ['page' => $page, 'type' => $type]);

    }

    /**
     * Update the specified Page/Supbage in storage.
     *
     * @param Request $request request with all the data from edition form
     * @param int $id id of the specified Page/Subpage to be updated
     * @param string $type type of the page, whether it is Page or Subpage
     * @return View|RedirectResponse return view of edition form, or redirect back to index page if edition is forbidden
     */
    public function update(Request $request, $id, $type)
    {
        if ($type == 'page') {
            $page = Page::where('id', $id)->firstOrFail();
        } else if ($type == 'subpage') {
            $page = SubPage::where('id', $id)->firstOrFail();
        }
        $this->pageService->storeText($request, $page);

        return redirect()->route('page.' . ($type == 'page' ? 'navigation' : 'subnavigation'));

    }

    /**
     * Remove the specified Page/Supbage in storage.
     *
     * @param int $id id of the specified Page/Subpage to be deleted
     * @param string $type type of the page, whether it is Page or Subpage
     * @return RedirectResponse redirect to index page if edition is forbidden
     */
    public function destroy(int $id, string $type)
    {
        if ($type == 'page') {
            $this->pageService->deletePage($id);

        } else if ($type == 'subpage') {
            $this->pageService->deleteSubPage($id);
        }
        return redirect()->back();

    }
    /**
     * Make the specified Page/Supbage public/private
     *
     * @param int $id id of the specified Page/Subpage to be updated
     * @param string $type type of the page, whether it is Page or Subpage
     * @return RedirectResponse redirect to index page if edition is forbidden
     */
    public function public(int $id, string $type)
    {
        if ($type == 'page') {
            $this->pageService->setPagePublic($id);

        } else if ($type == 'subpage') {
            $this->pageService->setSubpagePublic($id);
        }
        return redirect()->back();
    }
}
