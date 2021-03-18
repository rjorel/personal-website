<?php

namespace App;

use SplFileInfo;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class File extends SplFileInfo
{
    const HTML_DESCRIPTION_FILE = '.README.html';

    private $relativePath;

    public function __construct($filePath, $relativePath, $checkPath = true)
    {
        parent::__construct($filePath);

        if ($checkPath && !file_exists($filePath)) {
            throw new FileException;
        }

        $this->relativePath = $this->removeDuplicatedSlashes($relativePath);
    }

    private function removeDuplicatedSlashes($path)
    {
        return str_replace('//', '/', $path);
    }

    public function getHtmlDescription()
    {
        try {
            return $this->newChildFile(self::HTML_DESCRIPTION_FILE)->read();
        } catch (FileException $e) {
            return '';
        }
    }

    private function read()
    {
        $fd = $this->openFile('r');

        return $fd->fread($fd->getSize());
    }

    private function newChildFile($filename)
    {
        return new File(
            $this->getRealPath() . DIRECTORY_SEPARATOR . $filename,
            $this->getRelativePath() . DIRECTORY_SEPARATOR . $filename
        );
    }

    public function getRelativePath()
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

    public function isArchive()
    {
        return in_array($this->getExtension(), ['zip', 'rar']);
    }

    public function isPdf()
    {
        return $this->getExtension() == 'pdf';
    }

    public function isImage()
    {
        return substr($this->getMimeType(), 0, 5) == 'image';
    }

    public function getMimeType()
    {
        return mime_content_type($this->getRealPath());
    }

    public function getRelativeParentPath()
    {
        return pathinfo($this->relativePath, PATHINFO_DIRNAME);
    }

    public function getChildFiles()
    {
        if (!$this->isDir()) {
            return [];
        }

        return array_map(
            fn(SplFileInfo $file) => $this->newChildFile($file->getFilename()),
            $this->getChildFileInfo()
        );
    }

    private function getChildFileInfo()
    {
        $finder = Finder::create()
            ->depth('== 0')
            ->in($this->getRealPath())
            ->sortByType();

        return iterator_to_array($finder->getIterator());
    }
}
