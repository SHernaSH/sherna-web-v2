<?php

namespace App\Console\Commands;

use App\Models\Reservations\Reservation;
use Illuminate\Console\Command;

class InactiveReservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Is nobody entered the reservation location 45 minutes after the start, cancel the reservatino';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info('InactiveReservation job ran');
        $reservations = Reservation::whereNull('entered_at')
            ->whereNull('deleted_at')
            ->where('start', '<=', date('Y-m-d H:i:s', strtotime('+45 minutes')))
            ->where('end', '>=', date('Y-m-d H:i:s'))
            ->get();
        foreach ($reservations as $reservation) {
            if(!$reservation->user->isAdmin()) {
                $reservation->delete();
            }
        }
    }
}
