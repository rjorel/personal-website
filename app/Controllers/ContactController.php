<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function post(Request $request)
    {
        $this->validate($request, [
            'name'    => 'required',
            'email'   => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        Mail::to('raphael.jorel@laposte.net')->send(
            new ContactMail($request)
        );

        return redirect()->to('/contact')->with(
            'message', 'Le message a été correctement envoyé'
        );
    }
}
