<?php

namespace App\Providers;

use Swift_SendmailTransport;

class MailServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['mailer'] = new Swift_SendmailTransport();
    }
}