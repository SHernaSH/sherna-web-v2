<?php

namespace App\Models\Events;

use App\Http\Services\ReservationService;
use App\Models\Locations\Location;
use App\Models\Reservations\Reservation;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use LaravelQRCode\Facade;

class Event extends Model
{
    use SoftDeletes;

    protected $dates = ['start_at', 'end_at'];

//    public function url() {
//        return $this->url
//    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            if($item->exists()) {
                return true;
            }
            $path = public_path() . '/qrcodes/';
            if(!File::exists($path)) {
                File::makeDirectory($path);
            }
            $path .= $item->salt . '.svg';

            file_put_contents( $path,$item->QRCode());
            return true;
        });

        static::deleting(function ($item) {
            $path = public_path() . '/grcodes/' . $item->salt . '.svg';
            File::delete($path);
        });
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
     * All the permissions this role contains
     *
     * @return BelongsToMany All the permissions this role contains
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function QRCode() {
        return \QrCode::size(200)->generate(route('event', ['salt' => urlencode($this->salt)]));
    }
}
