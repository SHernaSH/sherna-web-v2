<?php

namespace App\Models\Members;

use Illuminate\Database\Eloquent\Model;

class Active extends Model
{
    public function member() {
        $this->belongsTo(Member::class, 'members_id', 'id');
    }
}
