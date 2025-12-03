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

$cart_id = isset($_POST['cart_id']) ? (int)$_POST['cart_id'] : 0;
$session_id = session_id();

if ($cart_id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Missing cart ID.']);
    exit;
}

try {
    $stmt = $mysqli->prepare("
        DELETE FROM cart 
        WHERE cart_id = ? AND session_id = ?
    ");
    $stmt->bind_param("is", $cart_id, $session_id);
    $stmt->execute();

    $success = ($stmt->affected_rows > 0);
    $stmt->close();
    $mysqli->close();
    
    echo json_encode(['success' => $success]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Server error.']);
}
?>