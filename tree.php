<?php
include_once("session.php");
include_once("class/pages/DemoPage.php");

include_once("components/NestedSetTreeView.php");
include_once("components/renderers/items/TextTreeItem.php");

include_once ("beans/MenuItemsBean.php");

$page = new DemoPage();

$bean = new MenuItemsBean();

$ir = new TextTreeItem();

$view = new NestedSetTreeView();
$view->setIterator(new SQLQuery($bean->selectTree(array("menu_title")), $bean->key(), $bean->getTableName()));
$view->setItemRenderer($ir);

$ir->setLabelKey("menu_title");
$ir->setValueKey("menuID");
$ir->enableCheckbox("selectedItems");

$view->setCheckedNodes(1,2);

$ir->getTextAction()->getURL()->add(new DataParameter("menuID"));

//$tv->setName("demo_tree");
//$tv->open_all = FALSE;
//$tv->setIterator();
if (isset($_GET["menuID"])) {
    $view->setSelectedID((int)$_GET["menuID"]);
}

$page->startRender();

$view->render();

$page->finishRender();

?>
