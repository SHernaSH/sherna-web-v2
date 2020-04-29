<?php

namespace App\Models\Reservations;

use App\Mail\OnKeyAdmin;
use App\Mail\VRRequest;
use App\Models\Locations\Location;
use \App\Models\Users\User;
use App\Notifications\OnKeyReservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Reservation extends Model
{

    use SoftDeletes;

    protected $dates = ['start_at', 'end_at', 'entered_at'];

    //

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            if ($item->vr) {
//                $item->user->notify(new OnKeyReservation($item->user, $item));
                Mail::to(env('MAIL_TO'))->send(new VRRequest($item->user, $item));
            }

            if (Str::contains(strtolower($item->location->name), 'key') ||
                Str::contains(strtolower($item->location->name), 'kluc')) {
                $item->user->notify(new OnKeyReservation($item->user, $item));
                Mail::to(env('MAIL_TO'))->send(new OnKeyAdmin($item->user, $item));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function duration()
    {

        return $this->end_at->floatDiffInHours($this->start_at);
    }

    public function scopeActiveReservation($query)
    {
        return $query->where(function ($q) {
            $q->where('start_at', '<=', date('Y-m-d H:i:s'))->where('end_at', '>=', date('Y-m-d H:i:s'));
        });
    }

    public function scopeFutureReservations($query)
    {
        return $query->where(function ($q) {
            $q->where('start_at', '>=', date('Y-m-d H:i:s'));
        });
    }

    public function scopeFutureActiveReservations($query)
    {
        return $query->where(function ($q) {
            $q->where('start_at', '>=', date('Y-m-d H:i:s'))->orWhere(function ($q) {
                $q->where('start_at', '<=', date('Y-m-d H:i:s'))->where('end_at', '>=', date('Y-m-d H:i:s'));
            });
        });
    }
}
