<?php
//
// sparkbox demo admin menu - after the core menu: Demo > Gallery (the photos of the gallery page)
//
include_once("pages/SparkAdminPage.php");
include_once("utils/menu/MenuItemList.php");
include_once("utils/menu/MenuItem.php");
$menu = SparkAdminPage::Menu() ?? new MenuItemList();

$demo = new MenuItem("Demo", "demo");
$demo->append(new MenuItem("Gallery", "gallery"));
$menu->prepend($demo);

SparkAdminPage::SetMenu($menu);
