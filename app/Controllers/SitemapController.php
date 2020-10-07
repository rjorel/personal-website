<?php

namespace App\Controllers;

use App\Routing\Route;
use Symfony\Component\Finder\Finder;

class SitemapController extends Controller
{
    public function index()
    {
        $uris = array_merge(
            $this->getRouterUris(), $this->getRepositoryUris()
        );

        return $this->render('sitemap.xml.twig', [
            'uris' => $uris,
            'date' => date('Y-m-d')
        ]);
    }

    private function getRouterUris()
    {
        return array_unique(
            array_map(function (Route $route) {
                return $route->getUri();
            }, $this->getRouter()->getRoutes())
        );
    }

    private function getRepositoryUris()
    {
        $basePath = $this->getBasePath();

        return array_map(function ($directory) use ($basePath) {
            return '/repository' . str_replace($basePath, '', $directory);
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
