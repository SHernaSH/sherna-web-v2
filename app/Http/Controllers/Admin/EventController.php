<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Events\StoreRequest;
use App\Http\Requests\Events\UpdateRequest;
use App\Http\Services\ReservationService;
use App\Models\Events\Event;
use App\Models\Locations\Location;
use App\Models\Reservations\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * EventController constructor, initializing and associating ReservationService
     *
     * @param ReservationService $reservationService
     */
    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $events = Event::orderBy('start_at', 'desc')->paginate();
        return view('admin.events.index', ['events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $event = new Event();
        $event->name = $request->get('name');
        $location = Location::where('id', $request->get('location_id'))->firstOrFail();
        $event->location()->associate($location);
        $event->points = $request->get('points', 0);
        $event->start_at = Carbon::createFromFormat('d.m.Y H:i', $request->get('from_date'));
        $event->end_at = Carbon::createFromFormat('d.m.Y H:i', $request->get('to_date'));
        $event->salt = Str::uuid();

        $reservation = new Reservation();
        $user = Auth::user();
        $reservation->user()->associate($user);
        $reservation->location()->associate($location);
        $reservation->visitors_count = 1;
        $reservation->start_at = $event->start_at;
        $reservation->end_at = $event->end_at;
        $reservation->vr = false;
        $reservation->note = "Reservation for an event " . $event->name;
        if($this->reservationService->overlap($reservation)) {
            flash('There is already a reservation at that time')->error();
            return redirect()->route('admin.event.index');
        }
        $reservation->save();
        $event->save();

        flash('Event created successfully')->success();
        return redirect()->route('admin.event.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Events\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function download(Event $event)
    {
        $headers = [
            'Content-Type' => 'image/svg+xml',
        ];
        $path = public_path() . '/qrcodes/';
        if(!File::exists($path)) {
            File::makeDirectory($path);
        }
        $path .= $event->salt . '.svg';

        file_put_contents( $path,$event->QRCode());
        return response()->download($path, 'qr.svg', $headers);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Events\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', ['event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Events\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Event $event)
    {
        if($event->start_at->isPast()) {
            flash('Too late to update')->error();
        } else {
            $reservation = Reservation::where('start_at', $event->start_at)->where('end_at', $event->end_at)->firstOrFail();

            $event->name = $request->get('name');
            $location = Location::where('id', $request->get('location_id'))->firstOrFail();
            $event->location()->associate($location);
            $event->points = $request->get('points', $event->points);
            $event->start_at = Carbon::createFromFormat('d.m.Y H:i', $request->get('from_date'));
            $event->end_at = Carbon::createFromFormat('d.m.Y H:i', $request->get('to_date'));

            $reservation->location()->associate($location);
            $reservation->visitors_count = 1;
            $reservation->start_at = $event->start_at;
            $reservation->end_at = $event->end_at;
            if($this->reservationService->overlap($reservation)) {
                flash('There is already a reservation at that time')->error();
                return redirect()->route('admin.event.index');
            }
            $reservation->update();
            $event->update();
            flash('Event updated successfully')->success();

        }

        return redirect()->route('admin.event.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Events\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $reservation = Reservation::where('start_at', $event->start_at)->where('end_at', $event->end_at)->firstOrFail();
        $reservation->delete();
        $event->delete();

        return redirect()->route('admin.event.index');
    }
}
