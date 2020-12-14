<?php

function url($path = null) {
    $request = getRequest();
    $locale = getLocale();
    $lang = $locale->getCurrentLanguage() != $locale::DEFAULT_LANGUAGE ? $locale->getCurrentLanguage() : '';
    return rtrim($request->getBaseUrl(), '/') . '/' . (null != $path ? $locale->getCurrentLanguage() . '/' . $path : $lang);
}

function asset($path = null) {
    $request = getRequest();
    return rtrim($request->getBaseUrl(), '/') . '/' . $path;
}

function pubdir($path = null) {
    return dirname(__DIR__) . '/public/' . $path;
}

function appdir($path = null) {
    return dirname(__DIR__) . '/' . $path;
}

function baseurl() {
    $request = getRequest();
    return $request->getBaseUrl();
}

function translate($string) {
    $translate = getTranslate();
    return $translate->translate($string);
}

function lang() {
    $locale = getLocale();
    return $locale->getCurrentLanguage();
}

function route() {
    $router = getRouter();
    return $router->getRoute();
}

function escape($string, $type = 'html')
{
    if ($type == 'html') {
        return htmlspecialchars($string);
    }
}

function render($template)
{
    $view = getView();
    return $view->renderHtml($template);
}

function renderContentTemplate()
{
    $application = getApplication();
    $routeContentTemplate = $application->getRouteContentTemplate();
    return render($routeContentTemplate);
}