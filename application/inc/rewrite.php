<?php

function getRoutes()
{
    global $_routes;
    if (!$_routes) {
        $_routes = require appdir('config/routes.php');
    }
    return $_routes;
}

function if404()
{
    $requestedPage = getRequestedPage();
    if ('/404' == $requestedPage) {
        return true;
    }
    return false;
}

function getRequestedPage()
{
    global $_requestedPage;
    if (!$_requestedPage) {
        $routes = getRoutes();
        $route = str_replace([getBaseUrl(), '.html'], '', $_SERVER['REQUEST_URI']);
        $lang = trim(substr($route, 0, 4), '/');
        if (strlen($lang) != 2 && $route != '/') {
            $route = '/404';
        } else {
            if (strlen($lang) == 2) {
                $route = substr($route, 3);
            }
        }
        $route = '/home' == $route ? '/' : $route;
        if (in_array($route, array_keys($routes))) {
            $_requestedPage = '/' == $route ? '/home' : $route;
        } else {
            $_requestedPage = '/404';
        }
    }
    return $_requestedPage;
}

function getRequestedContent()
{
    global $_requestedContent;
    if (!$_requestedContent) {
        $locale = getLocale();
        $routes = getRoutes();
        $page = getRequestedPage();
        $page = '/home' == $page ? '/' : $page;
        if (in_array($page, array_keys($routes))) {
            $_requestedContent['content'] = $routes[$page]['locale'][$locale]['content'] ?? false;
            $file = $routes[$page]['locale'][$locale]['locale'] ?? false;
            if ($file) {
                $file = appdir('lang/' . $locale . '/pages/' . $file);
                if (file_exists($file)) {
                    $_requestedContent['locale'] = require($file);
                }
            }
        }
        if (false == $_requestedContent['content']) {
            throw new \RuntimeException('could not load page content');
        }
        if (!isset($_requestedContent['locale'])) {
            throw new \RuntimeException('could not load page content locale strings');
        }
    }
    return $_requestedContent;
}

if (if404()) {
    header('HTTP/1.0 404 Not Found');
}