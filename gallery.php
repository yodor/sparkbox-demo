<?php
include_once("session.php");
include_once("components/GalleryTape.php");

include_once("class/pages/DemoPage.php");
include_once("class/beans/GalleryPhotosBean.php");

$page = new DemoPage();


$bean = new GalleryPhotosBean();
$qry = $bean->query();
$qry->select->order_by = " position ASC ";
$qry->select->fields()->set($bean->key());

$gallery_tape = new GalleryTape();
$gallery_tape->setCaption("Sample Image Gallery");

$gallery_tape->setIterator($qry);
$gallery_tape->setName("GalleryTape.1");
$gallery_tape->setPhotoSize(-1, 160);
$gallery_tape->setBeanClass(get_class($bean));
$page->startRender();

$gallery_tape->render();

$page->finishRender();
?>
