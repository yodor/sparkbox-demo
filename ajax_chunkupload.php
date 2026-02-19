<?php
include_once("session.php");

include_once("class/pages/DemoPage.php");
include_once("forms/InputForm.php");
include_once("input/DataInputFactory.php");

$page = new DemoPage();

$form = new InputForm();


$input = DataInputFactory::Create(InputType::SESSION_FILE, "document", "Chunk File Upload Document", 1);
$chunk_size = (5 * 1024 * 1024);//5MB
//debug
$chunk_size = (5 * 1024 );//5KB
$input->getRenderer()->setAttribute("chunk_size", $chunk_size);
$form->addInput($input);

$form_render = new FormRenderer($form);
$form->setRenderer($form_render);
$form->setProcessor(new FormProcessor());
$form->getProcessor()->process($form);

$page->startRender();

$form_render->render();

$page->finishRender();
?>