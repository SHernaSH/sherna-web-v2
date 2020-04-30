<?php

namespace App\Mail;

use App\Models\Reservations\Reservation;
use \App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class encapsulating email message when reservation is created for location that has access via key
 *
 * Class OnKeyUser
 * @package App\Mail
 */
class OnKeyUser extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Emailová adresa uživatele.
     *
     * @var User|null
     */
    protected $user;
    /**
     * Obsah emailové zprávy.
     *
     * @var Reservation
     */
    protected $reservation;

    /**
     * Vytvoř novou instanci emailové zprávy.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.onkey-user', [
            'reservation' => $this->reservation
        ])->subject('VR Request')->from(env('MAIL_FROM_ADDRESS'));
    }
}
