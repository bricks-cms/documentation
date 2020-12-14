<?php

namespace BricksDoc;

class Server
{
    protected $server = [];

    public function __construct()
    {
        $this->server = $_SERVER;
    }

    public function get($key)
    {
        return $this->server[$key] ?? null;
    }

    public function set($key, $value) : void
    {
        $this->server[$key] = $value;
    }
}