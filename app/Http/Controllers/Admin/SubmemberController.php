<?php

namespace App\Http\Controllers\Admin;

use App\Models\Members\Active;
use App\Http\Controllers\Controller;
use App\Http\Requests\Member\Active\StoreRequest;
use App\Http\Requests\Member\Active\UpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

/**
 * Class handling the CRUD operation of Supbage and Subpage Text models
 * Models are sotred in Sessions, not in DB, until the parent Page is stored
 * Subpages are stored per language
 *
 * Class SubpageController
 * @package App\Http\Controllers\Admin
 */
class SubmemberController extends Controller
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
    public function public(string $id)
    {
        $this->forget('errors');
        foreach (Session::get('actives', collect()) as &$sub) {
            if ($sub->id == $id) {
                $sub->public = !$sub->public;
            }
        }
        Session::reflash();
        return redirect()->back()->withInput();
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
        return view('admin.members.active.create', [
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
        if (!$request->file('file')->isValid()) {
            flash('Uploaded file is not valid!')->error();
            return redirect()->back()
                ->withInput($request->only('name-1', 'name-2', 'is_public'));
        }
        $actives = Session::get('actives', collect());
        foreach($actives as $ac) {
            $next_order = max($ac->order, $next_order);
        }
        $next_order++;
        $active = new Active();
        $active->order = $next_order;
        $active->id = $next_order;
        $active->name = $request->get('sub_name');
        $active->nickname = $request->get('sub_nickname');
        $active->room = $request->get('sub_room');
        $active->email = $request->get('sub_email');
        $active->public = $request->get('sub_public', false) ? 1 : 0;

        $request->file('file')->move(public_path('docs/members/'),
            $request->file('file')->getClientOriginalName());
        $active->img = $request->file('file')->getClientOriginalName();

        $actives[] = $active;

        Session::flash('actives', $actives);
        $this->forget('_old_input');
        Session::reflash();
        return redirect()->back()
            ->withInput($request->only('name-1', 'name-2', 'is_public'));

    }

    /**
     * Return the form for editing the specified Subpage.
     *
     * @param string $id  url of the specified Subpage to be editted
     * @return array|string view of the edition form as rendered html page as string
     * @throws \Throwable
     */
    public function edit(string $id)
    {
        $this->forget('errors');
        $active = null;
        foreach (Session::get('actives') as $sub) {
            if ($sub->id == $id) {
                $active = $sub;
            }
        }
        if($active == null) {
            flash('Cannot edit this member role')->error();
            redirect()->back();
        }
        Session::reflash();
        $this->forget('_old_input');
        //return to the previous page with the old input
        return view('admin.members.active.edit', ['active' => $active,
            'is_public' => \request()->get('is_public'),
            'name' => [1 => \request()->get('name-1'), 2 => \request()->get('name-2')]
        ])->render();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request request containing all the data from edition form + the edition form for Page
     * @param string $url  url of the specified Subpage to be editted
     * @return RedirectResponse  redirect back to Page creation page
     */
    public function update(UpdateRequest $request, string $id)
    {
        $this->forget('errors');
        foreach (Session::get('actives', collect()) as &$active) {
            if ($active->id == $id) {
                $active->name = $request->get('sub_name');
                $active->nickname = $request->get('sub_nickname');
                $active->email = $request->get('sub_email');
                $active->room = $request->get('sub_room');
                $active->public = $request->get('sub_public', false) ? 1 : 0;
                if($request->file('file')) {
                    $request->file('file')->move(public_path('docs/members/'),
                        $request->file('file')->getClientOriginalName());
                    $active->img = $request->file('file')->getClientOriginalName();
                }
            }
        }

        Session::reflash();
        $this->forget('_old_input');
        //return to the previous page with the old input
        return redirect()->back()
            ->withInput($request->only( 'name-1', 'name-2', 'is_public'));
    }

    /**
     * Remove the specified Subpage from Session.
     *
     * @param string $url  url of the specified Subpage to be editted
     */
    public function destroy(string $id)
    {
        $this->forget('errors');
        $subs = Session::get('actives');
        if (($index = array_search($id, $subs->pluck('id')->toArray())) !== false) {
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


        Session::reflash();
    }

    /**
     * Handling the AJAX call from reordering the navpages.
     * Changing the order of all affected pages
     */
    public function reorder()
    {
        $id = $_POST['url'];
        $oldIndex = $_POST['oldIndex'];
        $newIndex = $_POST['newIndex'];
        $this->reorderNavigation($id, $oldIndex + 1, $newIndex + 1);
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
    private function reorderNavigation($email, $oldIndex, $newIndex)
    {
        foreach (Session::get('actives', collect()) as &$sub) {
            if ($sub->email == $email) {
                if ($sub->order != $oldIndex)
                    return false;
                $sub->order = $newIndex;
            } else if ($sub->order < $oldIndex && $sub->order >= $newIndex) {
                $sub->order += 1;
            } else if ($sub->order > $oldIndex && $sub->order <= $newIndex) {
                $sub->order -= 1;
            }
        }

        return true;

    }
}
