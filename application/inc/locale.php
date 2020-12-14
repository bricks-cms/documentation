<?php

$allowedLanguages = array_map(function($path) {
    return substr(basename($path), 0, 2);
}, glob('../lang/*.php'));

$locale = in_array($locale = $_COOKIE['locale'] ?? 'de', $allowedLanguages) ? $locale : 'de';

$lang = require dirname(__DIR__) . '/lang/' . $locale . '.php';

function lang($value) {
    return $lang[$value] ?? $value;
}

$title = lang($title);
$description = lang($description);