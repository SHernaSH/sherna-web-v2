<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateRequest;
use App\Models\Settings\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 * Class handling the viewing and updating of Setting model
 *
 * Class SettingController
 * @package App\Http\Controllers\Admin
 */
class SettingController extends Controller
{
    /**
     * Display a listing of the settings.
     *
     * @return View return view showing all the settings
     */
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.index', ['settings' => $settings]);
    }


    /**
     * Update the all the Settings in storage.
     *
     * @param UpdateRequest $request  request containing all the data for the update
     * @return RedirectResponse redirect to index page
     */
    public function update(UpdateRequest $request)
    {
        foreach (Setting::all() as $setting) {
            $setting->value = $request->get('value-' . $setting->id);
            $setting->save();
        }
        flash('Settings successfully updated')->success();

        return redirect()->route('settings.index');
    }

}
