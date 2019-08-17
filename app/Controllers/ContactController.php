<?php

namespace App\Controllers;

use Swift_Message;

class ContactController extends Controller
{
    public function index()
    {
        return $this->render('views/pages/contact.html.twig');
    }

    public function send()
    {
        $this->getMailer()->send(
            $this->buildMessage()
        );

        return $this->render('views/pages/contact.html.twig', [
            'message' => 'Le message a été correctement envoyé'
        ]);
    }

    private function buildMessage()
    {
        $subject = $this->request->get('subject');
        $email = $this->request->get('email');

        return (new Swift_Message($subject))
            ->setFrom($this->getSenderAddress())
            ->setTo($this->getRecipientAddress())
            ->setReplyTo($email)
            ->setBody($this->getBodyContent())
            ->setContentType('text/html');
    }

    private function getSenderAddress()
    {
        return [
            getenv('MAIL_FROM_ADDRESS') => getenv('MAIL_FROM_NAME')
        ];
    }

    private function getRecipientAddress()
    {
        return [
            'raphael.jorel@laposte.net' => 'Me'
        ];
    }

    private function getBodyContent()
    {
        return $this->render('emails/contact.html.twig', [
            'request' => $this->request
        ]);
    }
}
