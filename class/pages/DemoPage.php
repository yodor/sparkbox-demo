<?php
include_once("pages/SparkPage.php");

include_once("utils/menu/MenuItemList.php");
include_once("components/MenuBar.php");

include_once("forms/InputForm.php");
include_once("forms/renderers/FormRenderer.php");
include_once("forms/processors/FormProcessor.php");
include_once("input/DataInputFactory.php");

class DemoPage extends SparkPage
{

    protected MenuBar $menu_bar;

    public function __construct()
    {

        parent::__construct();

        $menu = new MenuItemList();


        $item = new MenuItem("Controls", Spark::Get(Config::LOCAL) . "/controls.php");

        $item1 = new MenuItem("Array Controls", Spark::Get(Config::LOCAL) . "/array_controls.php");
        $item->append($item1);
        $item2 = new MenuItem("AJAX Upload", Spark::Get(Config::LOCAL) . "/ajax_upload.php");
        $item->append($item2);
        $item3 = new MenuItem("AJAX Chunk Upload", Spark::Get(Config::LOCAL) . "/ajax_chunkupload.php");
        $item->append($item3);

        $item3 = new MenuItem("Plain Upload", Spark::Get(Config::LOCAL) . "/upload_controls.php");
        $item->append($item3);

        $menu->append($item);


        $item = new MenuItem("Dialogs", Spark::Get(Config::LOCAL) . "/dialogs.php");
        $menu->append($item);

        $item = new MenuItem("Image Gallery", Spark::Get(Config::LOCAL) . "/gallery.php");
        $menu->append($item);

        $item = new MenuItem("MCE Image Browser", Spark::Get(Config::LOCAL) . "/mce_browser.php");
        $menu->append($item);

        $item = new MenuItem("Menus", Spark::Get(Config::LOCAL) . "/menu.php");
        $menu->append($item);

        $item = new MenuItem("Tree View", Spark::Get(Config::LOCAL) . "/tree.php");
        $menu->append($item);

        $item = new MenuItem("Publications", Spark::Get(Config::LOCAL) . "/news.php");
        $menu->append($item);

        $item = new MenuItem("Test", Spark::Get(Config::LOCAL) . "/test.php");
        $menu->append($item);

        $menu->setName("DemoPage");

        $this->menu_bar = new MenuBar($menu);

        $this->head()->addCSS(Spark::Get(Config::LOCAL) . "/css/DemoPage.css");


    }

    public function startRender(): void
    {
        $main_menu = $this->menu_bar->getMenu();
        $main_menu->selectActive();

        $this->setTitle(Spark::SiteTitle($main_menu->getSelectedPath()));

        parent::startRender();

        $this->menu_bar->render();

        echo "<div class='main_content'>"; //inner contents

    }

    public function finishRender(): void
    {

        echo "</div>"; //main_content

        parent::finishRender();

    }

}

?>