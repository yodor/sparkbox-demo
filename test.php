<?php
include_once("session.php");
include_once("class/pages/DemoPage.php");
include_once("components/Image.php");

$page = new DemoPage();

$page->startRender();
?>

<?php
$page->finishRender();
?>
