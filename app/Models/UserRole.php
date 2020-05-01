<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRole extends Pivot
{
    //
    /**
     * Pole atributů, které nejsou zobrazovány při výpisu.
     *
     * @var array
     */
    protected $hidden = [];


}
