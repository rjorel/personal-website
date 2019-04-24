<?php

namespace App\Http\Controllers;

use App\Lib\File;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class RepositoryController extends Controller
{
    const REPOSITORY_STORAGE_DIRECTORY = '/storage/repository';

    public function index(Request $request)
    {
        $path = $this->removeMultiPoints(
            $request->get('p') ?: '/'
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
                $this->getBasePath() . '/' . $path, $path
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
        return public_path(self::REPOSITORY_STORAGE_DIRECTORY);
    }
}
