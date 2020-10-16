<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Navigation\Subpage\StoreRequest;
use App\Http\Requests\Navigation\Subpage\UpdateRequest;
use App\Models\Language\Language;
use App\Models\Navigation\SubPage;
use App\Models\Navigation\SubPageText;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

/**
 * Class handling the CRUD operation of Supbage and Subpage Text models
 * Models are sotred in Sessions, not in DB, until the parent Page is stored
 * Subpages are stored per language
 *
 * Class SubpageController
 * @package App\Http\Controllers\Admin
 */
class SubpageController extends Controller
{

    private function forget($bag) {
        Session::forget($bag);
    }

    /**
     * Make the subpage public/not public, depending on the previous state
     *
     * @param string $url  url of the specified Subpage to be make public/private
     * @return \Illuminate\Http\RedirectResponse
     */
    public function public(string $url) {
        $this->forget('errors');

        foreach (Language::all() as $language) {
            foreach (Session::get('subpages-' . $language->id, collect()) as $sub) {
                if ($sub->url == $url) {
                    $sub->public = !$sub->public;
                }
            }
        }
        Session::reflash();
        return redirect()->back()->with(['is_dropdown' => true])->withInput();
    }

    /**
     * Return the form for creating a new Subpage
     *
     * @return array|string view of the creation form as rendered html page as string
     * @throws \Throwable
     */
    public function create()
    {
        $this->forget('errors');

        Session::reflash();
        return view('admin.navigation.subpages.create', [
            'url' => \request()->get('url'),
            'order' => \request()->get('order'),
            'is_public' => \request()->get('public'),
            'name' => [1 => \request()->get('name-1'), 2 => \request()->get('name-2')]
        ])->render();
    }

    /**
     * Store a newly created Subpage in Session.
     *
     * @param Request $request
     * @return RedirectResponse redirect back to Page creation page
     */
    public function store(StoreRequest $request)
    {
        $this->forget('errors');

        $next_order = 0;

        $actives = Session::get('subpages-1', collect());
        foreach($actives as $ac) {
            $next_order = max($ac->order, $next_order);
        }
        $next_order++;

        foreach (Language::all() as $lang) {
            $subpages = Session::get('subpages-' . $lang->id, collect());
            $subpage = new SubPage();
            $subpage->order = $next_order;
            $subpage->url = $request->get('sub_url');
            $subpage->name = $request->get('sub_name-' . $lang->id);
            $subpage->public = $request->get('sub_public', false) ? 1 : 0;
            $subpage->language()->associate($lang);

            $subpages[] = $subpage;

            $text = new SubPageText();
            $text->title = $subpage->name;
            $text->content = $request->get('sub_text_content-' . $lang->id);
            $text->language()->associate($lang);
            $subpage->text = $text;
            Session::flash('subpages-' . $lang->id, $subpages);

        }
        Session::reflash();
        return redirect()->back()->with(['is_dropdown' => true])
            ->withInput($request->only('url', 'order', 'is_public', 'name-1', 'name-2'));

    }

    /**
     * Return the form for editing the specified Subpage.
     *
     * @param string $url  url of the specified Subpage to be editted
     * @return array|string view of the edition form as rendered html page as string
     * @throws \Throwable
     */
    public function edit(string $url)
    {
        $this->forget('errors');

        $subpages = collect();
        foreach (Language::all() as $language) {
            foreach (Session::get('subpages-' . $language->id) as &$sub) {
                if ($sub->url == $url) {
                    $subpages[] = $sub;
                }
            }
        }
        Session::reflash();
        //return to the previous page with the old input
        return view('admin.navigation.subpages.edit', ['subpages' => $subpages,
            'url' => \request()->get('url'),
            'order' => \request()->get('order'),
            'is_public' => \request()->get('public'),
            'name' => [1 => \request()->get('name-1'), 2 => \request()->get('name-2')]])
            ->render();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request request containing all the data from edition form + the edition form for Page
     * @param string $url  url of the specified Subpage to be editted
     * @return RedirectResponse  redirect back to Page creation page
     */
    public function update(UpdateRequest $request, string $url)
    {
        $this->forget('errors');

        foreach (Language::all() as $language) {
            foreach (Session::get('subpages-' . $language->id, collect()) as &$sub) {
                if ($sub->url == $url) {
//                    $sub->order = $request->get('sub_order');
                    $sub->name = $request->get('sub_name-' . $sub->language->id);
                    $sub->public = $request->get('sub_public', false) ? 1 : 0;
                    $sub->text->content = $request->get('sub_text_content-' . $sub->language->id);
                    $sub->text->title = $sub->name;
                }
            }
        }
        Session::reflash();
        //return to the previous page with the old input
        return redirect()->back()->with(['is_dropdown' => true])
            ->withInput($request->only('url', 'order', 'is_public', 'name-1', 'name-2'));
    }

    /**
     * Remove the specified Subpage from Session.
     *
     * @param string $url  url of the specified Subpage to be editted
     */
    public function destroy(string $url)
    {
        $this->forget('errors');

        foreach (Language::all() as $language) {
            $subs = Session::get('subpages-' . $language->id);
            if (($index = array_search($url, $subs->pluck('url')->toArray())) !== false) {
                if (count($subs) != 1) {
                    foreach ($subs as $sub) {
                        if ($sub->order > $subs[$index]->order) {
                            $sub->order -= 1;
                        }
                    }
                    unset($subs[$index]);
                } else {
                    $subs->pop();
                }
            }
//                    Session::flash('subpages-' . $language->id, $subs);

        }
        Session::reflash();
    }

    /**
     * Handling the AJAX call from reordering the navpages.
     * Changing the order of all affected pages
     */
    public function reorder()
    {
        $url = $_POST['url'];
        $oldIndex = $_POST['oldIndex'];
        $newIndex = $_POST['newIndex'];
        $this->reorderNavigation($url, $oldIndex + 1, $newIndex + 1);
//            flash('Navigations were successfully reordered')->success();
//        } else {
//            flash('Navigations were not reordered')->error();
//
//        }
        Session::reflash();
    }

    /**
     * Changing the order of all the affected pages in the Sessions
     *
     * @param $url string  url of the specified subpages to be reordered
     * @param $oldIndex int  old value of index
     * @param $newIndex int  new value of index
     * @return bool true if the reordering was successful, false otherwise
     */
    private function reorderNavigation($url, $oldIndex, $newIndex)
    {
        foreach (Language::all() as $language) {
            foreach (Session::get('subpages-' . $language->id, collect()) as &$sub) {
                if ($sub->url == $url) {
                    if ($sub->order != $oldIndex)
                        return false;
                    $sub->order = $newIndex;
                } else if ($sub->order < $oldIndex && $sub->order >= $newIndex) {
                    $sub->order += 1;
                } else if ($sub->order > $oldIndex && $sub->order <= $newIndex) {
                    $sub->order -= 1;
                }
            }
        }
        return true;

    }
}
