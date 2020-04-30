<?php

namespace App\Models\Articles;

use App\Http\Scopes\LanguageScope;
use App\Models\Comments\Comment;
use \App\Models\Users\User;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Article
 *
 * @package App\Models\Articles
 * @property int $id
 * @property string $url
 * @property string $user_id
 * @property int $public
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Articles\ArticleCategory[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comments\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\Articles\ArticleText|null $text
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Articles\ArticleText[] $texts
 * @property-read int|null $texts_count
 * @property-read \App\Models\Users\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\Article newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Articles\Article onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\Article public()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\Article wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\Article whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Articles\Article whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Articles\Article withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Articles\Article withoutTrashed()
 * @mixin \Eloquent
 */
class Article extends Model
{

    use SoftDeletes, CascadeSoftDeletes;

    public $timestamps = true;
    /**
     * Pole vlastností, které nejsou chráněné před mass assignment útokem.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'url', 'description', 'content',
    ];
    protected $cascadeDeletes = ['texts', 'comments'];
    protected $dates = ['deleted_at'];

    /**
     * Morphmany relations with comments associated with article
     *
     * @return MorphMany Return all comments associated with article
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    /**
     * Has One relation using global LanguageScope
     * Every article has only one text of current language
     *
     * @return HasOne Article Text of the current language
     */
    public function text()
    {
        return $this->hasOne(ArticleText::class);
    }

    /**
     * Has Many relation
     * Query without global LanguageScope
     * Every article has text for every language
     *
     * @return HasMany Article Text of all languages
     */
    public function texts()
    {
        return $this->hasMany(ArticleText::class)
            ->withoutGlobalScope(LanguageScope::class);
    }

    /**
     * Categories to which the article belongs
     *
     * @return BelongsToMany all categories to which the article belogns
     */
    public function categories()
    {
        return $this->belongsToMany(ArticleCategory::class, 'article_category', 'article_id', 'category_id');

    }

    /**
     * Add public only to resulting query
     *
     * @param $query sqp query
     * @return mixed
     */
    public function scopePublic($query)
    {
        return $query->where(function ($q) {
            $q->where('public', true);
        });
    }

    /**
     * User which created the Article
     *
     * @return BelongsTo user which created this article
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'url';
    }
}
