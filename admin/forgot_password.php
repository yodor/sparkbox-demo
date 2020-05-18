<?php
include_once("session.php");
include_once("templates/admin/AdminLoginForgotPassword.php");

$cmp = new AdminLoginForgotPassword();
$cmp->render();

?>