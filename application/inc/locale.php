<?php

function getAllowedLanguages()
{
    global $_allowedLanguages;
    if (!$_allowedLanguages) {
        $_allowedLanguages = array_map(function($path) {
            return substr(basename($path), 0, 2);
        }, glob('../lang/*.php'));
    }
    return $_allowedLanguages;
}

function getLocale()
{
    global $_locale;
    if (!$_locale) {
        if ('/' == str_replace(getBaseUrl(), '', $_SERVER['REQUEST_URI'])) {
            $_locale = 'de';
        } else {
            $allowedLanguages = getAllowedLanguages();
            $lang = trim(substr(str_replace(getBaseUrl(), '', $_SERVER['REQUEST_URI']), 0, 4), '/');
            if (strlen($lang) == 2 && in_array($lang, $allowedLanguages)) {
                $_locale = $lang;
            }
        }
    }
    return $_locale;
}

function getLocaleStrings()
{
    global $_localeStrings;
    if (!$_localeStrings) {
        $locale = getLocale();
        if ($locale) {
            $_localeStrings = require dirname(__DIR__) . '/lang/' . $locale . '.php';
        }
    }
    return $_localeStrings;
}

function lang($value) {
    $localeStrings = getLocaleStrings();
    return $localeStrings[$value] ?? $value;
}