<?php

namespace BricksDoc;

class Router
{
    /** @var string */
    protected $route;

    /** @var string */
    protected $appdir;

    /** @var string */
    protected $basePath;

    /** @var string */
    protected $requestUri;

    protected $locale;

    public function __construct(string $basePath, string $requestUri, Locale $locale, string $appdir)
    {
        $this->appdir = $appdir;
        $this->basePath = $basePath;
        $this->requestUri = $requestUri;
        $this->locale = $locale;
        $this->routes = $this->getRoutes(dirname(__DIR__) . '/lang/' . $this->locale::DEFAULT_LANGUAGE . '/routes');
        $route = $this->fetchRoute();

        if ('/404' == $route) {
            header('HTTP/1.0 404 Not Found');
            $route = '/' . $this->locale->getCurrentLanguage() . '/404';
        }

        if('/501' == $route) {
            header('HTTP/1.0 501 Not Found');
            $route = '/' . $this->locale->getCurrentLanguage() . '/501';
        }

        $this->route = $route;
    }

    public function getRoute()
    {
        return $this->route;
    }

    protected function fetchRoute()
    {
        $allowedRoutes = $this->getRoutes(dirname(__DIR__) . '/lang/' . $this->locale::DEFAULT_LANGUAGE . '/routes');

        $route = $this->requestUri == '/' ? '/' : str_replace(
            [($this->basePath == '/' ? '' : $this->basePath), '.html', '../'],
            '',
            $this->requestUri
        );

        if (!$this->isValidRoute($route)) {
            return '/404';
        }

        if ('/' == $route) {
            return $route;
        }

        if (strlen($route) == 3) {
            $lang = substr($route, 1);
            if (!in_array($lang, $this->locale->getAllowedLanguages())) {
                return '/404';
            }
            return $route;
        }

        $lang = trim(substr($route, 0, 4), '/');
        $route = substr($route, 3);

        if (!file_exists($this->appdir . '/lang/' . $lang . '/content' . $route . '.html')) {
            return '/501';
        }

        if (!in_array($route, $allowedRoutes)) {
            return '/404';
        }

        return ('/' == $route || strlen($route) == 3 ? $route : '/' . $lang . $route);
    }

    protected function isValidRoute($route)
    {
        if ('/' == $route) {
            return true;
        }

        if (strpos($route, '../')) {
            return false;
        }

        $allowedLanguages = $this->locale->getAllowedLanguages();

        if (strlen($route) == 3) {
            $lang = substr($route, 1);
            if (in_array($lang, $allowedLanguages)) {
                return true;
            }
        }

        $lang = trim(substr($route, 0, 4), '/');
        if (strlen($lang) != 2 || !in_array($lang, $allowedLanguages)) {
            return false;
        }

        $allowedRoutes = $this->getRoutes(dirname(__DIR__) . '/lang/' . $this->locale::DEFAULT_LANGUAGE . '/routes');

        return in_array(substr($route, 3), $allowedRoutes);
    }

    protected function getRoutes($contentDir)
    {
        $routes = [];
        foreach (glob($contentDir.'/*.php') as $filePath) {
            $route = substr(basename($filePath), 0, -4);
            if (is_dir($filePath)) {
                $routes[$route] = $this->getRoutes($filePath);
            } else {
                $routes[$route] = '/' . $route;
            }
        }
        return $routes;
    }
}
