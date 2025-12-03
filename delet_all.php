<?php
header('Content-Type: application/json');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
    exit;
}

include "db.php";

$session_id = session_id();

try {
    $stmt = $mysqli->prepare("
        DELETE FROM cart 
        WHERE session_id = ?
    ");
    $stmt->bind_param("s", $session_id);
    $stmt->execute();

    $stmt->close();
    $mysqli->close();

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Server error.']);
}
?>
