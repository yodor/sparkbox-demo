<?php
include_once("session.php");

include_once("class/pages/DemoPage.php");
include_once("forms/InputForm.php");
include_once("input/DataInputFactory.php");

$page = new DemoPage();

$form = new InputForm();

$input = DataInputFactory::Create(DataInputFactory::SESSION_IMAGE, "photo", "Photo", 1);
$input->getProcessor()->setTransactBeanItemLimit(4);
$form->addInput($input);

$input = DataInputFactory::Create(DataInputFactory::SESSION_FILE, "document", "Document", 1);
$form->addInput($input);

$form_render = new FormRenderer($form);
$form->setRenderer($form_render);
$form->setProcessor(new FormProcessor());
$form->getProcessor()->process($form);

$page->startRender();

$form_render->render();

$page->finishRender();
?>
