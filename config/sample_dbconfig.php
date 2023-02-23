<?php


$prop = new DBConnectionProperties();
$prop->driver = "MySQLi";

$prop->database="sparkbox_demo";
$prop->user="sparkbox_demo";
$prop->pass="123456";
$prop->host="127.0.0.1";
$prop->port="3306";


$prop->setConnectionName("default");
DBConnections::addProperties($prop);
?>
