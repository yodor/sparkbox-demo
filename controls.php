<?php
include_once("class/pages/DemoPage.php");
include_once("forms/InputForm.php");
include_once("input/DataInputFactory.php");
include_once("beans/MenuItemsBean.php");
include_once("iterators/ArrayDataIterator.php");

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

$f1 = DataInputFactory::Create(InputType::TEXT, "field11", "Text", 1);
$form->addInput($f1);

$f2 = DataInputFactory::Create(InputType::EMAIL, "field12", "Email", 1);
$form->addInput($f2);
//
$f3 = DataInputFactory::Create(InputType::PASSWORD, "field13", "Email", 1);
$form->addInput($f3);

$aw4 = new ArrayDataIterator(createArray("selectItem", 5));
$f4 = DataInputFactory::Create(InputType::SELECT, "field4", "Select", 1);
$f4->getRenderer()->setIterator($aw4);
$f4->getRenderer()->getItemRenderer()->setValueKey(ArrayDataIterator::KEY_ID);
$f4->getRenderer()->getItemRenderer()->setLabelKey(ArrayDataIterator::KEY_VALUE);
$form->addInput($f4);

$aw3 = new ArrayDataIterator(createArray("selectMultiItem", 8));
$f4m = DataInputFactory::Create(InputType::SELECT_MULTI, "field4m", "Select Multiple", 1);
$f4m->getRenderer()->setIterator($aw3);
$f4m->getRenderer()->getItemRenderer()->setValueKey(ArrayDataIterator::KEY_ID);
$f4m->getRenderer()->getItemRenderer()->setLabelKey(ArrayDataIterator::KEY_VALUE);
$form->addInput($f4m);


$f5 = DataInputFactory::Create(InputType::TEXTAREA, "field5", "TextArea", 1);
$form->addInput($f5);

$f6 = DataInputFactory::Create(InputType::CHECKBOX, "field6", "Checkbox Single", 0);
$form->addInput($f6);

$f7 = DataInputFactory::Create(InputType::CHECKBOX, "field7", "Accept Check", 1);
$f7->getRenderer()->setCaption("Accept By Clicking Here");
$form->addInput($f7);


$aw = new ArrayDataIterator(createArray("checkItem", 5));
$f8 = DataInputFactory::Create(InputType::CHECKBOX, "field8", "Checkbox DataSource", 0);
$f8->getRenderer()->setIterator($aw);
$f8->getRenderer()->getItemRenderer()->setValueKey(ArrayDataIterator::KEY_VALUE);
$f8->getRenderer()->getItemRenderer()->setLabelKey(ArrayDataIterator::KEY_VALUE);
$form->addInput($f8);


$aw = new ArrayDataIterator(createArray("checkItemRequired", 5));
$f9 = DataInputFactory::Create(InputType::CHECKBOX, "field9", "Checkbox DataSource", 1);
$f9->getRenderer()->setIterator($aw);
$f9->getRenderer()->getItemRenderer()->setValueKey(ArrayDataIterator::KEY_VALUE);
$f9->getRenderer()->getItemRenderer()->setLabelKey(ArrayDataIterator::KEY_VALUE);
$form->addInput($f9);

$aw1 = new ArrayDataIterator(createArray("radioItem", 3));

$f10 = DataInputFactory::Create(InputType::RADIO, "field10", "Checkbox DataSource", 1);
    new DataInput("field12", "Radiobox DataSource", 1);

$f10->getRenderer()->setIterator($aw1);
$f10->getRenderer()->getItemRenderer()->setValueKey(ArrayDataIterator::KEY_VALUE);
$f10->getRenderer()->getItemRenderer()->setLabelKey(ArrayDataIterator::KEY_VALUE);
$form->addInput($f10);


//$f7 = new DataInput("field7", "Date", 0);
//$df = new DateField($f7);
//$f7->setValidator(new DateValidator());
//
//$form->addInput($f7);
//
//$f8 = new DataInput("field8", "Time", 1);
//$tf = new TimeField($f8);
//$f8->setValidator(new TimeValidator());
//
//$form->addInput($f8);
//
//$f9 = new DataInput("field9", "Phone", 1);
//$pf = new PhoneField($f9);
//$f9->setValidator(new PhoneValidator());
//
//$form->addInput($f9);
//
//$f15 = new DataInput("field15", "Hidden", 0);
//$hf = new HiddenField($f15);
//$form->addInput($f15);
//
//$f17 = DataInputFactory::Create(InputType::CAPTCHA_TEXT, "captcha_text", "Spam Protection", 1);
//$form->addInput($f17);
//
//
//$f18 = DataInputFactory::Create(InputType::CHECKBOX_TREEVIEW, "checkbox_treeview", "Checkbox Treeview", 1);
//
//$bean = new MenuItemsBean();
//$f18->getRenderer()->setIterator(new SQLQuery($bean->selectTree(array("menu_title")), $bean->key(), $bean->getTableName()));
//
//$ir = $f18->getRenderer()->getItemRenderer();
//$ir->setLabelKey("menu_title");
//$ir->setValueKey("menuID");
//
//
//$form->addInput($f18);
//
//
//$f19 = DataInputFactory::Create(InputType::SLIDER, "sliderName", "Slider Example", 1);
//$field = $f19->getRenderer();
//if ($field instanceof SliderField) {
//    $field->setMinimum(10);
//    $field->setMaximum(100);
//    $field->setStep(5);
//}
//$form->addInput($f19);

$frender = new FormRenderer($form);


$proc = new FormProcessor();

if (isset($_GET["type"])) {
    if (strcmp($_GET["type"], "hbox")==0) {
        $frender->setLayout(FormRenderer::LAYOUT_HBOX);
    }
}
$proc->process($form);

$page->startRender();

$buttons = new Container(false);
$buttons->setStyle("display", "flex");
$buttons->setStyle("gap", "1em");
$buttons->setStyle("padding", "1em");

$buttons->items()->append(Button::LocationButton("VBox", new URL("?type=vbox")));
$buttons->items()->append(Button::LocationButton("HBox", new URL("?type=hbox")));

$buttons->render();


$frender->render();

$page->finishRender();

?>