<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 03/07/17
 * Time: 20:15
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\Locations\Location;
use App\Models\Reservations\Reservation;
use App\Models\Settings\Setting;
use App\Models\Users\User;
use Illuminate\Http\Request;

class APIController extends Controller
{

    public function checkReservation( Request $request )
    {
        \Log::info(json_encode($request->all()));

        $this->validate($request, [
            'device_id' => 'required',
            'room_id'   => 'required',
            'uid'       => 'required',
        ]);

        $user = User::where('uid', $request->uid)->first();
        if (( $user != null && $user->isAdmin() ) || ( in_array($request->uid, explode(',', env('SUPER_ADMINS'))) ) || User::where('id', $request->uid)->isAdmin()) {
            return response('true');
        }

        $location = Location::where('location_uid', $request->room_id)->where('reader_uid', $request->device_id)->opened()->first();

        if ($location == null ) {
            return response('false');
        }

        $accessStartTime = date('Y-m-d H:i:s', strtotime('+' . Setting::where('name', 'Earlier access to location of reservation')->first()->value . ' minutes'));
        $accessEndTime = date('Y-m-d H:i:s');

        $result = Reservation::where('location_id', $location->id)
            ->where('user_id', $request->uid)
            ->where('start_at', '<=', $accessStartTime)
            ->whereNull('deleted_at')
            ->where('end_at', '>=', $accessEndTime)->first();

        if ($result == null) {
            return response('false');
        }

        $result->entered_at = date('Y-m-d H:i:s');
        $result->save();

        return response('true');
    }

}
