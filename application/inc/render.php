<?php

function render($contentPath)
{
    $locale = getLocale() ?: 'de';
    $file = appdir('lang/' . $locale . '/content' . $contentPath) . '.html';
    if (!file_exists($file)) {
        throw new \RuntimeException('could not render invalid content path: ' . $contentPath);
    }
    return highlight(file_get_contents($file));
}