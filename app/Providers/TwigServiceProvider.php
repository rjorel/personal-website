<?php

namespace App\Providers;

use App\Twig\MixExtension;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigServiceProvider extends ServiceProvider
{
    public function register()
    {
        $loader = new FilesystemLoader($this->app->getTemplatePath());
        $twig = new Environment($loader, $this->getEnvironmentOptions());

        $twig->addExtension(
            new MixExtension($this->app->getPublicPath())
        );

        $this->app['twig'] = $twig;
    }

    private function getEnvironmentOptions()
    {
        if ($this->isProductionEnvironment()) {
            return ['cache' => $this->app->getCachePath()];
        }

        return [
            'cache' => false,
            'debug' => true
        ];
    }

    private function isProductionEnvironment()
    {
        return getenv('APP_ENV') == 'production';
    }
}
