<?php
session_start();
if (!isset($_SESSION['admin_logged'])) {
    header("Location: admin_login.php");
    exit;
}

include "db.php";
$id = $_GET['id'];

$stmt = $mysqli->prepare("SELECT * FROM product WHERE product_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name  = $_POST['name'];
    $desc  = $_POST['description'];
    $price = $_POST['price'];

    $up = $mysqli->prepare("
        UPDATE product SET name=?, description=?, price=? WHERE product_id=?
    ");
    $up->bind_param("ssdi", $name, $desc, $price, $id);
    $up->execute();

    header("Location: admin_products.php");
    exit;
}
?>
