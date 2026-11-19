<?php
include_once("class/templates/modules/main/content/DemoContent.php");
include_once("class/beans/DemoTreeBean.php");
include_once("components/NestedSetTreeView.php");
include_once("components/renderers/items/TextTreeItem.php");
include_once("iterators/SelectQuery.php");
include_once("utils/url/DataParameter.php");

/**
 * NestedSetTreeView of a nested set bean (DemoTreeBean): branches open and close, a node is selected by its link
 * (?nodeID=), the checkboxes post the checked nodes
 */
class TreeContent extends DemoContent
{
    public function initialize() : void
    {
        $this->start("tree", "<p><code>NestedSetTreeView</code> renders a <code>NestedSetBean</code> (lft / rgt) in one " .
            "query. A node links to its page (here the same page with <code>?nodeID=</code> - the node is selected and its " .
            "branch open); <code>TextTreeItem</code> can add a checkbox to each node.</p>");

        $bean = new DemoTreeBean();
        $bean->seed();

        $renderer = new TextTreeItem();
        $renderer->setLabelKey("node_name");
        $renderer->setValueKey($bean->key());
        $renderer->enableCheckbox("checked_nodes");
        $renderer->getTextAction()->getURL()->add(new DataParameter($bean->key()));

        $view = new NestedSetTreeView();
        $view->setIterator(new SelectQuery($bean->selectTree(array("node_name")), $bean->key(), $bean->table()));
        $view->setItemRenderer($renderer);
        if (isset($_GET[$bean->key()])) {
            $view->setSelectedID((int)$_GET[$bean->key()]);
        }
        $this->cmp->items()->append($view);
    }

    protected function getContentTitle() : string
    {
        return "Tree View";
    }
}
