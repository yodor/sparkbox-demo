<?php
include_once("class/templates/modules/main/content/DemoContent.php");
include_once("class/beans/DemoTreeBean.php");
include_once("components/MenuBar.php");
include_once("utils/menu/MenuItemList.php");
include_once("utils/menu/MenuItem.php");
include_once("utils/menu/BeanMenuFactory.php");

/**
 * MenuBar: a menu built in code (three levels of submenus) and a menu of a bean (BeanMenuFactory - here the nodes of
 * the tree view page)
 */
class MenusContent extends DemoContent
{
    public function initialize() : void
    {
        $this->start("menus", "<p><code>MenuBar</code> renders a <code>MenuItemList</code>: built in code, or read from a " .
            "nested set bean by <code>BeanMenuFactory</code> (the main menu of a site comes from Content &gt; Menus " .
            "of the admin). The item of the requested address is selected (<code>selectActive()</code>).</p>");

        $local = Spark::Get(Config::LOCAL);

        $this->heading("Built in code");
        $menu = new MenuItemList();
        for ($a = 1; $a <= 3; $a++) {
            $item = new MenuItem("Item $a", $local . "/menus?item=$a");
            $this->submenu($item, "$a", 1);
            $menu->append($item);
        }
        $bar = new MenuBar($menu);
        $bar->setName("CodeMenu");
        $this->cmp->items()->append($bar);

        $this->heading("Read from a bean");
        $tree = new DemoTreeBean();
        $tree->seed();
        $factory = new BeanMenuFactory($tree, "node_name", $tree->key());
        $beanBar = new MenuBar($factory->menu());
        $beanBar->setName("BeanMenu");
        $this->cmp->items()->append($beanBar);
    }

    /**
     * Three items under '$item' - down to the third level
     */
    protected function submenu(MenuItem $item, string $path, int $level) : void
    {
        if ($level > 3) return;
        for ($b = 1; $b <= 3; $b++) {
            $sub = new MenuItem("Item $path.$b", Spark::Get(Config::LOCAL) . "/menus?item=$path.$b");
            $this->submenu($sub, "$path.$b", $level + 1);
            $item->append($sub);
        }
    }

    protected function getContentTitle() : string
    {
        return "Menus";
    }
}
