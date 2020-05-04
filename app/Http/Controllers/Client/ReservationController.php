<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Navigation\Page\UpdateRequest;
use App\Http\Requests\Reservations\StoreRequest;
use App\Http\Services\ReservationService;
use App\Models\Reservations\Reservation;
use App\Models\Settings\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

/**
 * Class hnadling the CRUD operations on Reservation model, from the user perspective
 * Reservations are shown in javascript fullcalendar, can be added by clicking on the calendar, update
 * by resizing or dropping it. See reservation blade and assets/reservation javascript scripts
 *
 * Class ReservationController
 * @package App\Http\Controllers\User
 */
class ReservationController extends Controller
{

    /**
     * ReservationController constructor declaring middleware that require logged in user to create/edit reservations,
     * and initializing ReservationService
     *
     * @param ReservationService $reservationService
     */
    public function __construct(ReservationService $reservationService)
    {
        $this->middleware('auth', ['except' => ['getReservations']]);
        $this->reservationService = $reservationService;
    }

    /**
     * Getting all the reservations in the json format for fullcalendar to render
     * Entity contains editable filed, which controls whether it can be drag and dropped in the calendar,
     * edit field that determines if user can update/destroy that reservation
     * (if its his own reservation, or user is reservation manager),
     * owner field, which determines whether the user is the owner of the reservation,
     * and start and end of the reservation in specified format,
     *
     * @param Request $request  request with location for which the reservations should be shown
     * @return JsonResponse     all the reservations for the specified location in json format with few additional fields
     */
    public function getReservations(Request $request)
    {
        $reservations = Reservation::where('location_id', $request->get('location'))->get(['id', 'start_at', 'end_at', 'visitors_count', 'location_id', 'note', 'user_id']);
        foreach ($reservations as $reservation) {
            $owner = $reservation->user;

            $reservation->title = trans('reservations.reservation_for') . $owner->name . ' ' . $owner->surname;
            $reservation->start = $reservation->start_at->format('Y-m-d H:i');
            $reservation->end = $reservation->end_at->format('Y-m-d H:i');

            if (Auth::check() && ($owner->id == Auth::user()->id || Auth::user()->role->hasPermissionByName('Reservation Manager'))) {
                $reservation->editable = !$reservation->start_at->isPast();
                $reservation->edit = !$reservation->end_at->addMinutes((-1) * Setting::where('name', 'Time for edit')->first()->value)->isPast();
                $reservation->own = $owner->id == Auth::user()->id;
            }
        }

        return Response::json($reservations);
    }

    /**
     * Show the index page of the reservation
     *
     * @return RedirectResponse redirect to index page of the reservation
     */
    public function index()
    {
        return redirect()->route('pages.show', ['page' => 'reservation']);
    }

    /**
     * Store a newly created Reservation in database if it contains valid data.
     * Setting notifications for success/error
     *
     * @param StoreRequest $request request with all the data from creation form for reservation
     * @return RedirectResponse redirect to the index page
     */
    public function store(StoreRequest $request)
    {

        $validation = $this->reservationService->makeReservation($request, Auth::user());
        if (!is_string($validation)) {
            flash(trans('reservations.success_added'))->success();
        } else {
            flash(trans($validation))->error();
        }

        return redirect()->back();
    }


    /**
     * Update the specified resource in database if it contains valid data.
     * Setting notifications for success/error
     *
     * @param UpdateRequest $request request with all the data from edition form for reservation
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
        return redirect()->back();

    }

    /**
     * Remove the specified resource from database if the user has the rights to do so.
     * Setting notifications for success/error
     *
     * @param Reservation $reservation specified Reservation to be updated
     * @return RedirectResponse redirect to the index page
     */
    public function destroy(Reservation $reservation)
    {
        if ($this->reservationService->deleteReservation($reservation, Auth::user())) {
            flash(trans('reservations.success_deleted'))->success();
        } else {
            flash(trans('general.unsuccessful'))->error();
        }
        return redirect()->back();


    }
}
