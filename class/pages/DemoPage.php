<?php
include_once("pages/SparkSitePage.php");
include_once("utils/menu/MenuItemList.php");
include_once("utils/menu/MenuItem.php");

/**
 * The frame of the demo - the core site frame (SparkSitePage) with the menu of the demo pages (built here, not in
 * the database) and the demo css. The page class of the main, pages, news and faq modules.
 */
class DemoPage extends SparkSitePage
{
    public function __construct()
    {
        parent::__construct();
        $this->head()->addCSS(Spark::Get(Config::LOCAL) . "/css/demo.css");
    }

    protected function headerLine() : string
    {
        return "The core components of SparkBox, each on a page";
    }

    protected function createMenu() : MenuItemList
    {
        $local = Spark::Get(Config::LOCAL);
        $menu = new MenuItemList();

        $menu->append(new MenuItem("Home", $local . "/"));

        $controls = new MenuItem("Forms", $local . "/controls");
        $controls->append(new MenuItem("Input Controls", $local . "/controls"));
        $controls->append(new MenuItem("Array Controls", $local . "/controls/arrays"));
        $controls->append(new MenuItem("Uploads", $local . "/controls/uploads"));
        $controls->append(new MenuItem("Text Editor", $local . "/controls/editor"));
        $menu->append($controls);

        $menu->append(new MenuItem("Dialogs", $local . "/dialogs"));

        $views = new MenuItem("Views", $local . "/gallery");
        $views->append(new MenuItem("Image Gallery", $local . "/gallery"));
        $views->append(new MenuItem("Tree View", $local . "/tree"));
        $views->append(new MenuItem("Menus", $local . "/menus"));
        $views->append(new MenuItem("Fragments", $local . "/fragments"));
        $menu->append($views);

        $modules = new MenuItem("Modules", $local . "/news/");
        $modules->append(new MenuItem("News", $local . "/news/"));
        $modules->append(new MenuItem("FAQ", $local . "/faq/"));
        $modules->append(new MenuItem("Admin", $local . "/admin/"));
        $menu->append($modules);

        return $menu;
    }
}
