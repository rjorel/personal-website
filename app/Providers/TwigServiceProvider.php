<?php

namespace App\Providers;

use App\TwigViteAssetExtension;
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
            new TwigViteAssetExtension($this->app->getPublicPath())
        );

        $this->app[ TwigEnvironment::class ] = $twig;
    }

    private function getTwigEnvironmentOptions(): array
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

    private function isProductionEnvironment(): string
    {
        return $this->app->getEnvironment() == 'production';
    }
}
