<?php

namespace App;

use Exception;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

// Inspired by https://github.com/laravel/framework/blob/master/src/Illuminate/Foundation/Vite.php
class TwigViteAssetExtension extends AbstractExtension
{
    private const BUILD_DIRECTORY = '/build/';
    private const MANIFEST_FILENAME = 'manifest.json';

    private ?array $cachedManifest = null;

    public function __construct(
        private readonly string $publicDirectory
    ) {
        //
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('vite_asset', [$this, 'getVersionedFilePath'])
        ];
    }

    public function getName(): string
    {
        return 'vite_asset';
    }

    public function getVersionedFilePath(string $file): string
    {
        $manifest = $this->getManifest();

        if (!isset($manifest[ $file ])) {
            throw new Exception("Unable to locate file in Vite manifest: {$file}.");
        }

        return self::BUILD_DIRECTORY . $manifest[ $file ]['file'] ?? '';
    }

    private function getManifest(): array
    {
        if ($this->cachedManifest !== null) {
            return $this->cachedManifest;
        }

        $manifestPath = $this->getManifestPath();

        if (!file_exists($manifestPath)) {
            throw new Exception("Vite manifest not found at: {$manifestPath}");
        }

        return $this->cachedManifest = json_decode(file_get_contents($manifestPath), true);
    }

    private function getManifestPath(): string
    {
        return $this->publicDirectory . self::BUILD_DIRECTORY . self::MANIFEST_FILENAME;
    }
}
