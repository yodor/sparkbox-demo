<?php
include_once("session.php");
include_once ("templates/admin/BeanEditorPage.php");
include_once("class/beans/GalleryPhotosBean.php");

include_once("forms/PhotoForm.php");

$photos = new GalleryPhotosBean();

$cmp = new BeanEditorPage();

$cmp->setBean($photos);
$cmp->setForm(new PhotoForm());

$cmp->getForm()->getInput("photo")->getProcessor()->transact_mode = InputProcessor::TRANSACT_DBROW;


?>
