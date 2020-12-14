<?php

namespace BricksDoc;

class Request
{
    /** @var string */
    protected $basePath;

    /** @var string */
    protected $baseUrl;

    /** @var string */
    protected $requestUri;

    public function __construct(Server $server)
    {
        $this->basePath = str_replace(
            $server->get('DOCUMENT_ROOT'),
            '',
            $server->get('SCRIPT_FILENAME')
        );
        $this->basePath = dirname($this->basePath);
        if ('.' == $this->basePath) {
            $this->basePath = '/';
        }

        $this->baseUrl = '//' . rtrim($server->get('HTTP_HOST'), '/') . '/' . $this->basePath;

        $this->requestUri = str_replace($this->basePath == '/' ? '' : $this->basePath, '', $server->get('REQUEST_URI'));
        if ($this->basePath = '/') {
            $this->requestUri = substr($this->requestUri, 1);
        }
        if ('/' != substr($this->requestUri, 0, 1)) {
            $this->requestUri = '/' . $this->requestUri;
        }
    }

    public function getBasePath()
    {
        return $this->basePath;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function getRequestUri()
    {
        return $this->requestUri;
    }
}
