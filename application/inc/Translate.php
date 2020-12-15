<?php

namespace BricksDoc;

class Translate
{
    /** @var array */
    protected $translation = [];

    public function __construct($lang, $route)
    {
        if (strlen($route) == 1 || strlen($route) == 3) {
            $route = '/home';
        } else {
            $route = substr($route, 3);
        }

        $files = [
            dirname(__DIR__) . '/lang/' . $lang . '.php',
            dirname(__DIR__) . '/lang/' . $lang . '/routes/' . $route . '.php'
        ];

        foreach ($files as $file) {
            if (file_exists($file)) {
                $this->translation = array_merge($this->translation, require $file);
            }
        }
    }

    public function translate($string)
    {
        return $this->translation[$string] ?? $string;
    }
}
