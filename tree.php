<?php
include_once("session.php");
include_once("class/pages/DemoPage.php");

include_once("components/NestedSetTreeView.php");
include_once("components/renderers/items/TextTreeItem.php");
include_once("class/beans/ProductCategoriesBean.php");
include_once("utils/NestedSetFilterProcessor.php");

$page = new DemoPage();

$bean = new ProductCategoriesBean();

$ir = new TextTreeItem();
// $ir->addAction(new Action("Up", "?cmd=reposition&direction=left", array(new ActionParameter("item_id", $bean->key()))));
// $ir->addAction(new Action("Down", "?cmd=reposition&direction=right", array(new ActionParameter("item_id", $bean->key()))));

$ir->addAction(new Action("Edit", "tree.php", array(//       new ActionParameter($bean->key(), $bean->key()),
                                                    new ActionParameter("editID", $bean->key()),)));

$ir->setLabelKey("category_name");

$tv = new NestedSetTreeView();

$tv->setItemRenderer($ir);

$tv->setName("demo_tree");
$tv->open_all = FALSE;
$tv->setItemIterator(new SQLQuery($bean->selectTree(array("category_name")), $bean->key(), $bean->getTableName()));

$proc = new NestedSetFilterProcessor();
$proc->process($tv);

// $tv->processFilters();

$page->startRender();

$tv->render();

$page->finishRender();

?>