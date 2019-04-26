<?php

namespace App\Controllers;

use App\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class RepositoryController extends Controller
{
    const REPOSITORY_STORAGE_DIRECTORY = '/repository-files';

    public function index()
    {
        return $this->render('views/pages/repository.html.twig');
    }

    public function file()
    {
        $path = $this->removeMultiPoints(
            $this->request->get('p') ?: '/'
        );

        return [
            'currentFile' => $this
                ->getFile($path)
                ->setStorageDirectory(self::REPOSITORY_STORAGE_DIRECTORY)
                ->toArray()
        ];
    }

    private function removeMultiPoints($path)
    {
        return preg_replace('/\.+/', '.', $path);
    }

    private function getFile($path)
    {
        try {
            return new File(
                $this->getBasePath() . $path, $path
            );
        } catch (FileException $e) {
            //
        }

        return new File(
            $this->getBasePath(), '/'
        );
    }

    private function getBasePath()
    {
        return $this->app->getPublicPath() . self::REPOSITORY_STORAGE_DIRECTORY;
    }
}
