<?php

namespace BricksDoc;

class Locale
{
    const DEFAULT_LANGUAGE = 'de';

    /** @var Request */
    protected $request;

    protected $allowedLanguages = [];

    /** @var string */
    protected $currentLanguage;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->setLanguageFromRequest();
    }

    public function getCurrentLanguage()
    {
        return $this->currentLanguage;
    }

    public function getAllowedLanguages()
    {
        if (!$this->allowedLanguages) {
            $this->allowedLanguages = array_map(function($path) {
                return substr(basename($path), 0, 2);
            }, glob(dirname(__DIR__) . '/lang/*.php'));
        }
        return $this->allowedLanguages;
    }

    protected function setLanguageFromRequest()
    {
        $basePath = str_replace(
            ($this->request->getBasePath() == '/' ? '' : $this->request->getBasePath()),
            '',
            $this->request->getRequestUri()
        );

        if ($basePath == '/') {
            $this->currentLanguage = static::DEFAULT_LANGUAGE;
            return;
        }

        $requestUriPath = $this->request->getRequestUri();
        if (substr($requestUriPath,-4) == '.html') {
            $requestUriPath = dirname($requestUriPath);
        }

        $allowedLanguages = $this->getAllowedLanguages();
        $requestedLang = substr($requestUriPath, 1, 2);
        if (in_array($requestedLang, $allowedLanguages)) {
            $this->currentLanguage = $requestedLang;
            return;
        }

        $this->currentLanguage = static::DEFAULT_LANGUAGE;
    }
}
