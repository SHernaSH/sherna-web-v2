<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Events\Event;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Show the view for the base bage of administration
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke($salt, Request $request)
    {
        $event = Event::where('salt', $salt)->firstOrFail();
        $this->grantPointsToUser($event);
        return redirect()->route('user.reservations');
//        return view('client.event.index', ['event' => $event]);
    }

    private function grantPointsToUser(Event $event) {
        /** @var User $user */
        $user = Auth::user();
        DB::beginTransaction();
        try {
            if($event->users()->where('user_id', $user->id)->exists()) {
                DB::commit();
                flash('You already attended this event!')->warning();
                return;
            }
            if(!Carbon::now()->isBetween($event->start_at, $event->end_at)) {
                DB::commit();
                flash('Attend this event at the time when it is happening!')->warning();
                return;
            }
            $user->points += $event->points;
            $event->users()->attach($user);
            $user->save();
            $event->save();
            DB::commit();

            flash('You have successfully attended ' . $event->name . ' and gained ' . $event->points
            . ' points.')->success();
        } catch (\Exception $e) {
            DB::rollBack();
            flash('There was an error. Try again.')->error();
        }
    }
}
