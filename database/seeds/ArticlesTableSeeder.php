<?php

use App\Models\Articles\Article;
use App\Models\Articles\ArticleCategory;
use App\Models\Articles\ArticleCategoryDetail;
use App\Models\Articles\ArticleText;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::updateOrInsert([
            'id' => 1,
            'user_id' => 30542,
            'url' => 'uvod',
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            ]);

        ArticleText::updateOrInsert([
            'id' => 1,
            'article_id' => 1,
            'title' => 'Uvod',
            'description' => 'Uvodna stranka',
            'content' => '<p>Vítejte na našem webu!</p><p>Tento web je postaven na <strong>jednoduchém redakčním
systému v Laravel frameworku</strong>. Toto je úvodní článek, načtený z databáze.</p>',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'language_id' => 1,
        ]);
        ArticleText::updateOrInsert([
            'id' => 2,
            'article_id' => 1,
            'title' => 'Welcome',
            'description' => 'Welcome page',
            'content' => '<p>Welcome</p><p>Tento web je postaven na <strong>jednoduchém redakčním
systému v Laravel frameworku</strong>. Toto je úvodní článek, načtený z databáze.</p>',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'language_id' => 2,
        ]);

        ArticleCategory::updateOrInsert([
            'id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        ArticleCategoryDetail::updateOrInsert([
            'id' => 1,
            'category_id' => 1,
            'name' => 'Hry',
            'language_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        ArticleCategoryDetail::updateOrInsert([
            'id' => 2,
            'category_id' => 1,
            'name' => 'Games',
            'language_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $article = Article::first();
        $category = ArticleCategory::first();
        $article->categories()->attach($category);
        $article->save();
//
//        \App\ArticleText::updateOrInsert([
//            'id' => 1,
//            'article_id' => 1,
//            'title' => 'Uvod',
//            'description' => 'Uvodna stranka',
//            'content' => '<p>Vítejte na našem webu!</p><p>Tento web je postaven na <strong>jednoduchém redakčním
//systému v Laravel frameworku</strong>. Toto je úvodní článek, načtený z databáze.</p>',
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//            'language_id' => 1,
//        ]);
//        \App\ArticleText::updateOrInsert([
//            'id' => 2,
//            'article_id' => 1,
//            'title' => 'Welcome',
//            'description' => 'Welcome page',
//            'content' => '<p>Welcome</p><p>Tento web je postaven na <strong>jednoduchém redakčním
//systému v Laravel frameworku</strong>. Toto je úvodní článek, načtený z databáze.</p>',
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//            'language_id' => 2,
//        ]);
    }
}
