<?php
include_once("class/pages/DemoPage.php");
include_once("components/DynamicPageView.php");
include_once("components/TextComponent.php");
include_once("beans/DynamicPagesBean.php");

$page = new DemoPage();

$cmp = new DynamicPageView();
$cmp->setBean(new DynamicPagesBean());

$cmp->processInput();

$page->startRender();

echo "<div class='inner'>";
$cmp->render();
echo "</div>";

$page->finishRender();


?>