<?php

namespace App\Controllers;

use App\File;
use DomainException;
use Highlight\Highlighter;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class RepositoryController extends Controller
{
    public const string REPOSITORY_STORAGE_DIRECTORY = '/repository-files';

    public function index()
    {
        return $this->render('views/pages/repository.html.twig');
    }

    public function getFile()
    {
        $path = $this->removeMultiPoints($this->request->get('p') ?: '/');

        $file = $this->getFileFromPath($path);

        return [
            'file' => [
                ...$this->getFileAttributes($file),
                'description' => $this->getHtmlFileDescription($file),
                'content'     => $this->getHighlightedFileContent($file),

                'childFiles' => array_values(array_map(
                    fn(File $file) => $this->getFileAttributes($file),
                    $file->getChildFiles()
                ))
            ]
        ];
    }

    private function removeMultiPoints(string $path): string
    {
        return preg_replace('/\.+/', '.', $path);
    }

    private function getFileFromPath($path): File
    {
        try {
            return new File($this->getBasePath() . $path, $path);
        } catch (FileException) {
            return new File($this->getBasePath(), '/');
        }
    }

    private function getBasePath(): string
    {
        return $this->app->getPublicPath() . self::REPOSITORY_STORAGE_DIRECTORY;
    }

    private function getFileAttributes(File $file): array
    {
        return [
            'name'               => $file->getFilename(),
            'relativePath'       => $file->getRelativePath(),
            'relativeParentPath' => $file->getRelativeParentPath(),
            'storagePath'        => self::REPOSITORY_STORAGE_DIRECTORY . $file->getRelativePath(),

            'isDir'     => $file->isDir(),
            'isArchive' => $file->isArchive(),
            'isImage'   => $file->isImage(),
            'isPdf'     => $file->isPdf()
        ];
    }

    private function getHtmlFileDescription(File $file): ?string
    {
        return preg_replace(['/[\s\n]+/'], [' '], $file->getHtmlDescription());
    }

    private function getHighlightedFileContent(File $file): ?string
    {
        if (!$content = $file->getContent()) {
            return null;
        }

        try {
            return (new Highlighter())
                ->highlight($file->getExtension(), $content)
                ->value;
        } catch (DomainException) {
            return $content;
        }
    }
}
