<?php


namespace App\Http\Scopes;

use App\Models\Language\Language;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

/**
 * Class LanguageScope that adds localization to a model
 * Every query will select the right language version from the database
 * @package App\Http\Scopes
 */
class LanguageScope implements Scope
{
    /**
     * @inheritDoc
     */
    public function apply(Builder $builder, Model $model)
    {
        $lang = Language::where('code', Session::get("lang", Config::get('app.locale')))->first();
        $builder->where($model->getTable() . '.language_id', $lang->id);
    }
}
