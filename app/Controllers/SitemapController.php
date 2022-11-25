<?php

namespace App\Controllers;

use Core\Routing\Route;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $content = $this->render('sitemap.xml.twig', [
            'urls' => $this->getUrls()
        ]);

        return $this->makeXmlResponse($content);
    }

    private function getUrls(): array
    {
        $baseUrl = $this->request->getSchemeAndHttpHost();
        $uris = [...$this->getRouterUris(), ...$this->getRepositoryUris()];

        return array_map(fn(string $uri) => $baseUrl . $uri, $uris);
    }

    private function getRouterUris(): array
    {
        return array_unique(array_map(
            fn(Route $route) => $route->uri,
            $this->app->getRouter()->getRoutes()
        ));
    }

    private function getRepositoryUris(): array
    {
        $basePath = $this->getBasePath();

        return array_map(
            fn($directory) => '/repository#' . str_replace($basePath, '', $directory),
            $this->getDirectories()
        );
    }

    private function getBasePath(): string
    {
        return $this->app->getPublicPath() . RepositoryController::REPOSITORY_STORAGE_DIRECTORY;
    }

    private function getDirectories(): array
    {
        $finder = Finder::create()
            ->in($this->getBasePath())
            ->directories();

        return array_keys(
            iterator_to_array($finder->getIterator())
        );
    }

    private function makeXmlResponse(string $content): Response
    {
        return new Response($content, 200, [
            'Content-Type' => 'text/xml'
        ]);
    }
}
