<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Language\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

/**
 *
 * Class handling the language change
 *
 * Class LanguageController
 * @package App\Http\Controllers\User
 */
class LanguageController extends Controller
{
    /**
     * Change the language of the app and set
     *
     * @param string $code code of the chosen language
     * @return RedirectResponse redirect back to previous page
     */
    public function __invoke($code)
    {
        $lang = $this->getLanguage($code);
        if (!isset($lang)) {
            abort(404);
        }
        Session::put('lang', $lang->code);
        return redirect()->back();
    }

    /**
     * @param string $code of the chosen language
     * @return Language|null returns model of Language with corresponding code, or null if it cannot find one
     */
    private function getLanguage($code)
    {
        return Language::where('code', $code)->first();
    }
}
