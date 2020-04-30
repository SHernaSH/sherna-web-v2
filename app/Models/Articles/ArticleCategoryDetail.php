<?php

namespace App\Models\Articles;


use App\Models\Extensions\LanguageModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Articles\ArticleCategoryDetail
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $language_id
 * @property string|null $deleted_at
 * @property-read \App\Models\Articles\ArticleCategory $category
 * @property-read \App\Models\Language\Language $language
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleCategoryDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleCategoryDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extensions\LanguageModel ofLang(\App\Models\Language\Language $lang)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleCategoryDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleCategoryDetail whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleCategoryDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleCategoryDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleCategoryDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleCategoryDetail whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleCategoryDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleCategoryDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ArticleCategoryDetail extends LanguageModel
{
    protected $table = 'article_categories_details';

    /**
     * Category for which is this name associated
     *
     * @return BelongsTo category
     */
    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }
}
