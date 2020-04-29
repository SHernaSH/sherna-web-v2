<?php

namespace App\Notifications;

use App\Mail\OnKeyUser;
use App\Models\Reservations\Reservation;
use \App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notification class that is send when reservation is created in location that has access via key only
 *
 * Class OnKeyReservation
 * @package App\Notifications
 */
class OnKeyReservation extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     * @param Reservation $reservation
     */
    public function __construct(User $user, Reservation $reservation)
    {
        $this->user = $user;
        $this->reservation = $reservation;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new OnKeyUser($this->user, $this->reservation))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
