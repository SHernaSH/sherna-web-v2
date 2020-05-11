<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Articles\Article;
use App\Models\Articles\ArticleCategory;
use App\Models\Navigation\Page;
use Illuminate\View\Factory;
use Illuminate\View\View;

/**
 * Class handling request to show blog articles and categories
 *
 * Class BlogController
 * @package App\Http\Controllers\User
 */
class BlogController extends Controller
{

    /**
     * Show the blog article requested
     *
     * @param string $url url  of the category
     * @return View requested article
     */
    public function show(string $url)
    {

//        $article = Article::where('url', $url)->public()->firstOrFail();
        $article = Article::where('url', $url)->firstOrFail();
        return view('client.blog.show', ['article' => $article]);
    }

    /**
     * Show all the public articles
     *
     * @return View return index page with all the articles
     */
    public function index()
    {
        if (!Page::where('special_code', 'blog')->firstOrFail()->public) {
            abort(404);
        }
        $articles = Article::latest()->public()->paginate();
        return view('client.blog.index', ['articles' => $articles]);
    }

    /**
     * Show all the categories, alongside their articles
     *
     * @return View return index view with all the categories and theirs articles
     */
    public function categories()
    {
        if (!Page::where('special_code', 'blog')->firstOrFail()->public) {
            abort(404);
        }
        $categories = ArticleCategory::paginate();
        return view('client.blog.categories', ['categories' => $categories]);
    }

}
