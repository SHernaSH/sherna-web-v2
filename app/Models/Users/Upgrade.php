<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Upgrade extends Model
{
    protected $primaryKey = 'user_id';

    //
    public function user() {
        return $this->belongsTo(User::class);
    }
}
