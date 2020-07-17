<?php

namespace App\Http\Middleware;

use App\Models\Language\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;


class LanguageMiddleware
{
    /**
     * Set localization
     * If language is not set, set it to default from config (cz)
     * otherwise set app language to set language
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $lang = Language::where('code', Session::get('lang'))->first();
        if (isset($lang)) {
            App::setLocale($lang->code);
        } else {
            Session::put('lang', Config::get('app.locale'));
        }

        return $next($request);
    }
}
