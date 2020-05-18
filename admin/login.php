<?php
include_once("session.php");
include_once("templates/admin/AdminLogin.php");

$cmp = new AdminLogin();
$cmp->render();

?>