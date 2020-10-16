<?php

namespace App\Models\Members;

use App\Http\Traits\CompositePrimaryKeyTrait;
use App\Models\Extensions\LanguageModel;

class Member extends LanguageModel
{
    use CompositePrimaryKeyTrait;

    public $timestamps = true;

    protected $primaryKey = ['id', 'language_id'];

    public function actives() {
        return $this->hasMany(Active::class, 'members_id', 'id');
    }
}
