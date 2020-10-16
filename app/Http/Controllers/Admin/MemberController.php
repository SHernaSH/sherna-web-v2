<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\StoreRequest;
use App\Http\Requests\Member\UpdateRequest;
use App\Http\Scopes\LanguageScope;
use App\Http\Services\PageService;
use App\Models\Members\Active;
use App\Models\Members\Member;
use App\Models\Language\Language;
use App\Models\Navigation\Page;
use Illuminate\Http\RedirectResponse;
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
class MemberController extends Controller
{

    /**
     * Display a listing of the navigation Pages
     *
     * @return View view with paginated pages
     */
    public function index()
    {
        $members = Member::orderBy('order')->paginate();
        return view('admin.members.index', ['members' => $members]);
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

        return view('admin.members.create');

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

        if($this->storeWhole($request)) {
            flash('Member role was created successfully')->success();
        } else {
            flash('Member role creation was unsuccessful')->error();
        }
        return redirect()->route('member.index');
    }

    /**
     * Making the specified navigation Page public/private
     *
     * @param int $id           id of the specified navigation Page
     * @return RedirectResponse redirect to index page
     */
    public function public(int $id)
    {
        if($this->setPagePublic($id)) {
            flash('Page public status changes succesfully')->success();
        } else {
            flash('Action unsuccessful')->error();
        }

        return redirect()->route('member.index');
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
        $member = Member::where('id', $id)->firstOrFail();

        $actives = $member->actives()->get();
        if (!Session::exists('actives')) {
            Session::flash('actives', $actives);
            Session::flash('member_id', $member->id);
        }

        if (Session::get('member_id') == $member->id) {
            Session::reflash();
        }
        return view('admin.members.edit', ['member' => $member]);
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
        $this->storeWhole($request, $id);

        return redirect()->route('member.index');
    }

    /**
     * Remove the specified Navigatio Page from storage.
     *
     * @param int $id             id of the specified navigation Page to be deleted
     * @return RedirectResponse   redirect to index page
     */
    public function destroy($id)
    {
        if ($this->deletePage($id)) {
            flash('Member role was successfully deleted.')->success();
        } else {
            flash('Member role deletion was unsuccessful.')->error();
        }

        Session::reflash();
        return redirect()->route('member.index');
    }

    /**
     * Handling the AJAX call from reordering the navpages.
     * Changing the order of all affected pages
     */
    public function reorder()
    {
        $id = $_POST['url'];
        $newIndex = $_POST['newIndex'];
        $members = Member::withoutGlobalScope(LanguageScope::class)->where('id', $id)->get();
        if($this->reorderNavigation($members, $newIndex + 1)) {
            flash('Navigations were successfully reordered')->success();
        } else {
            flash('Navigation reorder was unsuccessful')->error();
        }
    }

    /**
     * Changing the order of all the affected pages
     *
     * @param $members Member[]  all the pages
     * @param $newIndex int  new value of index
     */
    private function reorderNavigation($members, int $newIndex)
    {
        $oldIndex = $members[0]->order;
        DB::beginTransaction();

        try {
            foreach ($members as $page) {
                $page->order = $newIndex;
                $page->save();
            }
            foreach (Member::withoutGlobalScope(LanguageScope::class)->where('id', '!=', $members[0]->id)->get() as $page) {
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

    private function storeWhole($request, $id = null)
    {
        $next_id = DB::table('members')->max('id') + 1;
        $next_order = DB::table('members')->max('order') + 1;

        DB::beginTransaction();
        try {
            foreach (Language::all() as $lang) {
                if (isset($id)) {
                    $member = Member::where('id', $id)->ofLang($lang)->firstOrFail();
                } else {
                    $member = new Member();
                    $member->id = $next_id;
                    $member->order = $next_order;
                    $member->language()->associate($lang);
                }
                $member->name = $request->get('name-' . $lang->id);
                $member->save();
            }
            $this->storeActive($member);
            DB::commit();
            return true;
        } catch (\Exception $ex) {
            DB::rollBack();
            return false;
        }
    }
    private function storeActive(Member $member) {
        $actives = Session::get('actives');
        $origActives = $member->actives()->get();
        foreach ($origActives->diff($actives) as $toDelete) {
            $toDelete->delete();
        }
        $next_id = DB::table('actives')->max('id') + 1;
        if ($actives != null) {
            foreach ($actives as $active) {
//                $check = Active::where('members_id', $member->id)->first();
                if (!$active->exists) {
                    //$active->id = $check->id;
                //} else {
                    $active->id = $next_id;
                    $next_id++;
                }
                $active->members_id = $member->id;
                $active->save();
            }
        }
    }

    private function deletePage(int $id)
    {
        DB::beginTransaction();

        try {
            foreach (Language::all() as $lang) {
                $member = Member::where('id', $id)->ofLang($lang)->firstOrFail();
                $order = $member->order;
                $member->delete();

                foreach (Member::ofLang($lang)->get() as $pa) {
                    if ($pa->order > $order) {
                        $pa->order -= 1;
                        $pa->save();
                    }
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $ex) {
            DB::rollBack();
            return false;
        }
    }

    private function setPagePublic(int $id)
    {
        DB::beginTransaction();
        try {
            foreach (Language::all() as $language) {
                $page = Member::where('id', $id)->ofLang($language)->firstOrFail();
                $page->public = !$page->public;
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
