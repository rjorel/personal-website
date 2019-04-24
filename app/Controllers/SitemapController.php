<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

        return response()->view('sitemap', [
            'urls' => $urls,
            'date' => Carbon::now()->format('Y-m-d')
        ])->header('Content-Type', 'text/xml');
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
        return public_path(RepositoryController::REPOSITORY_STORAGE_DIRECTORY);
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
