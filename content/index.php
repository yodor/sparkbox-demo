<?php
include_once("session.php");
include_once("class/pages/MainPage.php");
include_once("components/DynamicPageView.php");
include_once ("components/TextComponent.php");

$page = new MainPage();

$page->startRender();

echo "<div class='inner'>";
$cmp = new DynamicPageView();
$cmp->render();
echo "</div>";

$page->finishRender();


?>
