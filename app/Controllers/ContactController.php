<?php

namespace App\Controllers;

use Mailgun\Mailgun;

class ContactController extends Controller
{
    public function index()
    {
        return $this->render('views/pages/contact.html.twig');
    }

    public function send()
    {
        //        $domain = getenv('MAILGUN_DOMAIN');
        //        $apiVersion = getenv('MAILGUN_SECRET');
        //        $from = getenv('MAIL_FROM_ADDRESS');
        //        $to = 'raphael.jorel@laposte.net';

        //        $mailer = new \Swift_SmtpTransport('smtp.mailgun.org', 587);
        //
        //        $message = (new \Swift_Message($this->request->get('subject')))
        //            ->setTo(['raphael.jorel@laposte.net' => 'Me'])
        //            ->setBody('Here is the message itself');
        //
        //        $result = $mailer->send($message);

        //        $mailer = new Mailgun($apiVersion);
        //
        //        $mailer->messages()->send($domain, [
        //            'from'     => $from,
        //            'to'       => $to,
        //            'reply-to' => $this->request->get('email'),
        //            'subject'  => $this->request->get('subject'),
        //            'text'     => $this->getEmailContent()
        //        ]);

        //        $this->getMailer()->send($message);

        return $this->render('views/pages/contact.html.twig', [
            'message' => 'Le message a été correctement envoyé'
        ]);
    }

    private function getEmailContent()
    {
        return $this->render('emails/contact.html.twig', [
            'request' => $this->request
        ]);
    }
}
