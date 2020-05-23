<?php
include_once("session.php");
include_once("templates/admin/FAQItemsListPage.php");

$cmp = new FAQItemsListPage();
$cmp->getPage()->navigation()->clear();

$cmp->render();
?>