<?php

namespace App\Models\Navigation;


use App\Models\Extensions\LanguageModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Navigation\PageText
 *
 * @property int $id
 * @property int $nav_page_id
 * @property string $title
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $language_id
 * @property-read \App\Models\Language\Language $language
 * @property-read \App\Models\Navigation\Page $page
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\PageText newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\PageText newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extensions\LanguageModel ofLang(\App\Models\Language\Language $lang)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\PageText query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\PageText whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\PageText whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\PageText whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\PageText whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\PageText whereNavPageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\PageText whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\PageText whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PageText extends LanguageModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nav_pages_texts';

    /**
     * Navigation Page to which text belongs
     *
     * @return BelongsTo page
     */
    public function page()
    {
        return $this->belongsTo(Page::class, 'nav_page_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'url';
    }

}
