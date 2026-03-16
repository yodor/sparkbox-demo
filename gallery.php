<?php
include_once("components/GalleryTape.php");

include_once("class/pages/DemoPage.php");
include_once("class/beans/GalleryPhotosBean.php");

$page = new DemoPage();


$bean = new GalleryPhotosBean();
$qry = $bean->query();
$qry->stmt->order_by = " position ASC ";
$qry->stmt->set($bean->key());

$item = new GalleryTapeItem();
$item->setPhotoSize(-1,160);
$item->setBeanClass(get_class($bean));

$gallery_tape = new GalleryTape();
$gallery_tape->setItemRenderer($item);

$gallery_tape->setName("GalleryTape.1");

$gallery_tape->setCaption("Sample Image Gallery");

$gallery_tape->setIterator($qry);

$page->startRender();

$gallery_tape->render();

$page->finishRender();
?>