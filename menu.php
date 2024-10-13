<?php
include_once("session.php");
include_once("class/pages/DemoPage.php");
include_once("beans/MenuItemsBean.php");
include_once("utils/menu/BeanMenuFactory.php");
include_once("components/MenuBar.php");

function constructSubmenu($item, $level, $max_items, $max_level)
{
    $level++;
    $max_items--;

    if ($level > $max_level) return;

    for ($b = 0; $b < $max_items; $b++) {
        $sitem = new MenuItem("$b.MenuItem (Level: $level)", "menu.php?branch=$b&level=$level");
        $item->append($sitem);
        constructSubmenu($sitem, $level, $max_items, $max_level);

    }

}

$page = new DemoPage();

$menu = new MenuItemList();
$menu->setName("ConstructedMenu");

for ($a = 0; $a < 1; $a++) {
    $item = new MenuItem("MenuItem " . ($a + 1), "menu.php");

    if ($a < 2) {
        constructSubmenu($item, 0, 6, 3);
    }
    $menu->append($item);
}



$menu_bar = new MenuBar($menu);

$menuFactory = new BeanMenuFactory(new MenuItemsBean(), "menu_title", "menuID");


$menu_bar1 = new MenuBar($menuFactory->menu());




$page->startRender();

$menu_bar->render();

echo "<BR><BR><BR><BR><BR><BR><BR><BR>";

$menu_bar1->render();

echo "<div class=clear></div>";

$page->finishRender();

?>