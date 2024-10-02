<?php
include_once("session.php");

include_once("class/pages/DemoPage.php");
include_once("iterators/ArrayDataIterator.php");

$page = new DemoPage();

$form = new InputForm();

//Array of TextField
$textField = new ArrayDataInput("textField", "Text", 0);

$arf1 = new ArrayField(new TextField($textField));

$textField->setValidator(new EmptyValueValidator());
new InputProcessor($textField);

$form->addInput($textField);
//

//Array of TextArea
$textArea = new ArrayDataInput("textArea", "Text Area", 1);

$textArea->setValidator(new EmptyValueValidator());
new ArrayField(new TextArea($textArea));
new InputProcessor($textArea);
$form->addInput($textArea);
//

//Array of SelectField
$selectArrayData = new ArrayDataInput("selectField", "Select", 1);


$select_items = new ArrayDataIterator(array("Select Item 1", "Select Item 2", "Select Item 3"));
$sr = new SelectField($selectArrayData);
$sr->setIterator($select_items);
$sr->getItemRenderer()->setValueKey(ArrayDataIterator::KEY_ID);
$sr->getItemRenderer()->setLabelKey(ArrayDataIterator::KEY_VALUE);
new ArrayField($sr);

$selectArrayData->setValidator(new EmptyValueValidator());
new InputProcessor($selectArrayData);

$form->addInput($selectArrayData);
//

//Array of CheckField
$checkField = new ArrayDataInput("checkField", "Checkbox", 1);

$check_items = new ArrayDataIterator(array("CItem1", "CItem2", "CItem3"));
$cr = new CheckField($checkField);
$cr->setIterator($check_items);
$cr->getItemRenderer()->setValueKey(ArrayDataIterator::KEY_VALUE);
$cr->getItemRenderer()->setLabelKey(ArrayDataIterator::KEY_VALUE);

$checkField->setValidator(new EmptyValueValidator());
new ArrayField($cr);
new InputProcessor($checkField);

$form->addInput($checkField);

//Array of RadioField
$radioField = new ArrayDataInput("radioField", "Radio Button", 1);
$radioField->setValidator(new EmptyValueValidator());

$radio_items = new ArrayDataIterator(array("RItem1", "RItem2", "RItem3"));
$rr = new RadioField($radioField);
$rr->setIterator($radio_items);
$rr->getItemRenderer()->setValueKey(ArrayDataIterator::KEY_VALUE);
$rr->getItemRenderer()->setLabelKey(ArrayDataIterator::KEY_VALUE);

new ArrayField($rr);
new InputProcessor($radioField);
$form->addInput($radioField);
//

//Array of PhoneField
$phoneField = new ArrayDataInput("phoneField", "Phone", 1);
//$phoneField->add_field_text = "Add Phone";
//$phoneField->source_label_visible = TRUE;
//$phoneField->append_offset = -1;
$phoneField->setValidator(new PhoneValidator());
//
new ArrayField(new PhoneField($phoneField));
new PhoneInput($phoneField);

$form->addInput($phoneField);
//

//Array of DateField
$dateField = new ArrayDataInput("dateField", "Date", 1);
$dateField->setValidator(new DateValidator());
new ArrayField(new DateField($dateField));
new DateInput($dateField);

$form->addInput($dateField);
//

//Array of TimeField
$timeInput = new ArrayDataInput("timeField", "Time", 1);
$timeInput->setValidator(new TimeValidator());
new ArrayField(new TimeField($timeInput));
new TimeInput($timeInput);

$form->addInput($timeInput);

//
$form_render = new FormRenderer($form);
$form_render->setAttribute("name", "myform");
$form_render->setAttribute("id", "myform");
$form_render->setLayout(FormRenderer::FIELD_HBOX);

$form->setProcessor(new FormProcessor());

$form->getProcessor()->process($form);

$page->startRender();

$form_render->render();

$page->finishRender();

?>
