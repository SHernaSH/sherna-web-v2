<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class encapsulating email message from contact form
 *
 * Class ContactMessage
 * @package App\Mail
 */
class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Emailová adresa uživatele.
     *
     * @var string|null
     */
    protected $user;
    /**
     * Obsah emailové zprávy.
     *
     * @var string|null
     */
    protected $message;

    /**
     * Vytvoř novou instanci emailové zprávy.
     *
     * @param string $user
     * @param string $message
     * @return void
     */
    public function __construct($user, $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contact', [
            'message' => $this->message,
        ])->subject('Email z kontaktního formuláře')->from($this->user);
    }
}
