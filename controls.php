<?php
include_once("session.php");
include_once("class/pages/DemoPage.php");
include_once("forms/InputForm.php");
include_once("iterators/ArrayDataIterator.php");
include_once("input/DataInputFactory.php");
include_once ("beans/MenuItemsBean.php");

function createArray($value, $count) : array
{
    $result = array();
    for($i = 0; $i < $count; $i++) {
        $result[] = $value.$i;
    }
    return $result;
}
$page = new DemoPage();

$form = new InputForm();

$f1 = new DataInput("field1", "Text", 1);
$tf = new TextField($f1);
$form->addInput($f1);

$f2 = new DataInput("field2", "Email", 1);
$tf1 = new TextField($f2);
$f2->setValidator(new EmailValidator());
$form->addInput($f2);
//
$f3 = new DataInput("field3", "Password", 1);
$pf = new PasswordField($f3);
$f3->setValidator(new PasswordValidator());
$form->addInput($f3);

$aw2 = new ArrayDataIterator(createArray("selectItem", 5));

$f4 = new DataInput("field4", "Select", 1);
$scmp = new SelectField($f4);
$scmp->setIterator($aw2);
$scmp->getItemRenderer()->setValueKey(ArrayDataIterator::KEY_ID);
$scmp->getItemRenderer()->setLabelKey(ArrayDataIterator::KEY_VALUE);

$form->addInput($f4);

$aw3 = new ArrayDataIterator(createArray("selectMultiItem", 8));

$f4m = new DataInput("field4m", "Select Multi", 1);
$scmp1 = new SelectMultipleField($f4m);
$scmp1->setIterator($aw3);
$scmp1->getItemRenderer()->setValueKey(ArrayDataIterator::KEY_ID);
$scmp1->getItemRenderer()->setLabelKey(ArrayDataIterator::KEY_VALUE);

$form->addInput($f4m);

$f5 = new DataInput("field5", "Text Area", 1);
$ta = new TextArea($f5);
$form->addInput($f5);

$f6 = new DataInput("field10", "Checkbox Single", 0);
$cf = new CheckField($f6);
$f6->setValidator(new EmptyValueValidator());
new InputProcessor($f6);
$form->addInput($f6);

$f6 = new DataInput("field101", "Accept Check", 1);
$cf1 = new CheckField($f6);
$cf1->setCaption("Accept By Clicking Here");
$f6->setValidator(new EmptyValueValidator());
new InputProcessor($f6);
$form->addInput($f6);

$aw = new ArrayDataIterator(createArray("checkItem", 5));

$f11 = new DataInput("field11", "Checkbox DataSource", 0);
$f11->setValidator(new EmptyValueValidator());
new InputProcessor($f11);

$cf2 = new CheckField($f11);
$cf2->setIterator($aw);
$cf2->getItemRenderer()->setValueKey(ArrayDataIterator::KEY_VALUE);
$cf2->getItemRenderer()->setLabelKey(ArrayDataIterator::KEY_VALUE);

$form->addInput($f11);

$aw = new ArrayDataIterator(createArray("checkItemRequired", 5));

$f11 = new DataInput("field11_required", "Checkbox DataSource", 1);

$validator = new EmptyValueValidator();
$f11->setValidator($validator);

$cf3 = new CheckField($f11);
$cf3->setIterator($aw);
$cf3->getItemRenderer()->setValueKey(ArrayDataIterator::KEY_VALUE);
$cf3->getItemRenderer()->setLabelKey(ArrayDataIterator::KEY_VALUE);

new InputProcessor($f11);

$form->addInput($f11);

$aw1 = new ArrayDataIterator(createArray("radioItem", 3));
$f12 = new DataInput("field12", "Radiobox DataSource", 1);
$rf = new RadioField($f12);
$rf->setIterator($aw1);
$rf->getItemRenderer()->setValueKey(ArrayDataIterator::KEY_VALUE);
$rf->getItemRenderer()->setLabelKey(ArrayDataIterator::KEY_VALUE);

$f12->setValidator(new EmptyValueValidator());
new InputProcessor($f12);
$form->addInput($f12);

$f7 = new DataInput("field7", "Date", 0);
$df = new DateField($f7);
$f7->setValidator(new DateValidator());
new DateInput($f7);
$form->addInput($f7);

$f8 = new DataInput("field8", "Time", 1);
$tf = new TimeField($f8);
$f8->setValidator(new TimeValidator());
new TimeInput($f8);
$form->addInput($f8);

$f9 = new DataInput("field9", "Phone", 1);
$pf = new PhoneField($f9);
$f9->setValidator(new PhoneValidator());
new PhoneInput($f9);
$form->addInput($f9);

$f15 = new DataInput("field15", "Hidden", 0);
$hf = new HiddenField($f15);
$form->addInput($f15);

$f17 = DataInputFactory::Create(DataInputFactory::CAPTCHA_TEXT, "captcha_text", "Spam Protection", 1);
$form->addInput($f17);


$f18 = DataInputFactory::Create(DataInputFactory::CHECKBOX_TREEVIEW, "checkbox_treeview", "Checkbox Treeview", 1);

$bean = new MenuItemsBean();
$f18->getRenderer()->setIterator(new SQLQuery($bean->selectTree(array("menu_title")), $bean->key(), $bean->getTableName()));

$ir = $f18->getRenderer()->getItemRenderer();
$ir->setLabelKey("menu_title");
$ir->setValueKey("menuID");


$form->addInput($f18);


$f19 = DataInputFactory::Create(DataInputFactory::SLIDER, "sliderName", "Slider Example", 1);
$field = $f19->getRenderer();
if ($field instanceof SliderField) {
    $field->setMinimum(10);
    $field->setMaximum(100);
    $field->setStep(5);
}
$form->addInput($f19);

$frender = new FormRenderer($form);

$frender->setLayout(FormRenderer::FIELD_HBOX);

$proc = new FormProcessor();

if (isset($_GET["type"])) {
    if (strcmp($_GET["type"], "vbox")==0) {
        $frender->setLayout(FormRenderer::FIELD_VBOX);
    }
}
$proc->process($form);

$page->startRender();

$buttons = new Container(false);
$buttons->setStyleProperty("display", "block");
$buttons->setStyleProperty("text-align", "center");
$buttons->setStyleProperty("padding", "1em");
$buttons->items()->append(Button::LocationButton("HBox", new URL("?type=hbox")));
$buttons->items()->append(Button::LocationButton("VBox", new URL("?type=vbox")));
$buttons->render();


$frender->render();

$page->finishRender();

?>
