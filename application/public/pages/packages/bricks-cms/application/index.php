<?php

require "../../../../../inc/functions.php";

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

<div class="content">
    <article>
        <h1><?php echo $packageType; ?></h1>
        <h2><?php echo $curPackage; ?></h2>
        <div id="locale-content">
            <?php require directory('lang/' . $locale . '/content/pages/packages/' . $curPackage . '/home.html'); ?>
        </div>
    </article>
</div>

<?php require directory("footer.php"); ?>
