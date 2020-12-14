<?php

require "../inc/functions.php";

$content = getRequestedPage();
try {
    $requestedContent = getRequestedContent();
} catch(Exception $e) {
    if (!if404() && in_array(getLocale(), getAllowedLanguages())) {
        $content = '/501';
        header('HTTP/1.0 501 Not Found');
    } elseif(!if404()) {
        $content = '/404';
        header('HTTP/1.0 404 Not Found');
    }
}

$title = $requestedContent['locale']['title'] ?? 'Bricks';
$description = $requestedContent['locale']['description'] ?? 'Bricks Content Managment &amp; Framework - It&lsquo;s your Content Managment';

require appdir("parts/header.php");
require appdir("parts/navigation.php");

?>

<?php echo render($content); ?>

<?php require appdir("parts/footer.php"); ?>
