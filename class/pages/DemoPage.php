<?php
include_once("pages/SparkPage.php");

include_once("utils/menu/MenuItemList.php");
include_once("components/MenuBarComponent.php");

include_once("forms/InputForm.php");
include_once("forms/renderers/FormRenderer.php");
include_once("forms/processors/FormProcessor.php");
include_once("input/DataInputFactory.php");

class DemoPage extends SparkPage
{

    protected $menu_bar;

    public function __construct()
    {

        parent::__construct();

        $menu = new MenuItemList();


        $item = new MenuItem("Controls", LOCAL . "/controls.php");

        $item1 = new MenuItem("Array Controls", LOCAL . "/array_controls.php");
        $item->append($item1);
        $item2 = new MenuItem("AJAX Upload", LOCAL . "/ajax_upload.php");
        $item->append($item2);
        $item3 = new MenuItem("Plain Upload", LOCAL . "/upload_controls.php");
        $item->append($item3);

        $menu->append($item);


        $item = new MenuItem("Dialogs", LOCAL . "/dialogs.php");
        $menu->append($item);

        $item = new MenuItem("Image Gallery", LOCAL . "/gallery.php");
        $menu->append($item);

        $item = new MenuItem("MCE Image Browser", LOCAL . "/mce_browser.php");
        $menu->append($item);

        $item = new MenuItem("Menus", LOCAL . "/menu.php");
        $menu->append($item);

        $item = new MenuItem("Tree View", LOCAL . "/tree.php");
        $menu->append($item);

        $item = new MenuItem("Publications", LOCAL . "/news.php");
        $menu->append($item);

        $item = new MenuItem("Test", LOCAL . "/test.php");
        $menu->append($item);

        $this->menu_bar = new MenuBarComponent($menu);

        $this->menu_bar->setName("DemoPage");

        $this->head()->addCSS(LOCAL . "/css/DemoPage.css");


    }

    public function startRender()
    {
        parent::startRender();

        echo "\n<!-- startRender DemoPage -->\n";

        $main_menu = $this->menu_bar->getMenu();
        $main_menu->selectActive();

        $this->preferred_title = constructSiteTitle($main_menu->getSelectedPath());

        echo "<div align=center>";

        $this->menu_bar->render();

        echo "<div class='main_content'>"; //inner contents

    }

    public function finishRender()
    {

        echo "</div>"; //main_content
        echo "</div>"; //align=center

        echo "\n";
        echo "\n<!-- finishRender DemoPage-->\n";

        parent::finishRender();

    }

}

?>
