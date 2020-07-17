<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservations\StoreRequest;
use App\Http\Requests\Reservations\UpdateRequest;
use App\Http\Services\ReservationService;
use App\Models\Reservations\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class handling the CRUD operations on Reservation model, from administrative perspective
 * Using ReservationService
 *
 * Class ReservationController
 * @package App\Http\Controllers\Admin
 */
class ReservationController extends Controller
{
    /**
     * ReservationController constructor, initializing and associating ReservationService
     *
     * @param ReservationService $reservationService
     */
    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * Display a listing of the reservations.
     *
     * @return View index view with all the reservations paginated
     */
    public function index()
    {
        $reservations = $this->reservationService->getAllReservation(5);
        return view('admin.reservations.index', ['reservations' => $reservations]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View view containing reservation creation form from administrative perpective
     */
    public function create()
    {
        return view('admin.reservations.create');
    }

    /**
     * Store a newly created Reservation in database.
     *
     * @param StoreRequest $request  request with all the dta from creation form
     * @return RedirectResponse redirect to index page
     */
    public function store(StoreRequest $request)
    {
        $validation = $this->reservationService->makeReservation($request, Auth::user());
        if (!is_string($validation)) {
            flash(trans('reservations.success_added'))->success();
        } else {
            flash(trans($validation))->error();
        }

        return redirect()->route('admin.reservation.index');
    }

    /**
     * Show the form for editing the specified Reservation.
     *
     * @param int $id    id of the specified Reservation to be editted
     * @return View      return view with the edition form
     */
    public function edit(int $id)
    {
        $reservation = Reservation::withTrashed()->where('id', $id)->first();
        return view('admin.reservations.edit', ['reservation' => $reservation]);
    }

    /**
     * Update the specified resource in database if it contains valid data.
     * Setting notifications for success/error
     *
     * @param Request $request request with all the data from edition form for reservation
     * @param Reservation $reservation specified Reservation to be updated
     * @return RedirectResponse redirect to the index page
     */
    public function update(UpdateRequest $request, Reservation $reservation)
    {
        $validation = $this->reservationService->updateReservation($request, $reservation, Auth::user());
        if (!is_string($validation)) {
            flash(trans('reservations.success_updated'))->success();
        } else {
            flash(trans($validation))->error();
        }
        return redirect()->route('admin.reservation.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reservation $reservation
     * @return Response
     */
    public function destroy(Reservation $reservation)
    {
        $this->reservationService->deleteReservation($reservation, Auth::user());
        return redirect()->route('admin.reservation.index');


    }
}
