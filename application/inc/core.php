<?php

$title = isset($title) ? $title : '';
$description = isset($description) ? $description : 'Bricks Documentation';

function url($path = null) {
    $locale = getLocale() ?: 'de';
    return trim(getBaseUrl(), '/') . '/' . ($path ? $locale . '/' . $path : '');
}

function asset($path = null) {
    return trim(getBaseUrl(),'/') . '/' . $path;
}

function directory($path = null) {
    return dirname(__DIR__) . '/public/' . $path;
}

function appdir($path = null) {
    return dirname(__DIR__) . '/' . $path;
}

function getBaseUrl() {
    return dirname(str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']));
}