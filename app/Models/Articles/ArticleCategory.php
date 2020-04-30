<?php

namespace App\Models\Articles;


use App\Http\Scopes\LanguageScope;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Articles\ArticleCategory
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Articles\Article[] $articles
 * @property-read int|null $articles_count
 * @property-read \App\Models\Articles\ArticleCategoryDetail|null $detail
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Articles\ArticleCategoryDetail[] $details
 * @property-read int|null $details_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleCategory newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Articles\ArticleCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Articles\ArticleCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Articles\ArticleCategory withoutTrashed()
 * @mixin \Eloquent
 */
class ArticleCategory extends Model
{
    //
    use CascadeSoftDeletes, SoftDeletes;

    protected $cascadeDeletes = ['details'];


    /**
     * All articles associated with the category
     *
     * @return BelongsToMany All articles associated with the category
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_category', 'category_id', 'article_id');
    }

    /**
     * Name of the category in current language
     *
     * @return HasOne  Name of the category in current language
     */
    public function detail()
    {
        return $this->hasOne(ArticleCategoryDetail::class, 'category_id');
    }

    /**
     * Names of the category in all languages
     *
     * @return HasMany Names of the category in all languages
     */
    public function details()
    {
        return $this->hasMany(ArticleCategoryDetail::class, 'category_id')
            ->withoutGlobalScope(LanguageScope::class);
    }
}
