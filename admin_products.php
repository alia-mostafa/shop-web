<?php
session_start();
if (!isset($_SESSION['admin_logged'])) {
    header("Location: admin_login.php");
    exit;
}

include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $_POST['name'];
    $desc  = $_POST['description'];
    $price = $_POST['price'];

    $stmt = $mysqli->prepare("
        INSERT INTO product (name, description, price)
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param("ssd", $name, $desc, $price);
    $stmt->execute();
    
    header("Location: admin_products.php");
    exit;
}
?>
