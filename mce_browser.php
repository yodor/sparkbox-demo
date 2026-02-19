<?php
include_once("session.php");
include_once("class/pages/DemoPage.php");
include_once("forms/InputForm.php");

$page = new DemoPage();

$form = new InputForm();

$input = DataInputFactory::Create(InputType::MCE_TEXTAREA, "text", "Text", 1);
$form->addInput($input);
$handler = $input->getRenderer()->getImageBrowser()->getResponder();

$handler->setSection("mce_image_demo", "text");
$handler->setOwnerID(-1);

$form_render = new FormRenderer($form);
$form_render->getSubmitButton()->setContents("Preview");

$proc = new FormProcessor();

$proc->process($form);

$page->startRender();

$form_render->render();

echo "<div class='Caption'>Result</div>";
//echo "<HR>";
//echo attributeValue($form->getInput("text")->getValue());
echo "<HR>";
echo DBConnections::Open()->escape($input->getValue());

$page->finishRender();
?>