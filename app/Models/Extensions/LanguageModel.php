<?php


namespace App\Models\Extensions;

use App\Http\Scopes\LanguageScope;
use App\Models\Language\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Extensions\LanguageModel
 *
 * Class that represents models which have to have translation. Adding global scope to them, which makes sure
 * all the result will be with the correct current language
 *
 * @property-read \App\Models\Language\Language $language
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extensions\LanguageModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extensions\LanguageModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extensions\LanguageModel ofLang(\App\Models\Language\Language $lang)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extensions\LanguageModel query()
 * @mixin \Eloquent
 */
class LanguageModel extends Model
{

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new LanguageScope());
    }

    /**
     * Language to which this model belongs
     *
     * @return BelongsTo Language to which this model belongs
     */
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    /**
     * Scope that enables to select the result of any language
     *
     * @param $query
     * @param Language $lang
     * @return mixed
     */
    public function scopeOfLang($query, Language $lang)
    {
        return $query->where('language_id', $lang->id)
            ->withoutGlobalScope(LanguageScope::class);
    }
}
