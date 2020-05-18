<?php
include_once("session.php");
include_once("templates/admin/GalleryViewPage.php");

include_once("class/beans/GalleryPhotosBean.php");

$bean = new GalleryPhotosBean();

$cmp = new GalleryViewPage();
$cmp->setBean($bean);

$cmp->render();

?>