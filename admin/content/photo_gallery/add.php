<?php
include_once("session.php");
include_once ("templates/admin/BeanEditorPage.php");
include_once("class/beans/GalleryPhotosBean.php");

include_once("forms/PhotoForm.php");

$cmp = new BeanEditorPage();

$cmp->setBean(new GalleryPhotosBean());
$cmp->setForm(new PhotoForm());

$cmp->render();

?>
