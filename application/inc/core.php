<?php

$title = isset($title) ? $title : '';
$description = isset($description) ? $description : 'Bricks Documentation';

function url($path = null) {
    return getBaseUrl() . $path;
}

function directory($path = null) {
    return dirname(__DIR__) . '/public/' . $path;
}

function getBaseUrl() {
    $path = str_replace(directory(), '', realpath($_SERVER['SCRIPT_FILENAME']));
    $baseUrl = str_replace($path, '', $_SERVER['REQUEST_URI']);
    return $baseUrl;
}