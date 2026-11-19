<?php
//
//SparkBox boot script - set as auto prepend from .user.ini (or the .htaccess for mod_php)
//
//Location: APP_PATH/
//
define("APP_PATH", realpath(__DIR__));
require_once(APP_PATH."/config/boot.php");
require_once("sparkbox.php");
