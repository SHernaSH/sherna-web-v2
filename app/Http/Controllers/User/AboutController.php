<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Nav\SubPage;
use App\Nav\SubPageText;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Show the about page that was requested
     *
     * @param string $url   part of url with the name of requested page
     * @return Factory|View requested view
     */
    public function show(string $url)
    {
        //TODO IF about pages contains $url
        $content = $this->getContent($url);
        if(!isset($content)) {
            abort(404);
        }
//        $content = SubPageText::where('nav_subpage_id',$subpage->id)->first();
        return view('about.index')->with('page', $content);
    }

    private function getContent($url) {
        return SubPage::where('url',$url)
            ->join('nav_subpages_text', function ($join) {
                $join->on('nav_subpages.id', '=', 'nav_subpages_text.nav_subpage_id');
                $join->on('nav_subpages.language_id', '=', 'nav_subpages_text.language_id');
            })
            ->select('nav_subpages_text.*')
            ->first();
    }
}
