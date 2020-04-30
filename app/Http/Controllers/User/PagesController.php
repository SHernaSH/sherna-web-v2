<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Navigation\Page;
use \App\Models\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class handling showing of the navigation/subnavigation pages and the home page
 *
 * Class PagesController
 * @package App\Http\Controllers\User
 */
class PagesController extends Controller
{
    /**
     * Show the requested (sub)page
     *
     * @param string $pageUrl  url of the page
     * @param null|string $subpageUrl url of the subpage, null if no subpage was requested
     * @return View view of the requested (sub)page
     */
    public function show(string $pageUrl, string $subpageUrl = null)
    {
        if (!$subpageUrl) {
            return $this->showPageText($pageUrl);
        } else {
            return $this->showSubpageText($pageUrl, $subpageUrl);
        }
    }

    private function showPageText($url)
    {
        $page = Page::where('url', $url)->public()->firstOrFail();
        $text = $page->text;
        if ($page->dropdown || !$text) {
            abort(404);
        }
        $text->special_code = $page->special_code;
        return view('client.pages.show', ['page' => $text]);
    }

    private function showSubpageText($pageUrl, $subpageUrl)
    {
        $page = Page::where('url', $pageUrl)->public()->firstOrFail();
        if (!$page->dropdown || !$page->subpages) {
            abort(404);
        }
        $subpage = $page->subpages()->where('url', $subpageUrl)->public()->firstOrFail();
        if (!$subpage->text) {
            abort(404);
        }
        $text = $subpage->text;
        return view('client.pages.show', ['page' => $text]);


    }

    /**
     * Show the index home page of the application
     *
     * @return View return home page
     */
    public function home()
    {
        if (env('APP_ENV') == 'local' && !Auth::check())
//            Auth::loginUsingId(User::first()->id);
        Auth::loginUsingId(User::where('id', env('SUPER_ADMINS'))->first()->id);

        $page = Page::where('special_code', 'home')->firstOrfail();
        return view('client.index', ['page' => $page->text]);
    }

}
