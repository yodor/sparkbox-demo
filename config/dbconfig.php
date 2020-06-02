<?php


$prop = new DBConnectionProperties();
$prop->driver = "MySQLi";

$prop->database="saturnosoftbiz_demo";
$prop->user="saturnosoftbiz_demo";
$prop->pass="OJW]7]2@,h.a";
$prop->host="localhost";
$prop->port="3306";


$prop->setConnectionName("default");
DBConnections::addProperties($prop);
?>
