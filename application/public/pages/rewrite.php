<?php

require "../../inc/functions.php";

$curPackage = dirname(str_replace(
    [directory(), 'pages/packages/'],
    '',
    realpath($_SERVER['SCRIPT_FILENAME'])
));

$packageType = ucwords(str_replace('-', ' ', dirname($curPackage)));

$title = $curPackage;
$description = $packageType;

require directory("header.php");
require directory("navigation.php");

?>

<?php
    $html = file_get_contents(directory('lang/' . $locale . '/content/pages/rewrite.html'));
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
?>

<?php require directory("footer.php"); ?>
