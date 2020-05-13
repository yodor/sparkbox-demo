<?php
include_once("session.php");
include_once("class/pages/DemoPage.php");

$page = new DemoPage();

$form = new InputForm();


include_once("input/renderers/FileField.php");
include_once("input/validators/FileUploadValidator.php");

include_once("input/renderers/ImageField.php");
include_once("input/validators/ImageUploadValidator.php");

include_once("input/processors/UploadDataInput.php");

$f16 = new DataInput("field16", "File Field", 0);
$f16->setRenderer(new FileField($f16));
$f16->setValidator(new FileUploadValidator());
new UploadDataInput($f16);
$form->addInput($f16);

$f17 = new DataInput("field17", "Image Field", 0);

$image_field = new ImageField($f17);
$image_field->setPhotoSize(-1, 128);

$f17->setRenderer($image_field);
$f17->setValidator(new ImageUploadValidator());
new UploadDataInput($f17);
$form->addInput($f17);


$form_render = new FormRenderer($form);
$form_render->setAttribute("name", "myform");
$form_render->setAttribute("id", "myform");

$form->setProcessor(new FormProcessor());

$form->getProcessor()->process($form);

$page->startRender();

$form_render->render();

$page->finishRender();


?>