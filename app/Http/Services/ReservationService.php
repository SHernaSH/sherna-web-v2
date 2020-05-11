<?php


namespace App\Http\Services;

use App\Http\Requests\Reservations\StoreRequest;
use App\Http\Requests\Reservations\UpdateRequest;
use App\Models\Locations\Location;
use App\Models\Permissions\Permission;
use App\Models\Reservations\Reservation;
use App\Models\Settings\Setting;
use \App\Models\Users\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;

class ReservationService
{

    /**
     * Get all the future or active reservations paginated
     *
     * @param int $perPage number of reservations shown per page
     * @return Collection active or future reservations
     */
    public function getReservation(int $perPage = 15)
    {
        return Reservation::orderBy('start_at', 'desc')->paginate($perPage);
    }

    /**
     * Get all the reservations - even cancelled - paginated
     *
     * @param int $perPage number of reservations shown per page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator all the reservations
     */
    public function getAllReservation(int $perPage = 15)
    {
        return Reservation::withTrashed()->orderBy('start_at', 'desc')->paginate($perPage);
    }

    /**
     * Create a new reservation if it contains valid data
     *
     * @param $request StoreRequest     request with all the data from creation form
     * @param $user User    actually logged in user
     * @return bool|string  return true if successful, error message otherwise
     */
    public function makeReservation(StoreRequest $request, $user)
    {
        $userToReservate = User::find($request->get('tenant_uid'));
        $reservation = $this->createReservation($request, $userToReservate ?? $user );
        $validation = $this->validate($user, $reservation);
        if (!is_string($validation)) {
            $reservation->save();
        } else {
            return $validation;
        }
        return true;
    }

    /**
     * Update already existing specified reservation, if it contains valid data
     *
     * @param UpdateRequest $request     request with all the data from creation form
     * @param Reservation $reservation specified reservation to be updated
     * @param $user User    actually logged in user
     * @return bool|string  return true if successful, error message otherwise
     */
    public function updateReservation(UpdateRequest $request, Reservation $reservation, User $user)
    {
        $this->update($request, $reservation);
        $validation = $this->validate($user, $reservation, true);
        if (!is_string($validation)) {
            $reservation->save();
        } else {
            return $validation;
        }
        return true;
    }

    /**
     * Delete already existing specified reservation, if the user has the rights to do so
     *
     * @param Reservation $reservation specified reservation to be deleted
     * @param $user User    actually logged in user
     * @return bool|string  return true if successful, error message otherwise
     */
    public function deleteReservation(Reservation $reservation, User $user)
    {
        if (($user->role->hasPermissionByName('Reservation Manager')
                || $user->id == $reservation->user->id) && $reservation->end_at->isAfter(Carbon::now())) {
            $reservation->delete();
        } else {
            return false;
        }
        return true;
    }

    private function createReservation($request, User $user)
    {
        $reservation = new Reservation();
        $reservation->user()->associate($user);
        $this->update($request, $reservation);
        return $reservation;
    }

    private function update($request, Reservation $reservation)
    {
        $location = Location::where('id', $request->get('location_id'))->firstOrFail();
        $reservation->location()->associate($location);
        $reservation->visitors_count = $request->get('visitors_count', 1);
        $reservation->start_at = Carbon::createFromFormat('d.m.Y H:i', $request->get('from_date'));
        $reservation->end_at = Carbon::createFromFormat('d.m.Y H:i', $request->get('to_date'));
        $reservation->vr = $request->get('vr', false) ? 1 : 0;
        $reservation->note = $request->get('note');
        return $reservation;
    }

    private function validate(User $user, Reservation $reservation, $update = false)
    {
        $permission = Permission::where('name', 'Reservation Manager')->firstOrFail();
        if ($user->role->hasPermission($permission)) {
            return $this->validateForAdmin($reservation, $update);
        } else {
            return $update ? $this->validateUpdate($user, $reservation) : $this->validateForUser($user, $reservation);
        }
    }

    private function validateForAdmin(Reservation $reservation, $update = false)
    {
        if ($reservation->end_at->isBefore($reservation->start_at)) {
            return trans('reservations.too_short');
        } else if ($this->overlap($reservation) > 0) {
            return trans('reservations.overlap');
        } else if ($reservation->visitors_count < 0) {
            return trans('reservations.minimal_visitor');
        } else if (!$update &&  $reservation->start_at->isBefore(Carbon::now()->setSeconds(0)
            ->addMinutes(Setting::where('name', 'Time for edit')->first()->value))) {
            return trans('reservations.in_past');
        } else if($update && $reservation->getOriginal('end_at')->isBefore(Carbon::now())) {
            return trans('reservations.late_update');
        }
        return true;
    }

    /**
     * Check if there are already existing reservations for the specified time and location
     *
     * @param Reservation $reservation
     * @return bool
     */
    private function overlap(Reservation $reservation)
    {
        $start = $reservation->start_at;
        $end = $reservation->end_at;
        $rangeCount = Reservation::where('location_id', $reservation->location_id)
            ->where('id', '!=', $reservation->id)
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($query) use ($start, $end) {
                    $query->where('start_at', '<=', $start)
                        ->where('end_at', '>', $start);
                })->orWhere(function ($query) use ($start, $end) {
                    $query->where('start_at', '<', $end)
                        ->where('end_at', '>=', $end);
                })->orWhere(function ($query) use ($start, $end) {
                    $query->where('start_at', '>=', $start)
                        ->where('end_at', '<=', $end);
                })->orWhere(function ($query) use ($start, $end) {
                    $query->where('start_at', '<=', $start)
                        ->where('end_at', '>=', $end);
                });
            })->count();
        if ($rangeCount > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function validateUpdate(User $user, Reservation $reservation)
    {

        $validation = $this->validateForUser($user, $reservation, true);
        if (is_string($validation)) {
            return $validation;
        }
        $maxDuration = Setting::where('name', 'Maximal Duration')->first()->value;
        if ($reservation->getOriginal('start_at')->isPast()) {
            if ($reservation->start_at != $reservation->getOriginal('start_at')) {
                return trans('reservations.change_start');
            }
            if ($reservation->getOriginal('end_at')->isBefore(Carbon::now())) {
                return trans('reservations.late_update');
            }
            if ($reservation->location_id != $reservation->getOriginal('location_id')) {
                return trans('reservations.change_location');
            }
            $timeForEdit = $reservation->getOriginal('end_at')
                ->addMinutes((-1) * Setting::where('name', 'Time for edit')->first()->value);
            if($timeForEdit->isAfter(Carbon::now())) {
                return trans('reservations.early_update');
            } else if( $reservation->end_at->floatDiffInHours($reservation->getOriginal('end_at')) > $maxDuration) {
                return trans('reservations.too_long');
            }
        } else if($reservation->duration() > $maxDuration) {
            return trans('reservations.too_long');
        }
        return true;
    }

    private function validateForUser($user, Reservation $reservation, $update = false)
    {
        $maxDuration = Setting::where('name', 'Maximal Duration')->first()->value;
        $maxReservations = $update ? 1 : 0;
        if ($user->reservations()->futureActiveReservations()->count() > $maxReservations) {
            return trans('reservations.too_many');
        } else if (!$update && $reservation->duration() > $maxDuration) {
            return trans('reservations.too_long');
        }
        else if ($reservation->start_at->isAfter(Carbon::now()->addDays(Setting::where('name', 'Reservation Area')->first()->value))) {
            return trans('reservations.too_far');
        } else if (!$reservation->location->status->opened) {
            return trans('reservations.closed');
        } else if($user->banned) {
            return trans('general.ban');
        } else if ($reservation->vr) {
            $permission = Permission::where('name', 'VR');
            if (!$user->role->hasPermission($permission))
                return trans('reservations.vr');
        } else {
            return $this->validateForAdmin($reservation, $update);
        }
        return true;
    }


}
