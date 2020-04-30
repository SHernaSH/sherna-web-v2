<?php

namespace App\Models\Navigation;

use App\Http\Traits\CompositePrimaryKeyTrait;
use App\Models\Extensions\LanguageModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Navigation\Page
 *
 * @property int $id
 * @property string $url
 * @property string $name
 * @property int $order
 * @property int $public
 * @property int $dropdown
 * @property string|null $special_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $language_id
 * @property-read \App\Models\Language\Language $language
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Navigation\SubPage[] $subpages
 * @property-read int|null $subpages_count
 * @property-read \App\Models\Navigation\PageText|null $text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extensions\LanguageModel ofLang(\App\Models\Language\Language $lang)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\Page public()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\Page whereDropdown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\Page whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\Page whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\Page whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\Page wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\Page whereSpecialCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\Page whereUrl($value)
 * @mixin \Eloquent
 */
class Page extends LanguageModel
{

    use CompositePrimaryKeyTrait;
    public $timestamps = true;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nav_pages';
    protected $primaryKey = ['id', 'language_id'];

    /**
     * All the subpages that are associated with this navigation page
     *
     * @return HasMany All the subpages that are associated with this navigation page
     */
    public function subpages()
    {
        return $this->hasMany(SubPage::class, 'nav_page_id', 'id');
    }

    /**
     * Text of the navigation page of the current language
     *
     * @return HasOne Text of the navigation page of the current language
     */
    public function text()
    {
        return $this->hasOne(PageText::class, 'nav_page_id', 'id');
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
