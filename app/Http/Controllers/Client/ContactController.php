<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessage;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

/**
 * Class handling the showing the form for email sending, and handling the sending of an email
 *
 * Class ContactController
 * @package App\Http\Controllers\User
 */
class ContactController extends Controller
{
    /**
     * Show the contact form
     *
     * @return View return view with the contact form
     */
    public function show()
    {
        return view('client.contact.show');
    }

    /**
     * Handle the data from the form and sent email to recipient
     *
     * @param ContactRequest $request  request with all the data from contact form
     * @return RedirectResponse        redirect back to the show form page
     */
    public function send(ContactRequest $request)
    {
        Mail::to(env('MAIL_TO'))->send(new ContactMessage($request->input('email'), $request->input('message')));

        return redirect()->route('contact.show');
    }
}
