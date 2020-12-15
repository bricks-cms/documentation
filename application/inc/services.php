<?php

use BricksDoc\Server;
use BricksDoc\Request;
use BricksDoc\Router;
use BricksDoc\Locale;
use BricksDoc\Translate;
use BricksDoc\View;
use BricksDoc\Application;

function getServer()
{
    global $_server;
    if (!$_server) {
        $_server = new Server();
    }
    return $_server;
}

function getRequest()
{
    global $_request;
    if (!$_request) {
        $server = getServer();
        $_request = new Request($server);
    }
    return $_request;
}

function getRouter()
{
    global $_router;
    if (!$_router) {
        $request = getRequest();
        $locale = getLocale();
        $_router = new Router($request->getBasePath(), $request->getRequestUri(), $locale, dirname(__DIR__));
    }
    return $_router;
}

function getLocale()
{
    global $_locale;
    if (!$_locale) {
        $request = getRequest();
        $_locale = new Locale($request);
    }
    return $_locale;
}

function getTranslate()
{
    global $_translate;
    if (!$_translate) {
        $locale = getLocale();
        $router = getRouter();

        $_translate = new Translate(
            $locale->getCurrentLanguage(),
            $router->getRoute()
        );
    }
    return $_translate;
}

function getView()
{
    global $_view;
    if (!$_view) {
        $_view = new View();
    }
    return $_view;
}

function getApplication()
{
    global $_application;
    if (!$_application) {
        $router = getRouter();
        $_application = new Application($router->getRoute(), dirname(__DIR__));
    }
    return $_application;
}