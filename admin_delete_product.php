<?php
session_start();
if (!isset($_SESSION['admin_logged'])) {
    header("Location: admin_login.php");
    exit;
}

include "db.php";
$id = $_GET['id'];

$stmt = $mysqli->prepare("DELETE FROM product WHERE product_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: admin_products.php");
