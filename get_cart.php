<?php
header('Content-Type: application/json');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "db.php"; 

$session_id = session_id();
$cart_items = [];

try {
    $stmt = $mysqli->prepare("
        SELECT 
            c.cart_id, 
            c.quantity, 
            p.name, 
            p.price, 
            pi.image_url 
        FROM cart c
        JOIN product p ON c.product_id = p.product_id  
        LEFT JOIN product_images pi ON pi.product_id = p.product_id AND pi.is_primary = 1
        WHERE c.session_id = ?
        ORDER BY c.added_at DESC
    ");
    $stmt->bind_param("s", $session_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $row['price'] = (float)$row['price'];
        $row['quantity'] = (int)$row['quantity'];
        $cart_items[] = $row; 
    }

    $stmt->close();
    $mysqli->close();
    
    echo json_encode(['items' => $cart_items, 'success' => true]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error during fetch.']);
}
?>