<?php

namespace App\Controllers;

use Symfony\Component\Finder\Finder;

class SitemapController extends Controller
{
    private static $staticUrls = [
        '/',
        '/about',
        '/achievement',
        '/contact',
        '/repository',
        '/skills',
    ];

    public function index()
    {
        $urls = array_merge(
            self::$staticUrls, $this->getRepositoryUrls()
        );

        return $this->render('sitemap.xml.twig', [
            'urls' => $urls,
            'date' => date('Y-m-d')
        ]);
    }

    private function getRepositoryUrls()
    {
        $basePath = $this->getBasePath();

        return array_map(function ($directory) use ($basePath) {
            return '/repository#' . str_replace($basePath, '', $directory);
        }, $this->getDirectories());
    }

    private function getBasePath()
    {
        return $this->app->getPublicPath() . RepositoryController::REPOSITORY_STORAGE_DIRECTORY;
    }

    private function getDirectories()
    {
        $finder = Finder::create()
            ->in($this->getBasePath())
            ->directories();

        return array_keys(
            iterator_to_array($finder->getIterator())
        );
    }
}
