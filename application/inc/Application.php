<?php

namespace BricksDoc;

class Application
{
    /** @var string */
    protected $route;

    /** @var string */
    protected $appdir;

    public function __construct(string $route, string $appdir) {
        $this->route = $route;
        $this->appdir = $appdir;
    }

    public function getRouteContentTemplate()
    {
        if ('/' == $this->route) {
            return $this->appdir . '/lang/de/content/home.html';
        }

        if (strlen($this->route) == 3) {
            return $this->appdir . '/lang/' . substr($this->route, 1) . '/content/home.html';
        }

        $lang = substr($this->route, 1, 2);
        $path = substr($this->route, 4);
        return $this->appdir . '/lang/' . $lang . '/content/' . $path . '.html';
    }
}
