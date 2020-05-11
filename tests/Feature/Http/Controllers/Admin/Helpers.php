<?php


namespace Tests\Feature\Http\Controllers\Admin;


use App\Models\Articles\Article;
use App\Models\Articles\ArticleCategory;
use App\Models\Articles\ArticleCategoryDetail;
use App\Models\Articles\ArticleText;
use App\Models\Inventory\InventoryCategory;
use App\Models\Inventory\InventoryItem;
use App\Models\Locations\Location;
use App\Models\Locations\LocationStatus;
use App\Models\Navigation\Page;
use App\Models\Navigation\PageText;

class Helpers
{
    public static function createArticleCategory()
    {
        $category = ArticleCategory::find(factory(ArticleCategoryDetail::class)->create()->category_id);
        $detail = factory(ArticleCategoryDetail::class)->make();
        $detail->category_id = $category->id;
        $detail->language_id = 2;
        $detail->save();
        return $category;
    }

    public static function createInventoryCategory()
    {
        $category = factory(InventoryCategory::class)->create();
        $category2 = factory(InventoryCategory::class)->make();
        $category2->id = $category->id;
        $category2->language_id = 2;
        $category2->save();
        return $category;
    }

    public static function createInventoryItem()
    {
        $item = factory(InventoryItem::class)->create();
        $item2 = factory(InventoryItem::class)->make();
        $item2->id = $item->id;
        $item2->language_id = 2;
        $item2->location->id = $item->location->id;
        $item2->location->language_id = 2;
        $item2->location->save();
        $item2->save();
        return $item;
    }

    public static function createLocation()
    {
        $location = factory(Location::class)->create();
        $location2 = factory(Location::class)->make();
        $location2->id = $location->id;
        $location2->language_id = 2;
        $location2->status->id = $location->status->id;
        $location2->status->language_id = 2;
        $location2->status->save();
        $location2->save();
        return $location;
    }

    public static function createLocationStatus()
    {
        $status = factory(LocationStatus::class)->create();
        $status2 = factory(LocationStatus::class)->make();
        $status2->id = $status->id;
        $status2->language_id = 2;
        $status2->save();
        return $status;
    }

    public static function createArticle()
    {
        $article = Article::find(factory(ArticleText::class)->create()->article_id);
        $text = factory(ArticleText::class)->make();
        $text->language_id = 2;
        $text->page()->associate($article);
        $text->save();
        return $article;
    }

    public static function createPage() {
        $page = factory(PageText::class)->create()->page;
        $page->special_code = null;
        $page->dropdown = false;
        $page->public = 1;
        $page->save();
        $pageText = factory(PageText::class)->make();
        $pageText->language_id = 2;
        $page2 = new Page();
        $pageText->page->delete();
        $page2->id = $page->id;
        $page2->url = $page->url;
        $page2->name = $page->name;
        $page2->public = $page->public;
        $page2->language_id = 2;
        $page2->special_code = null;
        $page2->dropdown = false;
        $page2->order = $page->order;
        $page2->save();
        $pageText->page()->associate($page2);
        $pageText->save();
        return $page;
    }
}
