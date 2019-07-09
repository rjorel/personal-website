<?php

namespace App\Twig;

use Twig\Cache\FilesystemCache;

// Inspired by http://aknosis.com/2012/10/02/twig-cache-file-permissions/
class CustomCache extends FilesystemCache
{
    const CUSTOM_UMASK = 0002;
    const DIRECTORY_PERMISSION = 0777;

    public function write($file, $content)
    {
        $directory = $this->getDirectoryName($file);

        if ($this->directoryDoesNotExist($directory)) {
            $this->makeDirectoryWithCustomUmask($directory);
        }

        parent::write($file, $content);
    }

    private function getDirectoryName($file)
    {
        return dirname($file);
    }

    private function directoryDoesNotExist($file)
    {
        return !is_dir($file);
    }

    private function makeDirectoryWithCustomUmask(string $directory)
    {
        $previousMask = umask(self::CUSTOM_UMASK);

        mkdir($directory, self::DIRECTORY_PERMISSION, true);

        umask($previousMask);
    }
}