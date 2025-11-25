<?php
session_start();
//database connection
$host = "localhost";
$db_user = "root";   
$db_pass = "";       
$db_name = "myapp";

$mysqli = new mysqli($host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}
?>
