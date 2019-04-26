<?php

namespace App\Providers;

use Swift_SmtpTransport;

class MailServiceProvider extends ServiceProvider
{
    public function register()
    {
        $config = $this->getConfig();

        $mailer = (new Swift_SmtpTransport($config['host'], $config['port']))
            ->setUsername($config['username'])
            ->setPassword($config['password']);

        $this->app['mailer'] = $mailer;
    }

    private function getConfig()
    {
        return [
            'host'     => getenv('MAIL_HOST'),
            'port'     => getenv('MAIL_PORT'),
            'username' => getenv('MAIL_USERNAME'),
            'password' => getenv('MAIL_PASSWORD')
        ];
    }
}