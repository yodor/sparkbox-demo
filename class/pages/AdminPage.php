<?php
include_once("pages/SparkAdminPage.php");
include_once("components/MenuBarComponent.php");

class AdminPage extends SparkAdminPage
{

    public function __construct()
    {
        parent::__construct();

        $this->addCSS(LOCAL . "/css/AdminPage.css", FALSE);
    }

}

?>
