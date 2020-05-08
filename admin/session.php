<?php

// define("DEBUG_OUTPUT", 1);

$cdir = dirname(__FILE__);
$realpath = realpath($cdir . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR);
include_once($realpath . "/session.php");

include_once("buttons/StyledButton.php");
StyledButton::setDefaultClass("admin_button");


$all_roles = array(

    "ROLE_CONTENT_MENU", "ROLE_CONFIG_MENU", "ROLE_ADMIN_USERS_MENU",

);


foreach ($all_roles as $key => $val) {
    define($val, $val);
}


include_once("utils/MenuItem.php");
$admin_menu = array();

$admin_menu[] = new MenuItem("Store", ADMIN_LOCAL . "store/index.php", "class:store");

$admin_menu[] = new MenuItem("Content", ADMIN_LOCAL . "content/index.php", "class:icon_content");

$admin_menu[] = new MenuItem("Settings", ADMIN_LOCAL . "settings/index.php", "class:icon_settings");


?>