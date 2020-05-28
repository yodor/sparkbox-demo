<?php
define("STORAGE_REQUEST", 1);

include_once("session.php");
Session::Close();

include_once("storage/BeanDataRequest.php");
$storage = new BeanDataRequest();
?>
