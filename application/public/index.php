<?php

require "../inc/application.php";

require appdir("parts/header.php");
require appdir("parts/navigation.php");

?>

<?php echo renderContentTemplate(); ?>

<?php require appdir("parts/footer.php"); ?>
