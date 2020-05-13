<?php
include_once("session.php");
include_once("class/pages/DemoPage.php");
include_once("forms/InputForm.php");

$page = new DemoPage();

$form = new InputForm();

$input = DataInputFactory::Create(DataInputFactory::MCE_TEXTAREA, "text", "Text", 1);
$form->addInput($input);
$handler = $input->getRenderer()->getImageBrowser()->getHandler();

$handler->setSection("mce_image_demo", "text");
$handler->setOwnerID(-1);

$form_render = new FormRenderer($form);
$form_render->setLayout(FormRenderer::FIELD_VBOX);

$form->setProcessor(new FormProcessor());
$form->getProcessor()->process($form);

$page->startRender();

$form_render->render();

$page->finishRender();
?>