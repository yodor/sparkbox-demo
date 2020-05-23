<?php
include_once("session.php");
include_once("templates/admin/ConfigEditorPage.php");
include_once("forms/SEOConfigForm.php");

$cmp = new ConfigEditorPage();
$cmp->setConfigSection("seo");
$cmp->setForm(new SEOConfigForm());

$cmp->getPage()->navigation()->clear();
$cmp->render();

?>