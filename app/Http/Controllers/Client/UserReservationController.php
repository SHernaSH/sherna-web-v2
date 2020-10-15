<?php


namespace App\Http\Controllers\Client;


use App\Http\Services\ICS;
use App\Http\Services\ReservationService;
use App\Models\Reservations\Reservation;
use Illuminate\Support\Facades\Auth;

class UserReservationController
{

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function getReservations()
    {
        $user = Auth::user();
        $reservations = $user->reservations()->withTrashed()->orderBy('start_at', 'desc')->paginate(10);
        return view('client.user.reservations', ['reservations' => $reservations, 'user' => $user]);
    }
    public function getReservationICS( Reservation $reservation )
    {

        $ics = new ICS([
            'location' => $reservation->location->name,
            'description' => trans('reservations.reservation_for') . $reservation->user->name . ' ' . $reservation->user->surname,
            'dtstart' => date('Y-n-j g:iA', strtotime($reservation->start_at)),
            'dtend' => date('Y-n-j g:iA', strtotime($reservation->end_at)),
            'summary' => 'SHerna',
            'url' => route('user.reservations'),
        ]);

        return response($ics->to_string())->withHeaders([
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename=sherna_reservation.ics',
        ]);
    }

    public function delete(Reservation $reservation) {
        if ($this->reservationService->deleteReservation($reservation, Auth::user())) {
            flash(trans('reservations.success_deleted'))->success();
        } else {
            flash(trans('general.unsuccessful'))->error();
        }
        return redirect()->route('user.reservations');
    }
}
