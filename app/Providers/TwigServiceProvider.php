<?php

namespace App\Providers;

use App\Twig\CustomFileCache;
use App\Twig\MixExtension;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigServiceProvider extends ServiceProvider
{
    public function register()
    {
        $loader = new FilesystemLoader($this->app->getTemplatePath());

        $twig = new Environment($loader, [
            'cache' => new CustomFileCache(
                $this->app->getCachePath()
            ),
            'debug' => getenv('APP_ENV') != 'production'
        ]);

        $twig->addExtension(
            new MixExtension($this->app->getPublicPath())
        );

        $this->app['twig'] = $twig;
    }
}