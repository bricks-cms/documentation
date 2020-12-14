<?php

function highlight($html)
{
    if (preg_match_all('#<pre><code>(.*?)</code></pre>#ims', $html, $matches)) {
        foreach ($matches[0] as $index => $searchString) {
            ob_start();
            highlight_string(
                str_replace(['<![CDATA[', ']]>'], '', $matches[1][$index]),
            );
            $replaceString = ob_get_clean();

            $html = str_replace($searchString, $replaceString, $html);
        }
    }
    echo $html;
}