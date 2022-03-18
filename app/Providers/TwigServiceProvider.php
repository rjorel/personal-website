<?php

namespace App\Providers;

use App\TwigMixExtension;
use Core\ServiceProvider;
use Twig\Environment as TwigEnvironment;
use Twig\Loader\FilesystemLoader as TwigFilesystemLoader;

class TwigServiceProvider extends ServiceProvider
{
    public function register()
    {
        $twig = new TwigEnvironment(
            new TwigFilesystemLoader($this->app->getTemplatePath()),
            $this->getTwigEnvironmentOptions()
        );

        $twig->addExtension(
            new TwigMixExtension($this->app->getPublicPath())
        );

        $this->app[ TwigEnvironment::class ] = $twig;
    }

    private function getTwigEnvironmentOptions()
    {
        if ($this->isProductionEnvironment()) {
            return [
                'cache' => $this->app->getCachePath()
            ];
        }

        return [
            'cache' => false,
            'debug' => true
        ];
    }

    private function isProductionEnvironment()
    {
        return $this->app->getEnvironment() == 'production';
    }
}
