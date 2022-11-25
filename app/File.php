<?php

namespace App;

use SplFileInfo;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class File extends SplFileInfo
{
    private const HTML_DESCRIPTION_FILE = '.README.html';

    private string $relativePath;

    public function __construct(string $filePath, string $relativePath, bool $checkPath = true)
    {
        parent::__construct($filePath);

        if ($checkPath && !file_exists($filePath)) {
            throw new FileException();
        }

        $this->relativePath = $this->removeDuplicatedSlashes($relativePath);
    }

    private function removeDuplicatedSlashes(string $path): string
    {
        return str_replace('//', '/', $path);
    }

    public function getHtmlDescription(): string
    {
        try {
            return $this->newChildFile(self::HTML_DESCRIPTION_FILE)->read();
        } catch (FileException) {
            return '';
        }
    }

    private function read(): string
    {
        $fd = $this->openFile('r');

        return $fd->fread($fd->getSize());
    }

    private function newChildFile(string $filename): File
    {
        return new File(
            $this->getRealPath() . DIRECTORY_SEPARATOR . $filename,
            $this->getRelativePath() . DIRECTORY_SEPARATOR . $filename
        );
    }

    public function getRelativePath(): string
    {
        return $this->relativePath;
    }

    public function getContent(): ?string
    {
        if ($this->isDir() || $this->isArchive() || $this->isPdf() || $this->isImage()) {
            return null;
        }

        return $this->read();
    }

    public function isArchive(): bool
    {
        return in_array($this->getExtension(), ['zip', 'rar']);
    }

    public function isPdf(): bool
    {
        return $this->getExtension() == 'pdf';
    }

    public function isImage(): bool
    {
        return str_starts_with($this->getMimeType(), 'image');
    }

    public function getMimeType(): string
    {
        return mime_content_type($this->getRealPath());
    }

    public function getRelativeParentPath(): string
    {
        return pathinfo($this->relativePath, PATHINFO_DIRNAME);
    }

    public function getChildFiles(): array
    {
        if (!$this->isDir()) {
            return [];
        }

        return array_map(
            fn(SplFileInfo $file) => $this->newChildFile($file->getFilename()),
            $this->getChildFileInfo()
        );
    }

    private function getChildFileInfo(): array
    {
        $finder = Finder::create()
            ->depth('== 0')
            ->in($this->getRealPath())
            ->sortByType();

        return iterator_to_array($finder->getIterator());
    }
}
