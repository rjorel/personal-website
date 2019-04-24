<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;

class ContactMail extends Mailable
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function build()
    {
        return $this
            ->replyTo($this->request->get('email'))
            ->subject($this->request->get('subject'))
            ->view('emails.contact', [
                'request' => $this->request
            ]);
    }
}
