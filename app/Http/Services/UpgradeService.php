<?php


namespace App\Http\Services;


use App\Models\Reservations\Reservation;
use App\Models\Settings\Setting;
use App\Models\Users\Upgrade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpgradeService
{
    public function addHour($hour = 1, $user = null, $refund = false) {
        $user = $user ?: Auth::user();
        $upgrade = $this->getUpgrade($user);
        $maxDuration = Setting::where('name', 'Maximal Duration')->first()->value;
        DB::beginTransaction();
        try {
            $upgrade->overflow += $hour;
            if ($upgrade->overflow > $maxDuration) {
                if($refund) {
                    $extra = $upgrade->overflow - $maxDuration;
                    if($extra > 0){
                        $this->addPoints('Points for one hour', $extra, $user);
                    }
                    $upgrade->overflow = $maxDuration;
                    flash(trans('reservations.over_limit_hour'))->warning();
                } else {
                    flash(trans('reservations.too_overflow'))->error();
                    throw new \Exception();
                }
            }
            if(!$refund) {
                $this->substractPoints('Points for one hour', $user);
            }
            $upgrade->save();

            DB::commit();
            flash(trans('reservations.add_hour'))->success();
        } catch (\Exception $ex) {
            DB::rollBack();
        }
    }

    public function addMaxHours($user = null, $refund = false) {
        $user = $user ?: Auth::user();

        $maxDuration = Setting::where('name', 'Maximal Duration')->first()->value;
        $upgrade = $this->getUpgrade($user);

        try {
            $upgrade->overflow += $maxDuration;
            if ($upgrade->overflow > $maxDuration) {
                if($refund) {
                    $extra = $upgrade->overflow - $maxDuration;
                    if($extra == $maxDuration) {
                        $this->addPoints('Points for max hours', 1, $user);
                    } else if($extra > 0){
                        $this->addPoints('Points for one hour', $extra, $user);
                    }
                    $upgrade->overflow = $maxDuration;
                    flash(trans('reservations.over_limit_hour'))->warning();
                } else {
                    flash(trans('reservations.too_overflow'))->error();
                    throw new \Exception();
                }
            }
            if(!$refund) {
                $this->substractPoints('Points for max hours', $user);
            }
            $upgrade->save();
            DB::commit();
            flash(trans('reservations.add_max_hours'))->success();
        } catch (\Exception $ex) {
            DB::rollBack();
        }
    }

    public function addExtra($user = null, $refund = false)
    {
        $user = $user ?: Auth::user();
        try {
            $upgrade = $this->getUpgrade($user);

            if ($upgrade->double) {
                if($refund) {
                    $this->addPoints('Points for extra reservation', 1, $user);
                    flash(trans('reservations.over_limit_extra'))->warning();

                } else {
                    flash(trans('reservations.too_double'))->error();
                    throw new \Exception();
                }
            }
            if(!$refund) {
                $this->substractPoints('Points for extra reservation', $user);
            }
            $upgrade->double = true;
            $upgrade->save();

            DB::commit();
            flash(trans('reservations.add_extra'))->success();
        } catch (\Exception $ex) {
            DB::rollBack();
        }
    }

    public function useExtraHours(Reservation $reservation, $hours, $user = null) {
        $user = $user ?: Auth::user();
        DB::beginTransaction();
        try {
            $upgrade = $this->getUpgrade($user);

            if($hours > $upgrade->overflow) {
                throw new \Exception();
            }

            $upgrade->overflow -= $hours;
            $upgrade->save();
            $reservation->extra_hours = $hours;
            $reservation->save();

            DB::commit();
            return true;
        } catch (\Exception $ex) {
            DB::rollBack();
            return 'Error when using upgrades';
        }
    }

    public function useExtraReservation(Reservation $reservation, $user = null) {
        $user = $user ?: Auth::user();
        DB::beginTransaction();
        try {
            $upgrade = $this->getUpgrade($user);

            if (!$upgrade->double) {
                throw new \Exception();
            }
            $upgrade->double = false;
            $upgrade->save();
            $reservation->extra = true;
            $reservation->save();

            DB::commit();
            return true;
        } catch (\Exception $ex) {
            DB::rollBack();
            return 'Error when using upgrades';
        }
    }

    public function useExtraHoursAndReservation(Reservation $reservation, $hours, $user = null) {
        $user = $user ?: Auth::user();
        DB::beginTransaction();
        try {
            $upgrade = $this->getUpgrade($user);

            if($hours > $upgrade->overflow) {
                throw new \Exception();
            }

            if (!$upgrade->double) {
                throw new \Exception();
            }
            $upgrade->double = false;
            $upgrade->overflow -= $hours;
            $upgrade->save();
            $reservation->extra = true;
            $reservation->extra_hours = $hours;
            $reservation->save();

            DB::commit();
            return true;
        } catch (\Exception $ex) {
            DB::rollBack();
            return 'Error when using upgrades';
        }
    }

    private function substractPoints($name, $user) {
        $user->points -= Setting::where('name', $name)->first()->value;
        if ($user->points < 0) {
            flash(trans('reservations.not_enough'))->error();
            throw new \Exception();
        }
        $user->save();
    }

    private function addPoints($name, $hours, $user) {
        $user->points += $hours * Setting::where('name', $name)->first()->value;
        $user->save();
    }

    private function getUpgrade($user) {
        $upgrade = Upgrade::where('user_id', $user->id)->first();
        if($upgrade == null) {
            $upgrade = new Upgrade();
            $upgrade->user_id = $user->id;
            $upgrade->double = false;
            $upgrade->overflow = 0;
        }
        return $upgrade;
    }

}
