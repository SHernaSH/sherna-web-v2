<?php

namespace App\Models\Articles;

use App\Models\Extensions\LanguageModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Articles\ArticleText
 *
 * @property int $id
 * @property int $article_id
 * @property string $title
 * @property string $description
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $language_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Language\Language $language
 * @property-read \App\Models\Articles\Article $page
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleText newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleText newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extensions\LanguageModel ofLang(\App\Models\Language\Language $lang)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Articles\ArticleText onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleText query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleText whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleText whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleText whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleText whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleText whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleText whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleText whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleText whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\ArticleText whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Articles\ArticleText withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Articles\ArticleText withoutTrashed()
 * @mixin \Eloquent
 */
class ArticleText extends LanguageModel
{
    use SoftDeletes;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles_texts';

    /**
     * Page associated with this text
     *
     * @return BelongsTo Page associated with this text
     */
    public function page()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
