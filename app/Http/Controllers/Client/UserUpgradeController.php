<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Services\UpgradeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserUpgradeController extends Controller
{
    public function __construct(UpgradeService $upgradeService)
    {
        $this->upgradeService = $upgradeService;
    }

    /**
     * Show the view for the base bage of administration
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke($type, Request $request)
    {
        if($type == 'hour') {
            $this->upgradeService->addHour();
        } else if($type == 'hours') {
            $this->upgradeService->addMaxHours();
        } else if($type == 'double') {
            $this->upgradeService->addExtra();
        } else {
            flash('Not recognized')->error();
        }
        return redirect()->route('user.reservations');
    }
}
