<?php

namespace App\Models\Navigation;


use App\Models\Extensions\LanguageModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Navigation\SubPageText
 *
 * @property int $id
 * @property int $nav_subpage_id
 * @property string $title
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $language_id
 * @property-read \App\Models\Language\Language $language
 * @property-read \App\Models\Navigation\SubPage $page
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPageText newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPageText newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extensions\LanguageModel ofLang(\App\Models\Language\Language $lang)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPageText query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPageText whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPageText whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPageText whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPageText whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPageText whereNavSubpageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPageText whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation\SubPageText whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SubPageText extends LanguageModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nav_subpages_texts';

    /**
     * SupPage to which text belongs
     *
     * @return BelongsTo SubPage
     */
    public function page()
    {
        return $this->belongsTo(SubPage::class, 'nav_subpage_id', 'id');
    }


    public function getRouteKeyName()
    {
        return 'url';
    }

}
