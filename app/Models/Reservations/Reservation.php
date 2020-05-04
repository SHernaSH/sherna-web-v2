<?php

namespace App\Models\Reservations;

use App\Mail\OnKeyAdmin;
use App\Mail\VRRequest;
use App\Models\Locations\Location;
use \App\Models\Users\User;
use App\Notifications\OnKeyReservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * App\Models\Reservations\Reservation
 *
 * @property int $id
 * @property int $location_id
 * @property string $user_id
 * @property int|null $visitors_count
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon $end_at
 * @property \Illuminate\Support\Carbon|null $entered_at
 * @property int $vr
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Locations\Location $location
 * @property-read \App\Models\Users\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation activeReservation()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation futureActiveReservations()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation futureReservations()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Reservations\Reservation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation whereEnteredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation whereVisitorsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservations\Reservation whereVr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Reservations\Reservation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Reservations\Reservation withoutTrashed()
 * @mixin \Eloquent
 */
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

    /**
     * User that is associated with the reservation
     *
     * @return BelongsTo User associated with the reservation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Location where is the reservation situated
     *
     * @return BelongsTo Location where is the reservation situated
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    /**
     * Get the duration of the reservation
     *
     * @return float the duration of the reservation
     */
    public function duration()
    {

        return $this->end_at->floatDiffInHours($this->start_at);
    }

    public function isActive() {
        return !isset($this->deleted_at) && $this->end_at->isAfter(Carbon::now()) && $this->start_at->isBefore(Carbon::now());
    }

    public function isFuture() {
        return !isset($this->deleted_at) && $this->start_at->isAfter(Carbon::now());
    }

    /**
     * Show only active reservations
     *
     * @param $query
     * @return mixed
     */
    public function scopeActiveReservation($query)
    {
        return $query->where(function ($q) {
            $q->where('start_at', '<=', date('Y-m-d H:i:s'))->where('end_at', '>=', date('Y-m-d H:i:s'));
        });
    }

    /**
     * Show only future reservations
     *
     * @param $query
     * @return mixed
     */
    public function scopeFutureReservations($query)
    {
        return $query->where(function ($q) {
            $q->where('start_at', '>=', date('Y-m-d H:i:s'));
        });
    }

    /**
     * Show only future or active reservations
     *
     * @param $query
     * @return mixed
     */
    public function scopeFutureActiveReservations($query)
    {
        return $query->where(function ($q) {
            $q->where('start_at', '>=', date('Y-m-d H:i:s'))->orWhere(function ($q) {
                $q->where('start_at', '<=', date('Y-m-d H:i:s'))->where('end_at', '>=', date('Y-m-d H:i:s'));
            });
        });
    }
}
