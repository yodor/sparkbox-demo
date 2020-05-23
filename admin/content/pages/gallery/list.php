<?php
include_once("session.php");
include_once("templates/admin/GalleryViewPage.php");

include_once("beans/DynamicPagePhotosBean.php");
include_once("beans/DynamicPagesBean.php");


$rc = new BeanKeyCondition(new DynamicPagesBean(), "../list.php", array("item_title"));


$bean = new DynamicPagePhotosBean();

$cmp = new GalleryViewPage();
$cmp->setRequestCondition($rc);

$cmp->setBean($bean);
$cmp->getPage()->setName(tr("Photo Gallery").": " . $rc->getData("item_title"));

$cmp->setBean($bean);

$cmp->render();

?>