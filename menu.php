<?php
include_once("session.php");
include_once("class/pages/DemoPage.php");
include_once("beans/MenuItemsBean.php");
include_once("components/MenuBarComponent.php");

function constructSubmenu($item, $level, $max_items, $max_level)
{
    $level++;
    $max_items--;

    if ($level > $max_level) return;

    for ($b = 0; $b < $max_items; $b++) {
        $sitem = new MenuItem("$b.MenuItem (Level: $level)", "menu.php?branch=$b&level=$level");
        $item->addMenuItem($sitem);
        constructSubmenu($sitem, $level, $max_items, $max_level);

    }

}

$page = new DemoPage();

$menu = new MainMenu();

$menu->setName("ConstructedMenu");

$arr = array();
for ($a = 0; $a < 1; $a++) {
    $item = new MenuItem("MenuItem " . ($a + 1), "menu.php");

    if ($a < 2) {
        constructSubmenu($item, 0, 6, 3);
    }
    $arr[] = $item;
}

$menu->setMenuItems($arr);

$menu_bar = new MenuBarComponent($menu);
$menu_bar->setName("ConstructedMenu");


$menu1 = new MainMenu();
$menu1->setBean(new MenuItemsBean());
$menu1->setLabelKey("menu_title");
$menu1->setValueKey("menuID");
$menu1->setTargetURL("menu.php");
$menu1->construct();

$menu_bar1 = new MenuBarComponent($menu1);
$menu_bar1->setName("MenuItemsBean");



$page->startRender();

$menu_bar->render();

echo "<BR><BR><BR><BR><BR><BR><BR><BR>";

$menu_bar1->render();

echo "<div class=clear></div>";

$page->finishRender();

?>