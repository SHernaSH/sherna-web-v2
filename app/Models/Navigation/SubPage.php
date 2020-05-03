<?php

namespace App\Models\Navigation;

use App\Http\Traits\CompositePrimaryKeyTrait;
use App\Models\Extensions\LanguageModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Navigation\SubPage
 *
 * @property int $id
 * @property int $nav_page_id
 * @property int $order
 * @property int $public
 * @property string $url
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $language_id
 * @property-read \App\Models\Language\Language $language
 * @property-read \App\Models\Navigation\Page $page
 * @property \App\Models\Navigation\SubPageText $text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extensions\LanguageModel ofLang(\App\Models\Language\Language $lang)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPage public()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPage whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPage whereNavPageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPage whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPage wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPage whereUrl($value)
 * @mixin \Eloquent
 */
class SubPage extends LanguageModel
{

    use CompositePrimaryKeyTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nav_subpages';
    protected $primaryKey = ['id', 'language_id'];
    /**
     * @var SubPageText|null
     */

    /**
     * Text of the subpage page of the current language
     *
     * @return HasOne Text of the supbage page of the current language
     */
    public function text()
    {
        return $this->hasOne(SubPageText::class, 'nav_subpage_id', 'id');
    }


    /**
     * Navigation Page to which subpage belongs
     *
     * @return BelongsTo page
     */
    public function page()
    {
        return $this->belongsTo(Page::class, 'nav_page_id', 'id');
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

    public function getRouteKeyName()
    {
        return 'url';
    }

}
