<?php

namespace App\Controllers;

class ContactController extends Controller
{
    public function index()
    {
        return $this->render('views/pages/contact.html.twig');
    }

    public function send()
    {
        $headers = [
            'Reply-To' => $this->request->get('email'),
            'Subject'  => $this->request->get('subject')
        ];

        $content = $this->render('emails/contact.html.twig', [
            'request' => $this->request
        ]);

        mail('raphael.jorel@laposte.net', $this->request->get('subject'), $content, $headers);

        return $this->render('views/pages/contact.html.twig', [
            'message' => 'Le message a été correctement envoyé'
        ]);
    }
}
