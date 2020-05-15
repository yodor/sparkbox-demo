<?php
include_once("session.php");
include_once("class/pages/AdminPage.php");

include_once("beans/LanguagesBean.php");
include_once("forms/LanguageForm.php");

$menu = array();

$page = new AdminPage("Add Language");
$page->checkAccess(ROLE_CONFIG_MENU);

$view = new BeanFormEditor(new LanguagesBean(), new LanguageForm());

$view->processInput();

$page->startRender($menu);

$view->render();

$page->finishRender();

?>