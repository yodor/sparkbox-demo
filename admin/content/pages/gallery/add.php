<?php
include_once("session.php");
include_once("templates/admin/BeanEditorPage.php");
include_once("beans/DynamicPagesBean.php");
include_once("beans/DynamicPagePhotosBean.php");
include_once("forms/PhotoForm.php");


$rc = new BeanKeyCondition(new DynamicPagesBean(), "list.php");

$cmp = new BeanEditorPage();
$cmp->setRequestCondition($rc);

$cmp->setBean(new DynamicPagePhotosBean());
$cmp->setForm(new PhotoForm());
$cmp->render();

?>