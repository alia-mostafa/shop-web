<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "db.php";

$session_id = session_id();

$stmt = $mysqli->prepare("
    SELECT c.cart_id, c.quantity, p.name, p.price, pi.image_url 
    FROM cart c
    JOIN product p ON c.product_id = p.product_idا
    LEFT JOIN product_images pi ON pi.product_id = p.product_id AND pi.is_primary = 1
    WHERE c.session_id = ?
");
$stmt->bind_param("s", $session_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
}

$stmt->close();
$mysqli->close();
?>
