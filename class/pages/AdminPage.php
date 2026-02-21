<?php
include_once("pages/SparkAdminPage.php");
include_once("components/MenuBar.php");


class AdminPage extends SparkAdminPage
{

    public function __construct()
    {
        parent::__construct();

    }

    protected function initMainMenu() : array
    {
        $menu = array();


        $menu[] = new MenuItem("Съдържание", Spark::Get(Config::ADMIN_LOCAL) . "/content/index.php", "class:icon_content");

        $menu[] = new MenuItem("Настройки", Spark::Get(Config::ADMIN_LOCAL) . "/settings/index.php", "class:icon_settings");


        return $menu;
    }

}

?>