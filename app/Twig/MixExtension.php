<?php

namespace App\Twig;

use Exception;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MixExtension extends AbstractExtension
{
    private $manifestDirectory;

    private $manifests = [];

    public function __construct($manifestDirectory)
    {
        $this->manifestDirectory = $manifestDirectory;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('mix', [$this, 'getVersionedFilePath']),
        ];
    }

    public function getName()
    {
        return 'mix';
    }

    public function getVersionedFilePath($path)
    {
        $manifest = $this->getManifest();

        if (!isset($manifest[ $path ])) {
            throw new Exception("Unable to locate Mix file: {$path}.");
        }

        return $manifest[ $path ];
    }

    private function getManifest()
    {
        $manifestPath = $this->getManifestPath();

        if (!isset($this->manifests[ $manifestPath ])) {
            if (!file_exists($manifestPath)) {
                throw new Exception('The Mix manifest does not exist.');
            }

            $this->manifests[ $manifestPath ] = json_decode(file_get_contents($manifestPath), true);
        }

        return $this->manifests[ $manifestPath ];
    }

    private function getManifestPath()
    {
        return $this->manifestDirectory . '/mix-manifest.json';
    }
}