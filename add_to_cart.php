<?php
header('Content-Type: application/json');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "db.php"; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
    exit;
}

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$quantity_to_add = 1; 
$session_id = session_id();

if ($product_id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid product ID.']);
    exit;
}

try {
    $stmt = $mysqli->prepare("
        SELECT cart_id, quantity 
        FROM cart 
        WHERE product_id = ? AND session_id = ?
    ");
    $stmt->bind_param("is", $product_id, $session_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $new_quantity = $row['quantity'] + $quantity_to_add;
        $update_stmt = $mysqli->prepare("
            UPDATE cart SET quantity = ? WHERE cart_id = ?
        ");
        $update_stmt->bind_param("ii", $new_quantity, $row['cart_id']);
        $update_stmt->execute();
        $update_stmt->close();
        
    } else {
        $insert_stmt = $mysqli->prepare("
            INSERT INTO cart (product_id, quantity, session_id) 
            VALUES (?, ?, ?)
        ");
        $insert_stmt->bind_param("iis", $product_id, $quantity_to_add, $session_id);
        $insert_stmt->execute();
        $insert_stmt->close();
    }

    $stmt->close();
    $mysqli->close();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    http_response_code(500);
    error_log($e->getMessage()); 
    echo json_encode(['success' => false, 'error' => 'Server error occurred.']);
}
?>