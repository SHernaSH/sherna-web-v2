<?php

namespace App\Models\Articles;

use App\Http\Scopes\LanguageScope;
use App\Models\Comments\Comment;
use \App\Models\Users\User;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    /**
     * Has One relation using global LanguageScope
     * Every article has only one text of current language
     *
     * @return HasOne
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
     * @return HasMany
     */
    public function texts()
    {
        return $this->hasMany(ArticleText::class)
            ->withoutGlobalScope(LanguageScope::class);
    }

    public function categories()
    {
        return $this->belongsToMany(ArticleCategory::class, 'article_category', 'article_id', 'category_id');

    }

    public function scopePublic($query)
    {
        return $query->where(function ($q) {
            $q->where('public', true);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'url';
    }
}
