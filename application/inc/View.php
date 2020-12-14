<?php

namespace BricksDoc;

class View
{
    public function renderHtml($template, $highlightCode = true)
    {
        if (!file_exists($template)) {
            throw new \RuntimeException('could not render invalid html template: ' . $template);
        }
        $content = file_get_contents($template);
        if ($highlightCode) {
            $content = $this->highlight($content);
        }
        return $content;
    }

    public function highlight($content)
    {
        if (preg_match_all('#<pre><code><\!\[CDATA\[(.*?)\]\]></code></pre>#ims', $content, $matches)) {
            foreach ($matches[0] as $index => $searchString) {

                ob_start();
                highlight_string($matches[1][$index]);
                $replaceString = ob_get_clean();

                $content = str_replace($searchString, $replaceString, $content);
            }
        }
        return $content;
    }
}
